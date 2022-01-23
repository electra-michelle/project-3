<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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
Route::get('/investments', function () {return view('home');})->name('investments');
Route::get('/affiliate', function () {return view('home');})->name('affiliate');
Route::get('/faq', function () {return view('home');})->name('faq');

Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'show')->name('contact');
    Route::post('/contact', 'sendMessage');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
