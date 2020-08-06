<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'namespace' => 'Api'], function() {
    Route::group(
        [
            'prefix' => 'auth',
        ], function () {
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('register', 'AuthController@register')->name('register');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('user-profile', 'AuthController@userProfile');
    });
    Route::resource('clients', 'ClientController')->except(['index','edit']);
    Route::get('search-client', 'ClientController@searchClient');
});
