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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => 'Api', 'as' => 'api.'], function(){
    Route::post('/login', ['uses' => 'AuthController@login', 'as' => 'login']);
    Route::post('/logout', ['uses' => 'AuthController@logout', 'as' => 'logout']);
    Route::apiResources([
        'kapal' => 'KapalController',
        'jadwal' => 'JadwalController',
        'agen_pelayaran' => 'AgenPelayaranController'
    ]);
    Route::prefix(['prefix' => '/agenPelayaran', 'as' => 'agen_pelayaran.'], function(){
        Route::get('/{agenPelayaran}/kapal', ['uses' => 'AgenPelayaranController@showKapalByAgenPelayaranId', 'as' => '.kapal' ]);
    });
});

Route::fallback(function(){ return response()->json(['message' => 'Url not found'], 404); });
