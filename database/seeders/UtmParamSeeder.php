<?php

namespace Database\Seeders;

use App\Models\UtmParam;
use Illuminate\Database\Seeder;

class UtmParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Campaign Source
        $utm = new UtmParam();
        $utm->name = 'Campaign Source';
        $utm->code = 'utm_source';
        $utm->order = 10;
        $utm->save();
        //Campaign Medium
        $utm = new UtmParam();
        $utm->name = 'Campaign Medium';
        $utm->code = 'utm_medium';
        $utm->order = 11;
        $utm->save();
        //Campaign Medium
        $utm = new UtmParam();
        $utm->name = 'Campaign Name';
        $utm->code = 'utm_campaign';
        $utm->order = 12;
        $utm->save();
        //Campaign Term
        $utm = new UtmParam();
        $utm->name = 'Campaign Term';
        $utm->code = 'utm_term';
        $utm->order = 13;
        $utm->save();
        //Campaign Content
        $utm = new UtmParam();
        $utm->name = 'Campaign Content';
        $utm->code = 'utm_content';
        $utm->order = 14;
        $utm->save();
    }
}
