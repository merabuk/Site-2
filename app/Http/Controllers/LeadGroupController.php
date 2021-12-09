<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadGroup;
use App\Models\UserGroup;
use App\Models\GetParam;
use App\Models\Webhook;
use Illuminate\Http\Request;
use App\Http\Requests\LeadGroupStoreRequest;
use App\Http\Requests\LeadGroupUpdateFieldRequest;
use App\Http\Requests\LeadGroupUpdateRequest;
use App\Jobs\LeadChangeGroupWebhookJob;
use App\Models\Token;

class LeadGroupController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(LeadGroup::class, 'lead_group');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leadGroups = LeadGroup::get();
        $token = Token::latest()->first();
        return view('leadGroups.index', compact('leadGroups', 'token'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leadGroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadGroupStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $createdLeadGroup = LeadGroup::create($validatedRequest);
        return redirect()->route('lead-groups.index')->with('success', 'Группа лидов создана.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadGroup  $leadGroup
     * @return \Illuminate\Http\Response
     */
    public function show(LeadGroup $leadGroup)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadGroup  $leadGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadGroup $leadGroup)
    {
        $gets = GetParam::whereIn('code', ['buyer', 'phone', 'email'])->orderBy('name')->get();
        $params = $gets;

        $userGroups = UserGroup::with('leadGroups')->get();
        //фильтрация групп пользователей не привязанных к группе лидов
        $unLeadGroupUserGroups = $userGroups->filter(function ($userGroup) use ($leadGroup){
            if ($userGroup->leadGroups->isNotEmpty()) {
                if (in_array($leadGroup->id, $userGroup->leadGroups->pluck('id')->toArray())){
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        });
        $newLeads =  Lead::where('lead_group_id', null)->get();

        return view('leadGroups.edit', compact('leadGroup', 'unLeadGroupUserGroups', 'newLeads', 'params'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadGroup  $leadGroup
     * @return \Illuminate\Http\Response
     */
    public function update(LeadGroupUpdateRequest $request, LeadGroup $leadGroup)
    {
        $validatedRequest = $request->validated();
        $leadGroup->update($validatedRequest);
        return redirect()->route('lead-groups.index')->with('success', 'Группа лидов отредактирована.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadGroup  $leadGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LeadGroup $leadGroup)
    {
        $leadGroup->delete();
        if ($request->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }

    /**
     * Добавление лидов в группу лидов
     * $leadGroup для группы Новые = 0
     */
    public function addLeads(Request $request, $leadGroup)
    {
        $leadIds = $request['ids'];
        $leads = Lead::whereIn('id', $leadIds)->get();
        $group = LeadGroup::find($leadGroup);
        //если ID группы <> 0, найдены лиды по их айди -> присваиваем им выбранную группу
        if ($leadGroup && $leads->count()) {
            $group->leads()->saveMany($leads);
            //вебхук - у лида изменена группа (офис) - ставим в очередь обработчик
                foreach ($group->leads as $lead) {
                    LeadChangeGroupWebhookJob::dispatchIf(Webhook::isEnabledWebhookExists(), $lead);
                }
        };
        //если ID группы == 0, найдены лиды по их айди -> присваиваем им группу НОВЫЕ
        if (!$leadGroup && $leads->count()) {
            foreach ($leads as $lead) {
                $lead->leadGroup()->dissociate();
                $lead->save();
                //вебхук - у лида изменена группа (офис) - ставим в очередь обработчик
                LeadChangeGroupWebhookJob::dispatchIf(Webhook::isEnabledWebhookExists(), $lead);
            }
        };
        return response('added');
    }

    /**
     * Открепить группу пользователей из группы лидов.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadGroup $leadGroup
     * @param  \App\Models\UserGroup $userGroup
     * @return \Illuminate\Http\Response
     */
    public function removeUserGroupFromLeadGroup(Request $request, LeadGroup $leadGroup, UserGroup $userGroup)
    {
        if ($request->ajax()) {
            $leadGroup->userGroups()->detach($userGroup->id);
            return response('deleted');
        }
    }

    /**
     * Открепить группу пользователей из группы лидов.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadGroup $leadGroup
     * @return \Illuminate\Http\Response
     */
    public function removeUserGroupsFromLeadGroup(Request $request, LeadGroup $leadGroup)
    {
        if ($request->ajax()) {
            if (isset($request['userGroupsIds'])) {
                $leadGroup->userGroups()->detach($request['userGroupsIds']);
                return response('deleted');
            }
            return response('fail');
        }
    }

    /**
     * Прикрепить группу пользователя/пользователей к группе лидов.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadGroup $leadGroup
     * @return \Illuminate\Http\Response
     */
    public function addUserGroupsToLeadGroup(Request $request, LeadGroup $leadGroup)
    {
        if ($request->ajax()) {
            if (isset($request['userGroupsIds'])) {
                $leadGroup->userGroups()->attach($request['userGroupsIds']);
                return response('added');
            }
            return response('fail');
        }
    }

    /**
     * Отвязать лид от группы лидов.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function removeLead(Request $request, Lead $lead)
    {
        if ($request->ajax()) {
            $lead->leadGroup()->dissociate();
            $lead->save();
            return response('deleted');
        }
    }

    /**
     * Отвязать лидов от группы лидов.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function removeLeads(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request['leadsIds'])) {
                $leads = Lead::whereIn('id', $request['leadsIds'])->get();
                $leads->each(function ($lead) {
                    $lead->leadGroup()->dissociate();
                    $lead->save();
                });
                return response('deleted');
            }
            return response('fail');
        }
    }

    public function updateGroup(LeadGroupUpdateFieldRequest $request, LeadGroup $leadGroup)
    {
        $validatedRequest = $request->validated();
        $leadGroup->update($validatedRequest);
        return response()->json($leadGroup, 200);
    }
}
