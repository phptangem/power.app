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

Route::resource('test','TestController');
Route::group(['middleware' => ['web']], function () {
    /*=====================无需登陆操作 start======================*/
    Route::group(['middleware'=>'guest','namespace'=>'Auth'], function(){
        Route::get('login.html', 'AuthController@showLoginForm')->name('login');
        Route::post('login', 'AuthController@login');
    });
    /*=====================无需登陆操作 end========================*/

    /*=====================需要登陆操作 start======================*/
    Route::group(['middleware' => 'auth'], function(){
        Route::get('logout.html','Auth\\AuthController@logout')->name('logout');
        Route::get('dashboard','DashboardController@index')->name('dashboard.index');
        /*================权限相关 start====================*/
        /*================权限相关 end======================*/
        /*================合伙人相关 start====================*/
        Route::group(['namespace' => 'CityPartner'], function(){
            Route::get('city/partner/lists.html', 'PartnerController@lists');
        });
        /*================合伙人相关 end======================*/

    });
    /*=====================需要登陆操作 start======================*/
});
