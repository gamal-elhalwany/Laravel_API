<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::apiResource('/products', 'App\Http\Controllers\ProductController');

    Route::group(['prefix' => 'products'], function () {
        Route::apiResource('{product}/reviews','App\Http\Controllers\ReviewController');
    });

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');

});
