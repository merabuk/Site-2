<?php

namespace App\Http\Controllers;

use App\Events\LeadAutodistribNeeded;
use App\Models\Lead;
use App\Models\GetParam;
use App\Models\UtmParam;
use Illuminate\Http\Request;
use App\Http\Requests\LeadStoreRequest;
use App\Http\Requests\LeadUpdateRequest;
use App\Listeners\LeadAutodistribNeededNotification;
use App\Models\LeadGroup;
use App\Models\LeadStatus;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Lead::class, 'lead');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Фильтр по группам
        if (isset($request['group'])) {
            $group = $request['group'];
        } else {
            $group = 'all';
        }
        // $group = $request->input('group');

        if (auth()->user()->hasRole('administrator')) {
            //для администратора
            //Лиды для выбранной группы/все/новые
            $leads = Lead::ForGroup($group)->with(['leadGroup', 'leadStatus'])->get();
            //Количество лидов всего и новых
            $allLeadsCount = Lead::ForGroup('all')->count();
            $newLeadsCount = Lead::ForGroup('new')->count();
            //Группы лидов
            $leadGroups = LeadGroup::get();
            //Динамические заголовки таблицы - параметры
            $utms = UtmParam::orderBy('name')->get();
            $gets = GetParam::orderBy('name')->get();
            $params = $utms->concat($gets)->sortBy('order');
        } else {
            //для пользователя
            //Лиды для выбранной группы/все/новые
            $leads = auth()->user()->getAllLeads($group);
            //Количество лидов всего и новых
            $allLeadsCount = auth()->user()->getAllLeads('all')->count();
            $newLeadsCount = auth()->user()->getAllLeads('new')->count();
            //Группы лидов
            $leadGroups = auth()->user()->userGroups()->with('leadGroups.leads')->get()->pluck('leadGroups')->flatten()->unique('id');
            //Динамические заголовки таблицы - параметры
            $gets = GetParam::whereIn('code', ['buyer', 'phone', 'email', 'product'])->orderBy('name')->get();
            //если у пользователя нет разрешенеия на просмотр параметра лида Телефон
            if (!auth()->user()->hasPermission('lead-show-get-param-phone') || !auth()->user()->roles->first()->hasPermission('lead-show-get-param-phone')) {
                $gets = $gets->filter(function ($param) {
                    return $param->code != 'phone';
                });
            }
            //если у пользователя нет разрешенеия на просмотр параметра лида Email
            if (!auth()->user()->hasPermission('lead-show-get-param-email') || !auth()->user()->roles->first()->hasPermission('lead-show-get-param-email')) {
                $gets = $gets->filter(function ($param) {
                    return $param->code != 'email';
                });
            }
            $params = $gets->sortBy('order');
        };
        //Статусы лидов
        $leadStatuses = LeadStatus::get();
        //Пользователи
        $users = User::with('roles')->get()->filter(function ($user) {
            if (in_array('administrator', $user->roles->pluck('name')->toArray())){
                return false;
            } else {
                return true;
            }
        });

        return view('leads.index', compact('params', 'leads', 'allLeadsCount', 'newLeadsCount', 'leadGroups', 'leadStatuses', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $utms = UtmParam::orderBy('name')->get();
        $gets = GetParam::orderBy('name')->get();
        return view('leads.create', compact('utms', 'gets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadStoreRequest $request)
    {
        $validatedRequest = $request->validated();
        //Отсеиваем GET параметры
        $gets = Arr::where($validatedRequest, function ($value, $key) {
            return ((isset($value)) && (!Str::startsWith($key, ['utm_'])));
        });
        //Отсеиваем UTM параметры
        $utms = Arr::where($validatedRequest, function ($value, $key) {
            return ((isset($value)) && (Str::startsWith($key, ['utm_'])));
        });
        //перегоняем в колекции для правильного кастинга в json
        $gets = collect($gets);
        $utms = collect($utms);
        //записываем лида, если хотя бы одна из коллекций не пуста
        if ($gets->isNotEmpty() || $utms->isNotEmpty()) {
            $lead = new Lead();
            $lead->ip = $request->ip();
            $lead->domain = $request->getHost();
            $lead->url = $request->fullUrl();
            $lead->gets = $gets;
            $lead->utms = $utms;
            $lead->save();
            //лида нужно автоматически распределить по группам - вызываем событие
            if (option('auto_leads_ctrl', false)) {
                event(new LeadAutodistribNeeded($lead));
            };
            return redirect()->route('leads.index')->with('success', 'Лид создан');
        };
        return redirect()->route('leads.create')->with('error', 'Лид не создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        $utms = UtmParam::orderBy('name')->get();
        $gets = GetParam::orderBy('name')->whereNotIn('code', ['buyer', 'phone', 'email', 'product', 'price'])->get();
        return view('leads.show', compact('lead', 'utms', 'gets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
    {
        $utms = UtmParam::orderBy('name')->get();
        $gets = GetParam::orderBy('name')->get();
        return view('leads.edit', compact('utms', 'gets', 'lead'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(LeadUpdateRequest $request, Lead $lead)
    {
        $validatedRequest = $request->validated();
        //Отсеиваем GET параметры
        $gets = Arr::where($validatedRequest, function ($value, $key) {
            return ((isset($value)) && (!Str::startsWith($key, ['utm_'])));
        });
        //Отсеиваем UTM параметры
        $utms = Arr::where($validatedRequest, function ($value, $key) {
            return ((isset($value)) && (Str::startsWith($key, ['utm_'])));
        });
        //перегоняем в колекции для правильного кастинга в json
        $gets = collect($gets);
        $utms = collect($utms);
        //записываем лида, если хотя бы одна из коллекций не пуста
        if ($gets->isNotEmpty() || $utms->isNotEmpty()) {
            $lead->ip = $request->ip();
            $lead->domain = $request->getHost();
            $lead->url = $request->fullUrl();
            $lead->gets = $gets;
            $lead->utms = $utms;
            $lead->save();

            return redirect()->route('leads.index')->with('success', 'Лид отредактирован');
        };
        return redirect()->route('leads.edit')->with('error', 'Лид не отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        if (request()->ajax()) {
            return response('deleted');
        }
        return redirect()->back();
    }

    /**
     * Remove many Leads.
     *
     */
    public function destroyMany(Request $request)
    {
        $leadIds = $request['ids'];
        Lead::destroy($leadIds);
        if (request()->ajax()) {
            return response('deleted');
        };
    }
}
