<?php

namespace Database\Seeders;

use App\Models\LeadStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadStatus = new LeadStatus();
        $leadStatus->name = 'В обработке';
        $leadStatus->code = Str::slug($leadStatus->name);
        $leadStatus->color = "#007bff";
        $leadStatus->save();

        $leadStatus = new LeadStatus();
        $leadStatus->name = 'Обработан';
        $leadStatus->code = Str::slug($leadStatus->name);
        $leadStatus->color = "#28a745";
        $leadStatus->save();

        $leadStatus = new LeadStatus();
        $leadStatus->name = 'В архиве';
        $leadStatus->code = Str::slug($leadStatus->name);
        $leadStatus->color = "#ffc107";
        $leadStatus->save();
    }
}
