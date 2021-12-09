<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\GetParam' => 'App\Policies\GetParamPolicy',
        'App\Models\Lead' => 'App\Policies\LeadPolicy',
        'App\Models\LeadGroup' => 'App\Policies\LeadGroupPolicy',
        'App\Models\LeadStatus' => 'App\Policies\LeadStatusPolicy',
        'App\Models\Permission' => 'App\Policies\PermissionPolicy',
        'App\Models\PermissionGroup' => 'App\Policies\PermissionGroupPolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
        'App\Models\Token' => 'App\Policies\TokenPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\UserGroup' => 'App\Policies\UserGroupPolicy',
        'App\Models\UtmParam' => 'App\Policies\UtmParamPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //пользовтель имеет роль админа
        Gate::define('isAdmin', function  (User $user) {
            return $user->hasRole('administrator');
        });
        //пользовтель имеет разрешение на отображение пункта меню "Офисы"
        Gate::define('showOfficies', function  (User $user) {
            if ($user->hasPermission('menu-show-officies') || $user->roles->first()->hasPermission('menu-show-officies')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Статусы"
        Gate::define('showLeadStatuses', function  (User $user) {
            if ($user->hasPermission('menu-show-lead-statuses') || $user->roles->first()->hasPermission('menu-show-lead-statuses')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Статистика"
        Gate::define('showStatistics', function  (User $user) {
            if ($user->hasPermission('menu-show-statistics') || $user->roles->first()->hasPermission('menu-show-statistics')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "UTM-параметры"
        Gate::define('showUtmParams', function  (User $user) {
            if ($user->hasPermission('menu-show-utm-params') || $user->roles->first()->hasPermission('menu-show-utm-params')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "GET-параметры"
        Gate::define('showGetParams', function  (User $user) {
            if ($user->hasPermission('menu-show-get-params') || $user->roles->first()->hasPermission('menu-show-get-params')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Токены"
        Gate::define('showTokens', function  (User $user) {
            if ($user->hasPermission('menu-show-tokens') || $user->roles->first()->hasPermission('menu-show-tokens')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Методы"
        Gate::define('showMethods', function  (User $user) {
            if ($user->hasPermission('menu-show-methods') || $user->roles->first()->hasPermission('menu-show-methods')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Группы пользователей"
        Gate::define('showUserGroups', function  (User $user) {
            if ($user->hasPermission('menu-show-user-groups') || $user->roles->first()->hasPermission('menu-show-user-groups')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Пользователи"
        Gate::define('showUsers', function  (User $user) {
            if ($user->hasPermission('menu-show-users') || $user->roles->first()->hasPermission('menu-show-users')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Роли"
        Gate::define('showRoles', function  (User $user) {
            if ($user->hasPermission('menu-show-roles') || $user->roles->first()->hasPermission('menu-show-roles')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Группы разрешений"
        Gate::define('showPermissionGroups', function  (User $user) {
            if ($user->hasPermission('menu-show-permission-groups') || $user->roles->first()->hasPermission('menu-show-permission-groups')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Разрешения"
        Gate::define('showPermissions', function  (User $user) {
            if ($user->hasPermission('menu-show-permissions') || $user->roles->first()->hasPermission('menu-show-permissions')) {
                return true;
            } else {
                return false;
            }
        });
        //пользовтель имеет разрешение на отображение пункта меню "Настройки"
        Gate::define('showOptions', function  (User $user) {
            if ($user->hasPermission('menu-show-options') || $user->roles->first()->hasPermission('menu-show-options')) {
                return true;
            } else {
                return false;
            }
        });
    }
}
