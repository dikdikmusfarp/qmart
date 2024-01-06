<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers\API', 'as' => 'api'], function ($api) { # --- operator
    Route::group(['prefix' => 'type', 'as' => '.type'], function ($api) {
        $api->get('/', ['as' => '.index', 'uses' => 'TypeController@index']);
        $api->post('/', ['as' => '.store', 'uses' => 'TypeController@store']);
        $api->get('/list', ['as' => '.list', 'uses' => 'TypeController@list']);
        $api->get('/{id}', ['as' => '.show', 'uses' => 'TypeController@show']);
        $api->post('/{id}', ['as' => '.update', 'uses' => 'TypeController@update']);
        $api->delete('/{id}', ['as' => '.delete', 'uses' => 'TypeController@delete']);
    });

    Route::group(['prefix' => 'item', 'as' => '.item'], function ($api) {
        $api->get('/', ['as' => '.index', 'uses' => 'ItemController@index']);
        $api->post('/', ['as' => '.store', 'uses' => 'ItemController@store']);
        $api->get('/list', ['as' => '.list', 'uses' => 'ItemController@list']);
        $api->get('/{id}', ['as' => '.show', 'uses' => 'ItemController@show']);
        $api->post('/{id}', ['as' => '.update', 'uses' => 'ItemController@update']);
        $api->delete('/{id}', ['as' => '.delete', 'uses' => 'ItemController@delete']);
    });

    Route::group(['prefix' => 'stock', 'as' => '.stock'], function ($api) {
        // $api->get('/', ['as' => '.index', 'uses' => 'StockController@index']);
        $api->post('/', ['as' => '.store', 'uses' => 'StockController@store']);
        // $api->get('/{id}', ['as' => '.show', 'uses' => 'StockController@show']);
        // $api->post('/{id}', ['as' => '.update', 'uses' => 'StockController@update']);
        // $api->delete('/{id}', ['as' => '.delete', 'uses' => 'StockController@delete']);
    });

    Route::group(['prefix' => 'transaction', 'as' => '.transaction'], function ($api) {
        $api->get('/', ['as' => '.index', 'uses' => 'TransactionController@index']);
        $api->post('/', ['as' => '.store', 'uses' => 'TransactionController@store']);
        $api->get('/list', ['as' => '.list', 'uses' => 'TransactionController@list']);
        $api->get('/{id}', ['as' => '.show', 'uses' => 'TransactionController@show']);
        $api->post('/{id}', ['as' => '.update', 'uses' => 'TransactionController@update']);
        $api->delete('/{id}', ['as' => '.delete', 'uses' => 'TransactionController@delete']);
    });

    Route::group(['prefix' => 'sale', 'as' => '.sale'], function ($api) {
        $api->get('/', ['as' => '.index', 'uses' => 'TransactionDetailController@index']);
        $api->post('/', ['as' => '.store', 'uses' => 'TransactionDetailController@store']);
        $api->get('/{id}', ['as' => '.show', 'uses' => 'TransactionDetailController@show']);
        $api->post('/{id}', ['as' => '.update', 'uses' => 'TransactionDetailController@update']);
        $api->delete('/{id}', ['as' => '.delete', 'uses' => 'TransactionDetailController@delete']);
    });
});
