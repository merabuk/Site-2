<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadStatusStoreRequest;
use App\Http\Requests\LeadStatusUpdateRequest;
use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Http\Request;

class LeadStatusController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(LeadStatus::class, 'lead_status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leadStatuses = LeadStatus::get();
        return view('leadStatuses.index', compact('leadStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leadStatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadStatusStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        LeadStatus::create($validatedRequest);
        return redirect()->route('lead-statuses.index')->with('success', 'Cтатус создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return \Illuminate\Http\Response
     */
    public function show(LeadStatus $leadStatus)
    {
        //Desabled in routes!!!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadStatus $leadStatus)
    {
        return view('leadStatuses.edit', compact('leadStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return \Illuminate\Http\Response
     */
    public function update(LeadStatusUpdateRequest $request, LeadStatus $leadStatus)
    {
        $validatedRequest = $request->validated();
        $leadStatus->update($validatedRequest);
        return redirect()->route('lead-statuses.index')->with('success', 'Статус отредактирован.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadStatus $leadStatus)
    {
        $leadStatus->delete();
        if (request()->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }

    /**
     * Изменение статусов лидов
     * $leadStatus для статуса Новые = 0
     */
    public function changeLeadStatus(Request $request, $leadStatus)
    {
        $leadIds = $request['ids'];
        //фильтр id лидов доступных пользователю
        if (!auth()->user()->hasRole('administrator')) {
            $userLeadIds = auth()->user()->getAllLeads('all')->pluck('id')->flatten()->toArray();
            $leadIds = array_filter($leadIds, function ($value) use ($userLeadIds) {
                return in_array($value, $userLeadIds);
            });
        }
        $leads = Lead::whereIn('id', $leadIds)->get();
        $status = LeadStatus::find($leadStatus);
        //если ID статуса <> 0, найдены лиды по их айди -> присваиваем им выбранный статус
        if ($leadStatus && $leads->count()) {
            $status->leads()->saveMany($leads);
            return response('cahged');
        };
        //если ID статуса == 0, найдены лиды по их айди -> присваиваем им статус НОВЫЕ
        if (!$leadStatus && $leads->count()) {
            foreach ($leads as $key => $lead) {
                $lead->leadStatus()->dissociate();
                $lead->save();
            }
            return response('cahged');
        };
        return response('fail');
    }
}
