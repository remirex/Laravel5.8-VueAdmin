<?php

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

Route::get('/', function () {
    return view('auth.account');
})->name('account-request');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/account/login', 'Front\AuthController@userLogin')->name('user-login');
Route::post('/account/register', 'Front\AuthController@userRegister')->name('user-register');
Route::get('/register/activate/{token}', 'Front\AuthController@activationAccount')->name('activation-account');
