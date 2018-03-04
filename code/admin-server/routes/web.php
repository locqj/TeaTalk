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


Route::group(['middleware'=> 'web'], function () {

    Route::get('/', 'LoginController@index');
    Route::get('/signin', 'LoginController@signin');
    Route::get('/signout', 'LoginController@signout');
    Route::post('/test', 'LoginController@test');

    Route::post('/signout/distname', 'LoginController@distServerName');
    Route::post('/signout/register', 'LoginController@signoutUser');
    Route::post('/signin', 'LoginController@doSignin');
    Route::group(['middleware'=> 'checkLogin'], function () {
        Route::get('/index', 'IndexController@index');
        Route::get('/info', 'IndexController@info');
        Route::get('/logout', 'LoginController@logout');
    });


});
