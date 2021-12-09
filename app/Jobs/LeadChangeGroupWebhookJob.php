<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Lead;
use Error;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Webhook;

class LeadChangeGroupWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //Lead
    protected $lead;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Lead $lead)
    {
        //Get Lead
        $this->lead = $lead;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //активные Вебхуки
        $activeWebhooks = Webhook::where('enabled', true)->get();
        //отправка данных для каждого вебхука
        foreach ($activeWebhooks as $webhook) {
            //url куда отправлять
            $url = $webhook->url;
            //метод отправки
            $method = $webhook->method;
            //что отправлять из данных лида (коды get/utm параметров)
            $codes = $webhook->data;
            //подготовка данных
            $data_gets = $this->lead->gets->only($codes);
            $data_utms = $this->lead->utms->only($codes);
            $data = $data_gets->merge($data_utms);
            //отправка данных
            switch ($method) {
                case 'get':
                    //отправка GET запроса
                    $response = Http::timeout(3)->get($url, $data->toArray());
                    break;
                case 'post':
                    //отправка POST запроса с JSON данными
                    $response = Http::timeout(3)->post($url, $data->toArray());
                    break;
            };
        };
    }
}
