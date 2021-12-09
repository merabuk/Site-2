<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Роль администратора
        $admin = new Role();
        $admin->display_name = 'Администратор';
        $admin->description = 'Роль с максимальным набором прав доступа (разрешений).';
        $admin->name = Str::slug($admin->display_name);
        $admin->icon = 'fas fa-fw fa-user-secret';
        $admin->save();

        //Роль партнера
        $partner = new Role();
        $partner->display_name = 'Партнер';
        $partner->description = 'Роль с ограниченным набором прав доступа (разрешений).';
        $partner->name = Str::slug($partner->display_name);
        $partner->icon = 'fas fa-fw fa-user-tie';
        $partner->save();
    }
}
