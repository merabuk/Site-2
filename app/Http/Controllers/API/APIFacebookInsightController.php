<?php

namespace App\Http\Controllers\API;

use App\Common\FacebookInsight;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdsInsights;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

class APIFacebookInsightController extends Controller
{

    public function getInsightRaport()
    {
        $access_token = 'EAAIbsqO3sYMBAFiyp2wNcFoGZByrCUVhmaM1rioHCZAw5HIuZCuK4USHVR3wfSZCNR5v8wyMKlCk4c7ZCWyBPnOeOO8hc2OMW4ZAMcmn3lqJaM9KgeOXflfRZBe2oreAiL3N9QtBvMJFzowOe5H8ZB8gGen2oiyYKSpFYBR1JQ7Yoyabh0QPFYIIxNroGBU97HYZD';
        $ad_account_id = 'act_151893790296560';

        $fields = array(
            'cpp',
            'cpm',
        );

        $params = array(
            'time_range' => array('since' => '2021-06-03', 'until' => '2021-06-10'),
            'filtering' => array(),
            'level' => 'account',
        );

        $raport = new FacebookInsight($access_token, $ad_account_id, $fields, $params);
        dump($raport->getRaport());

    }
}
