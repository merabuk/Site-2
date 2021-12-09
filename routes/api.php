<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIController;
use App\Http\Controllers\LeadGroupController;
use App\Http\Controllers\StatisticController;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//API интерфейс
    //Прием лидов
    Route::middleware('token')->match(['post', 'get'], 'lead', [APIController::class, 'leadStore'])->name('api.lead.store');
    //Статистика. Получение всех данных
    Route::middleware('token')->get('getAll', [StatisticController::class, 'getAll']);
    //Обновление лида
    Route::middleware('token')->put('lead-groups/{lead_group}', [LeadGroupController::class, 'updateGroup']);

