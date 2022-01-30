<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\DashboardController;
use App\Http\Controllers\Account\DepositController;
use \App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Account\WithdrawController;
use App\Http\Controllers\Account\ReferralController;

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


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/deposit', [DepositController::class, 'index'])->name('deposit');
Route::get('/withdraw', [WithdrawController::class, 'index'])->name('withdraw');
Route::get('/referrals', [ReferralController::class, 'index'])->name('referral');
Route::get('/marketing-tools', [ReferralController::class, 'banners'])->name('banners');


Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/settings', [SettingsController::class, 'updateSettings']);

