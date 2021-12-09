<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'AffiliateCRM',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Affiliate</b>CRM',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AffiliateCRM',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-secondary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => false,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'light',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => true,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        /*[
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],*/
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        /*[
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],*/
        [
            'text' => 'Рабочий стол',
            'route' => 'home',
            'active' => ['/home'],
            'icon' => 'fas fa-fw fa-tachometer-alt',
        ],
        [
            'text'    => 'Лид-cистема',
            'icon'    => 'fab fa-fw fa-hubspot',
            'submenu' => [
                [
                    'text' => 'Лиды',
                    'route'  => 'leads.index',
                    'active' => ['/leads', '/leads/*'],
                    'icon' => 'fas fa-fw fa-user-plus',
                ],
                [
                    'text' => 'Офисы',
                    'route'  => 'lead-groups.index',
                    'active' => ['/lead-groups', '/lead-groups/*'],
                    'icon' => 'fas fa-fw fa-user-friends',
                    'can'     => ['isAdmin', 'showOfficies'],
                ],
                [
                    'text' => 'Статусы',
                    'route'  => 'lead-statuses.index',
                    'active' => ['/lead-statuses', '/lead-statuses/*'],
                    'icon' => 'fas fa-fw fa-user-check',
                    'can'     => ['isAdmin', 'showLeadStatuses'],
                ],
            ],
        ],
        [
            'text' => 'Статистика',
            'route'  => 'statistic',
            'active' => ['/statistic', '/statistic/*'],
            'icon' => 'fas fa-fw fa-chart-line',
            'can'     => ['isAdmin', 'showStatistics'],
        ],
        [
            'text'    => 'API',
            'icon'    => 'fab fa-fw fa-usb',
            'can'     => ['isAdmin', 'showUtmParams', 'showGetParams', 'showTokens', 'showMethods'],
            'submenu' => [
                [
                    'text' => 'UTM-параметры',
                    'route'  => 'utm-params.index',
                    'active' => ['/utm-params', '/utm-params/*'],
                    'icon' => 'fas fa-fw fa-cubes',
                    'can'     => ['isAdmin', 'showUtmParams'],
                ],
                [
                    'text' => 'GET-параметры',
                    'route'  => 'get-params.index',
                    'active' => ['/get-params', '/get-params/*'],
                    'icon' => 'fas fa-fw fa-hashtag',
                    'can'     => ['isAdmin', 'showGetParams'],
                ],
                [
                    'text' => 'Токены',
                    'route'  => 'tokens.index',
                    'active' => ['/tokens', '/tokens/*'],
                    'icon' => 'fas fa-fw fa-key',
                    'can'     => ['isAdmin', 'showTokens'],
                ],
                [
                    'text' => 'Методы',
                    'route'  => 'methods.index',
                    'active' => ['/methods', '/methods/*'],
                    'icon' => 'fas fa-fw fa-map-signs',
                    'can'     => ['isAdmin', 'showMethods'],
                ],
            ],
        ],
        [
            'text'    => 'Контакты',
            'icon'    => 'fas fa-fw fa-users',
            'can'     => ['isAdmin', 'showUserGroups', 'showUsers', 'showRoles', 'showPermissionGroups', 'showPermissions'],
            'submenu' => [
                [
                    'text' => 'Группы пользователей',
                    'route'  => 'user-groups.index',
                    'active' => ['/user-groups', '/user-groups/*'],
                    'icon' => 'fas fa-fw fa-user-friends',
                    'can'     => ['isAdmin', 'showUserGroups'],
                ],
                [
                    'text' => 'Пользователи',
                    'route'  => 'users.index',
                    'active' => ['/users', '/home/users/*'],
                    'icon' => 'fas fa-fw fa-user',
                    'can'     => ['isAdmin', 'showUsers'],
                ],
                [
                    'text' => 'Роли',
                    'route'  => 'roles.index',
                    'active' => ['/roles', '/roles/*'],
                    'icon' => 'fas fa-fw fa-user-tag',
                    'can'     => ['isAdmin', 'showRoles'],
                ],
                [
                    'text' => 'Группы разрешений',
                    'route'  => 'permission-groups.index',
                    'active' => ['/permission-groups', '/permission-groups/*'],
                    'icon' => 'fas fa-fw fa-lock',
                    'can'     => ['isAdmin', 'showPermissionGroups'],
                ],
                [
                    'text' => 'Разрешения',
                    'route'  => 'permissions.index',
                    'active' => ['/permissions', '/permissions/*'],
                    'icon' => 'fas fa-fw fa-user-lock',
                    'can'     => ['isAdmin', 'showPermissions'],
                ],
            ],
        ],
        [
            'text' => 'Настройки',
            'icon' => 'fas fa-fw fa-cogs',
            'can'     => ['isAdmin', 'showOptions'],
            'submenu' => [
                [
                    'text' => 'Общие настройки',
                    'route'  => 'options.index',
                    'active' => ['/options', '/options/*'],
                    'icon' => 'fas fa-fw fa-cog',
                    'can'     => ['isAdmin', 'showOptions'],
                ],
                [
                    'text' => 'Вебхуки',
                    'route'  => 'webhooks.index',
                    'active' => ['/webhooks', '/webhooks/*'],
                    'icon' => 'fas fa-fw fa-cog',
                    'can'     => ['isAdmin', 'showOptions'],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-select/js/dataTables.select.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-select/js/select.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-select/css/select.bootstrap4.min.css',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.min.js',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'BootstrapSelect' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-select/js/bootstrap-select.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-select/css/bootstrap-select.min.css',
                ],
            ],
        ],
        'Moment' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment-with-locales.min.js',
                ],
            ],
        ],
        'Tempusdominus' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'BootstrapColorpicker' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
                ],
            ],
        ],
        'DateRangePicker' => [
            'active' => false,
            'files' => [
                // [
                //     'type' => 'js',
                //     'asset' => true,
                //     'location' => 'vendor/moment/moment-with-locales.min.js',
                // ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.css',
                ],
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => false,
];
