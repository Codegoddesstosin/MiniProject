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
    return view('welcome');
})->middleware('auth');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//routes for passwordless authentication

Route::get('/login/magic', 'Auth\MagicLoginController@show');

Route::post('/login/magic', 'Auth\MagicLoginController@sendToken');

Route::get('/login/magic/{token}', 'Auth\MagicLoginController@validateToken');

//Routes for laravel socilaite login
Route::get('login/github', 'Auth\LoginController@redirectToProvider');

Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');