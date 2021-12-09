<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 5; $i++) {
            $lead = new Lead();
            $lead->gets = ['phone' => '123'.$i];
            $lead->utms = ['utm_source' => 'source_name'.$i];
            $lead->save();
        }
    }
}
