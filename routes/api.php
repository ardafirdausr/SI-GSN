<?php

use Illuminate\Http\Request;

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
Route::group(['namespace' => 'Api', 'as' => 'api.'], function(){
    Route::post('/login', ['uses' => 'AuthController@login', 'as' => 'login']);
    Route::post('/logout', ['uses' => 'AuthController@logout', 'as' => 'logout']);
    Route::get('/profil', ['uses' => 'UserController@showProfile', 'as' => 'profile']);

    Route::group(['prefix' => '/agen-pelayaran', 'as' => 'agen-pelayaran.'], function(){
        Route::get('/', ['uses' => 'AgenPelayaranController@index', 'as' => 'index']);
        Route::get('/{agenPelayaran}', ['uses' => 'AgenPelayaranController@show', 'as' => 'show']);
        Route::get('/{agenPelayaran}/kapal', ['uses' => 'AgenPelayaranController@showKapalByAgenPelayaranId', 'as' => '.kapal' ]);
        Route::get('/{agenPelayaran}/jadwal', ['uses' => 'AgenPelayaranController@showJadwalByAgenPelayaranId', 'as' => '.jadwal' ]);
    });

    Route::group(['prefix' => '/kapal', 'as' => 'kapal.'], function(){
        Route::get('/', ['uses' => 'KapalController@index', 'as' => 'index']);
        Route::get('/{kapal}', ['uses' => 'KapalController@show', 'as' => 'show']);
        Route::get('/{kapal}/jadwal', ['uses' => 'KapalController@showJadwalByKapalId', 'as' => '.kapal' ]);
    });

    Route::group(['prefix' => '/jadwal', 'as' => 'jadwal'], function(){
        Route::get('/', ['uses' => 'JadwalController@index', 'as' => 'index']);
        Route::get('/{jadwal}', ['uses' => 'JadwalController@show', 'as' => 'show']);
        Route::put('/{jadwal}', ['uses' => 'JadwalController@update', 'as' => 'update']);
    });
});

Route::fallback(function(){ return response()->json(['message' => 'Url not found'], 404); });
