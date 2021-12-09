<?php

namespace App\Common;

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdsInsights;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

class FacebookInsight
{
    protected $access_token;
    protected $ad_account_id;
    protected $app_secret;
    protected $app_id;
    protected $fields;
    protected $params;

    public function __construct($access_token, $ad_account_id, array $fields, array $params)
    {
        $this->access_token = $access_token;
        $this->ad_account_id = $ad_account_id;
        $this->fields = $fields;
        $this->params = $params;
        $this->app_id = config('facebook-ads.app_id');
        $this->app_secret = config('facebook-ads.app_secret');
    }

    public function init ()
    {
        $api = Api::init($this->app_id, $this->app_secret, $this->access_token);
    }

    public function getRaport()
    {
        $this->init();
        $data = json_encode((new AdAccount($this->ad_account_id))->getInsights(
            $this->fields,
            $this->params
        )->getResponse()->getContent(), JSON_PRETTY_PRINT);

        return $data;
    }


}
