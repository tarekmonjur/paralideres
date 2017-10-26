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


Route::prefix('/')->namespace('Web')->group(function(){

    // show the page page
    Route::get('/', 'HomeController@index');

    // resource list
    Route::get('/recursos', 'ResourceController@index');

    // show resource create form
    Route::get('/recursos/crear', 'ResourceController@showCreate')->middleware('auth');

    // show single resource
    Route::get('/recursos/{slug}', 'ResourceController@show');


});

Route::prefix('/')->namespace('Auth')->group(function(){

    // show web login form
    Route::get('ingreser', 'LoginController@showLoginForm')->name('login');

    //Password Reset Routes...
    Route::get('password-reset', 'ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token?}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::prefix('/')->namespace('Api\V1')->group(function(){

    // login from web by using api
    Route::post('login', 'AuthenticateController@authenticate');

    // logout from web by using api
    Route::post('logout', 'AuthenticateController@logout');
});

