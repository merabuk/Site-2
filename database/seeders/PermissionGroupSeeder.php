<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Набор разрешений
        $permissionGrups = [
            //id 1
            [
                'name' => 'menu-control',
                'display_name' => 'Управление меню',
                'description' => 'Группа разрешений управления отображения пунктов меню и осуществления CRUD',
                'icon' => 'fas fa-fw fa-bars'
            ],
            //id 2
            [
                'name' => 'lead-control',
                'display_name' => 'Управление лидами',
                'description' => 'Группа разрешений управления отображением параметров лидов',
                'icon' => 'fas fa-fw fa-link',
            ],
            // [
            //     'name' => 'users-control',
            //     'display_name' => 'Управление пользователями',
            //     'description' => 'Группа разрешений управления пользователями',
            //     'icon' => 'fas fa-fw fa-user'
            // ],
            // [
            //     'name' => 'teams-control',
            //     'display_name' => 'Управление группами пользователей',
            //     'description' => 'Группа разрешений управления группами пользователей',
            //     'icon' => 'fas fa-fw fa-users'
            // ],
            // [
            //     'name' => 'leadgroup-control',
            //     'display_name' => 'Управление группами лидов',
            //     'description' => 'Группа разрешений управления группами лидов',
            //     'icon' => 'fas fa-fw fa-object-group',
            // ],
        ];

        foreach ($permissionGrups as $key => $group) {
            $model = new PermissionGroup();
            $model->name = $group['name'];
            $model->display_name = $group['display_name'];
            $model->description = $group['description'];
            $model->icon = $group['icon'];
            $model->save();
        }
    }
}
