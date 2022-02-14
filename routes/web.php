<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use \App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InfoPageController;

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

Route::get('/', function () {return view('home');})->name('home');
Route::get('/affiliate', function () {return view('home');})->name('affiliate');
Route::get('/faq', function () {return view('faq');})->name('faq');
Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'show')->name('contact');
    Route::post('/contact', 'sendMessage');
});

Route::get('/investments', [InfoPageController::class, 'investments'])->name('investments');

Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
