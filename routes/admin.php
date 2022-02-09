<?php

use Illuminate\Support\Facades\Route;

// Dashboard
//Route::get('/', 'HomeController@index')->name('home');
//
//// Login
//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//Route::post('login', 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Register
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Reset Password
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Confirm Password
//Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
//Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Verify Email
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::middleware('admin.auth')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // Settings
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::post('settings', 'SettingsController@store');

    // Wallet Balance
    Route::get('balances', 'WalletBalancesController@index')->name('balances');

    // Messages
    Route::get('messages/{status?}', 'MessagesController@index')->name('messages')->where('status', '[A-Za-z]+');
    Route::get('messages/{message}', 'MessagesController@show')->name('messages.show')->where('message', '[0-9]+');
    Route::post('messages/{message}', 'MessagesController@update')->name('messages.update')->where('message', '[0-9]+');
    Route::delete('messages/{message}', 'MessagesController@destroy')->name('messages.destroy')->where('message', '[0-9]+');

    // Users
    Route::resource('users', 'UsersController')->except(['store', 'create', 'edit', 'destroy']);
    Route::post('users/{user}/login', 'UsersController@loginWithUser')->name('users.login');

    // Deposits
    Route::get('deposits/{status?}', 'DepositsController@index')->name('deposits')->where('status', '[A-Za-z]+');
    Route::resource('deposits', 'DepositsController')->except(['index']);
    Route::resource('news', 'NewsController')->except(['show', 'create', 'store']);

    // Payouts
    Route::get('payouts/{status?}', 'PayoutController@index')->name('payouts')->where('status', '[A-Za-z]+');
    Route::get('payouts/{payout}', 'PayoutController@view')->name('payouts.view')->where('payout', '[0-9]+');
    Route::patch('payouts/{payout}', 'PayoutController@send')->name('payouts.update')->where('payout', '[0-9]+');
    Route::delete('payouts/{payout}', 'PayoutController@cancel')->name('payouts.destroy')->where('payout', '[0-9]+');
});



