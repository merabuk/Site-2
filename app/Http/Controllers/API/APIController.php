<?php

namespace App\Http\Controllers\API;

use App\Events\LeadAutodistribNeeded;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Http\Requests\ApiLeadStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class APIController extends Controller
{
    /**
     * Сохранение лида по интерфейсу API.
     *
     */
    public function leadStore(ApiLeadStoreRequest $request)
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
            return response()->json('Lead received', 200);
        };
        return response()->json('Empty request detected', 400);
    }
}
