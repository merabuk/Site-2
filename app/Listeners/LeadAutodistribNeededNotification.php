<?php

namespace App\Listeners;

use App\Events\LeadAutodistribNeeded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LeadGroup;
use App\Models\Webhook;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Schema\Builder;
use App\Jobs\LeadChangeGroupWebhookJob;

class LeadAutodistribNeededNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LeadAutodistribNeeded  $event
     * @return void
     */
    public function handle(LeadAutodistribNeeded $event)
    {
        //Получаем все работающие группы в данный момент времени
        $nowTime = Carbon::now()->format('H:i:m');
        $workingGroups = LeadGroup::withCount('leads')
                                    ->whereTime('open', '<', $nowTime)
                                    ->whereTime('close', '>', $nowTime)
                                    ->where('enabled', true)
                                    ->get();
        //Отсеиваем группы которые уже заполнены по максимуму
        $emptyGroups = $workingGroups->filter(function ($group, $key) {
            return $group->leads_count < $group->max_leads;
        });
        //Расчитываем приоритет групп
        if ($emptyGroups->isNotEmpty()) {
            $priorityGroups = $emptyGroups->sortByDesc(function ($group, $key) {
                return ($group->max_leads - $group->leads->count())*$group->k_leads/100;
            });
            //выбираем самую приоритетную группу
            $selectedGroup = $priorityGroups->first();
            //присваиваем лиду эту группу
            $event->lead->leadGroup()->associate($selectedGroup);
            $event->lead->save();
            //вебхук - у лида изменена группа (офис) - ставим в очередь обработчик
            LeadChangeGroupWebhookJob::dispatchIf(Webhook::isEnabledWebhookExists(), $event->lead);
        };
    }
}
