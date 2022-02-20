<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ePayCoreController;
use App\Http\Controllers\Api\PerfectMoneyController;
use App\Http\Controllers\Api\PayKassaController;
use App\Http\Controllers\Api\TelegramController;

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

Route::any('epaycore', [ePayCoreController::class, 'accept']);
Route::any('perfectmoney', [PerfectMoneyController::class, 'accept']);
Route::post('paykassa/status', [PayKassaController::class, 'accept']);
Route::any('telegram/setup', [TelegramController::class, 'setupWebhook']);

