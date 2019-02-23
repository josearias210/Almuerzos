<?php

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

Route::group(['middleware' => 'cors'], function () {

    Route::group(["prefix" => "orders"], function () {
        Route::get('/', 'OrderController@index');
        Route::post('/', 'OrderController@store');
        Route::post('/{order}/completed', 'OrderController@completed')->where('order', '[0-9]+');
        Route::post('/{order}/dispatches', 'DispatchController@store')->where('order', '[0-9]+');
    });

    Route::group(["prefix" => "dispatches"], function () {

        Route::get('/', 'DispatchController@index');
        Route::get('/{dispatch}/detail', 'DispatchController@detail')->where('dispatch', '[0-9]+');
        Route::post('/{dispatch}/delivered', 'DispatchController@delivered')->where('dispatch', '[0-9]+');
    });


    Route::group(["prefix" => "ingredients"], function () {
        Route::get('/', 'IngredientController@index');
        Route::post('/{ingredient}/purchase', 'PurchaseController@store')->where('ingredient', '[0-9]+');
    });

    Route::get('/purchases', 'PurchaseController@index');
    Route::get('/foods/{food}/recipe', 'FoodController@show')->where('food', '[0-9]+');
    
});

