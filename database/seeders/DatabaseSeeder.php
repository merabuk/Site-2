<?php

namespace Database\Seeders;

use App\Models\LeadGroup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LeadSeeder::class,
            LeadGroupSeeder::class,
            TokenSeeder::class,
            UtmParamSeeder::class,
            GetParamSeeder::class,
            RoleSeeder::class,
            PermissionGroupSeeder::class,
            PermissionSeeder::class,
            UserGroupSeeder::class,
            UserSeeder::class,
            AttachingSeeder::class,
            LeadStatusSeeder::class,
        ]);
    }
}
