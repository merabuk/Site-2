<?php

namespace Database\Seeders;

use App\Models\UserGroup;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = new UserGroup();
        $team->display_name = 'Администраторы';
        $team->name = Str::slug($team->display_name);
        $team->description = 'Группа "'.$team->display_name.'"';
        $team->icon = 'fas fa-fw fa-user-secret';
        $team->save();

        for ($i=1; $i < 5; $i++) {
            $team = new UserGroup();
            $team->display_name = 'Партнеры'.$i;
            $team->name = Str::slug($team->display_name);
            $team->description = 'Группа "'.$team->display_name.'"';
            $team->icon = 'fas fa-fw fa-user-tie';
            $team->save();
        }
    }
}
