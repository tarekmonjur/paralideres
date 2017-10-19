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


//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/')->namespace('Web')->group(function(){
    Route::get('/', 'HomeController@index');
    Route::get('/recursos', 'ResourceController@index'); //resource list
    Route::get('/recursos/{slug}', 'ResourceController@show'); // show single resource
});

Route::prefix('/')->namespace('Auth')->group(function(){
    Route::get('ingreser', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@authenticate');
    Route::get('salir', 'LoginController@logout');
});
