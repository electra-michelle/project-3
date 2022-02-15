<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use \App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InfoPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReferralController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ref/{referralUrl}', [ReferralController::class, 'store'])->name('referral');
Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'show')->name('contact');
    Route::post('/contact', 'sendMessage');
});

Route::controller(InfoPageController::class)->group(function () {
    Route::get('/investments', 'investments')->name('investments');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/affiliate', 'affiliate')->name('affiliate');
});

Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

