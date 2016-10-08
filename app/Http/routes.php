<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['web']], function () {
    Route::group(['namespace' => 'Auth'], function(){
        Route::get('login.html', 'AuthController@showLoginForm')->name('auth.login');
        Route::post('login', 'AuthController@login');
    });
});
