<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UtmParamController;
use App\Http\Controllers\GetParamController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\LeadGroupController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Роуты авторизации
    Auth::routes();

//Роуты админки доступные всем зарегестрированным
    Route::middleware(['auth'])->group(function () {
        //Главная страница
        Route::redirect('/', '/home');
        //Dashboard
        Route::get('home', [HomeController::class, 'index'])->name('home');
        //Лиды
        Route::resource('leads', LeadController::class);
        Route::post('leads/deleteMany', [LeadController::class, 'destroyMany']);
        //Группы лидов
        Route::resource('lead-groups', LeadGroupController::class)->except(['show']);
        Route::post('lead-groups/{lead_group}/add-leads', [LeadGroupController::class, 'addLeads'])->name('lead-groups.addLeads');
        Route::delete('lead-groups/{lead}/remove-lead', [LeadGroupController::class, 'removeLead'])->name('lead-groups.remove-lead');
        Route::post('lead-groups/remove-leads', [LeadGroupController::class, 'removeLeads'])->name('lead-groups.remove-leads');
        Route::post('lead-groups/{lead_group}/add-user-groups', [LeadGroupController::class, 'addUserGroupsToLeadGroup'])->name('lead-groups.add-user-groups');
        Route::delete('lead-groups/{lead_group}/{user_group}/remove-user-group', [LeadGroupController::class, 'removeUserGroupFromLeadGroup'])->name('lead-groups.remove-user-group');
        Route::post('lead-groups/{lead_group}/remove-user-groups', [LeadGroupController::class, 'removeUserGroupsFromLeadGroup'])->name('lead-groups.remove-user-groups');
        //Статусы лидов
        Route::resource('lead-statuses', LeadStatusController::class)->except(['show']);
        Route::post('lead-statuses/{lead_status}/change-lead-status', [LeadStatusController::class, 'changeLeadStatus'])->name('lead-statuses.change-lead-status');
        //Статистика
        Route::get('statistic', [StatisticController::class, 'index'])->name('statistic');
        Route::post('statistic/filter', [StatisticController::class, 'filterBy'])->name('statistic.filter');
        //UTM-параметры
        Route::resource('utm-params', UtmParamController::class)->except(['show']);
        //GET-параметры
        Route::resource('get-params', GetParamController::class)->except(['show']);
        //Токены
        Route::resource('tokens', TokenController::class)->except(['show']);
        //Методы
        Route::get('methods', [MethodController::class, 'index'])->name('methods.index');
        //Группы пользователей
        Route::resource('user-groups', UserGroupController::class)->except(['show']);
        Route::post('user-groups/{user_group}/add-users', [UserGroupController::class, 'addUsersToGroup'])->name('user-groups.add-users');
        Route::delete('user-groups/{user_group}/{user}/remove-user', [UserGroupController::class, 'removeUserFromGroup'])->name('user-groups.remove-user');
        Route::post('user-groups/{user_group}/remove-users', [UserGroupController::class, 'removeUsersFromGroup'])->name('user-groups.remove-users');
        Route::post('user-groups/{user_group}/add-lead-groups', [UserGroupController::class, 'addLeadGroupsToGroup'])->name('user-groups.add-lead-groups');
        Route::delete('user-groups/{user_group}/{lead_group}/remove-lead-group', [UserGroupController::class, 'removeLeadGroupFromGroup'])->name('user-groups.remove-lead-group');
        Route::post('user-groups/{user_group}/remove-lead-groups', [UserGroupController::class, 'removeLeadGroupsFromGroup'])->name('user-groups.remove-lead-groups');
        //Пользователи
        Route::resource('users', UserController::class)->except(['show']);
        Route::post('user/{user}/add-groups', [UserController::class, 'addGroupsToUser'])->name('user.add-groups');
        Route::delete('user/{user}/{user_group}/remove-group', [UserController::class, 'removeGroupFromUser'])->name('user.remove-group');
        Route::post('user/{user}/remove-groups', [UserController::class, 'removeGroupsFromUser'])->name('user.remove-groups');
        Route::post('user/{user}/add-leads', [UserController::class, 'addLeadToUser'])->name('user.add-leads');
        Route::delete('user/{user}/{lead}/remove-lead', [UserController::class, 'removeLeadFromUser'])->name('user.remove-lead');
        Route::post('user/{user}/remove-leads', [UserController::class, 'removeLeadsFromUser'])->name('user.remove-leads');
        //Роли
        Route::resource('roles', RoleController::class)->except(['show']);
        //Группы разрешений
        Route::resource('permission-groups', PermissionGroupController::class)->except(['show']);
        //Разрешения
        Route::resource('permissions', PermissionController::class)->except(['show']);
        //Настройки Общие
        Route::get('options', [OptionController::class, 'index'])->name('options.index');
        Route::put('options/save', [OptionController::class, 'save'])->name('options.save');
        Route::get('options/create-webhook', [OptionController::class, 'createWebhook'])->name('options.create-webhook');
        Route::get('options/delete-webhook/{index}', [OptionController::class, 'deleteWebhook'])->name('options.delete-webhook');
        //Настройки Вебхуки
        Route::resource('webhooks', WebhookController::class)->except('show');
    });
