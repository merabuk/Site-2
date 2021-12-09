<?php

namespace App\Http\Controllers;

use App\ModelFilters\LeadFilter;
use App\Models\Lead;
use App\Models\UtmParam;
use App\Models\GetParam;
use App\Models\LeadGroup;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StatisticController extends Controller
{
    public function index(Request $request)
    {

        if (auth()->user()->hasRole('administrator')) {
            //для администратора
            $allLeads = Lead::with(['leadGroup', 'leadStatus'])->get();
            $leads = $allLeads;
            //Группы лидов
            $leadGroups = LeadGroup::get();
            //Динамические заголовки таблицы - параметры
            $utms = UtmParam::orderBy('name')->get();
            $gets = GetParam::orderBy('name')->get();
            $params = $utms->concat($gets)->sortBy('order');
        } else {
            //для пользователя
            $allLeads = auth()->user()->getAllLeads('all');
            $leads = $allLeads;
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

        if (Session::get('leads')) {
            $leads = Session::get('leads');
        }

        return view('statistic.index', compact('params', 'utms', 'gets', 'leads', 'leadGroups', 'leadStatuses', 'allLeads'));
    }

    public function filterBy (Request $request)
    {
        $leads = Lead::filter($request->all(), LeadFilter::class)->get();
        return back()->with(['leads' => $leads])->withInput();
    }

}
