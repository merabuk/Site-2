<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Набор разрешений
        $permissions = [
            //permission_group_id 1
            [
                'name' => 'menu-show-officies',
                'display_name' => 'Пункт меню "Офисы"',
                'description' => 'Разрешение на отображение пункта меню "Офисы" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-lead-statuses',
                'display_name' => 'Пункт меню "Статусы"',
                'description' => 'Разрешение на отображение пункта меню "Статусы" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-statistics',
                'display_name' => 'Пункт меню "Статистика"',
                'description' => 'Разрешение на отображение пункта меню "Статистика" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-utm-params',
                'display_name' => 'Пункт меню "UTM-параметры"',
                'description' => 'Разрешение на отображение пункта меню "UTM-параметры" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-get-params',
                'display_name' => 'Пункт меню "GET-параметры"',
                'description' => 'Разрешение на отображение пункта меню "GET-параметры" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-tokens',
                'display_name' => 'Пункт меню "Токены"',
                'description' => 'Разрешение на отображение пункта меню "Токены" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-methods',
                'display_name' => 'Пункт меню "Методы"',
                'description' => 'Разрешение на отображение пункта меню "Методы" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-user-groups',
                'display_name' => 'Пункт меню "Группы пользователей"',
                'description' => 'Разрешение на отображение пункта меню "Группы пользователей" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-users',
                'display_name' => 'Пункт меню "Пользователи"',
                'description' => 'Разрешение на отображение пункта меню "Пользователи" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-roles',
                'display_name' => 'Пункт меню "Роли"',
                'description' => 'Разрешение на отображение пункта меню "Роли" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-permission-groups',
                'display_name' => 'Пункт меню "Группы разрешений"',
                'description' => 'Разрешение на отображение пункта меню "Группы разрешений" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-permissions',
                'display_name' => 'Пункт меню "Разрешения"',
                'description' => 'Разрешение на отображение пункта меню "Разрешения" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            [
                'name' => 'menu-show-options',
                'display_name' => 'Пункт меню "Настройки"',
                'description' => 'Разрешение на отображение пункта меню "Настройки" и осуществления CRUD',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 1,
            ],
            //permission_group_id 2
            [
                'name' => 'lead-show-get-param-phone',
                'display_name' => 'GET-параметр лида "Телефон"',
                'description' => 'Разрешение на отображение GET-параметра лида "Телефон"',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 2,
            ],
            [
                'name' => 'lead-show-get-param-email',
                'display_name' => 'GET-параметр лида "Email"',
                'description' => 'Разрешение на отображение GET-параметра лида "Email"',
                'icon' => 'far fa-fw fa-eye',
                'permission_group_id' => 2,
            ],
            // [
            //     'name' => 'user-create',
            //     'display_name' => 'Создание пользователя',
            //     'description' => 'Разрешение на создание пользователя',
            //     'icon' => 'far fa-fw fa-plus-square',
            //     'permission_group_id' => 1,
            // ],
            // [
            //     'name' => 'user-edit',
            //     'display_name' => 'Редактирование пользователя',
            //     'description' => 'Разрешение на редактирование пользователя',
            //     'icon' => 'far fa-fw fa-edit',
            //     'permission_group_id' => 1,
            // ],
            // [
            //     'name' => 'user-delete',
            //     'display_name' => 'Удаление пользователя',
            //     'description' => 'Разрешение на удаление пользователя',
            //     'icon' => 'far fa-fw fa-minus-square',
            //     'permission_group_id' => 1,
            // ],
            // [
            //     'name' => 'team-create',
            //     'display_name' => 'Создание группы пользователей',
            //     'description' => 'Разрешение на создание группы пользователей',
            //     'icon' => 'far fa-fw fa-plus-square',
            //     'permission_group_id' => 2,
            // ],
            // [
            //     'name' => 'team-edit',
            //     'display_name' => 'Редактирование группы пользователей',
            //     'description' => 'Разрешение на редактирование группы пользователей',
            //     'icon' => 'far fa-fw fa-edit',
            //     'permission_group_id' => 2,
            // ],
            // [
            //     'name' => 'team-delete',
            //     'display_name' => 'Удаление группы пользователей',
            //     'description' => 'Разрешение на удаление группы пользователей',
            //     'icon' => 'far fa-fw fa-minus-square',
            //     'permission_group_id' => 2,
            // ],
            // [
            //     'name' => 'lead-edit',
            //     'display_name' => 'Редактирование лида',
            //     'description' => 'Разрешение на редактирование лида',
            //     'icon' => 'far fa-fw fa-edit',
            //     'permission_group_id' => 3,
            // ],
            // [
            //     'name' => 'lead-delete',
            //     'display_name' => 'Удаление лида',
            //     'description' => 'Разрешение на удаление лида',
            //     'icon' => 'far fa-fw fa-minus-square',
            //     'permission_group_id' => 3,
            // ],
            // [
            //     'name' => 'leadgroup-create',
            //     'display_name' => 'Создание группы лидов',
            //     'description' => 'Разрешение на создание группы лидов',
            //     'icon' => 'far fa-fw fa-plus-square',
            //     'permission_group_id' => 4,
            // ],
            // [
            //     'name' => 'leadgroup-edit',
            //     'display_name' => 'Редактирование группы лидов',
            //     'description' => 'Разрешение на редактирование группы лидов',
            //     'icon' => 'far fa-fw fa-edit',
            //     'permission_group_id' => 4,
            // ],
            // [
            //     'name' => 'leadgroup-delete',
            //     'display_name' => 'Удаление группы лидов',
            //     'description' => 'Разрешение на удаление группы лидов',
            //     'icon' => 'far fa-fw fa-minus-square',
            //     'permission_group_id' => 4,
            // ],
        ];

        foreach ($permissions as $key => $permission) {
            $model = new Permission();
            $model->name = $permission['name'];
            $model->display_name = $permission['display_name'];
            $model->description = $permission['description'];
            $model->icon = $permission['icon'];
            $model->permission_group_id = $permission['permission_group_id'];
            $model->save();
        }
    }
}
