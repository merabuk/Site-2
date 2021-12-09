<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadGroup;
use Illuminate\Support\Str;

class LeadGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadGroup = new LeadGroup();
        $leadGroup->name = 'Офис Киев';
        $leadGroup->code = Str::slug($leadGroup->name);
        $leadGroup->open = "08:00:00";
        $leadGroup->close = "20:00:00";
        $leadGroup->k_leads = "1";
        $leadGroup->max_leads = "100";
        $leadGroup->enabled = false;
        $leadGroup->save();

        $leadGroup = new LeadGroup();
        $leadGroup->name = 'Офис Москва';
        $leadGroup->code = Str::slug($leadGroup->name);
        $leadGroup->open = "08:00:00";
        $leadGroup->close = "20:00:00";
        $leadGroup->k_leads = "1";
        $leadGroup->max_leads = "100";
        $leadGroup->enabled = false;
        $leadGroup->save();

        $leadGroup = new LeadGroup();
        $leadGroup->name = 'Офис Краматорск';
        $leadGroup->code = Str::slug($leadGroup->name);
        $leadGroup->open = "08:00:00";
        $leadGroup->close = "20:00:00";
        $leadGroup->k_leads = "1";
        $leadGroup->max_leads = "100";
        $leadGroup->enabled = false;
        $leadGroup->save();
    }
}
