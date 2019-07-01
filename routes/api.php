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


Route::group(['namespace' => 'Api', 'middleware' => ['api-localization']], function(){
    Route::apiResources([
        'kapal' => 'KapalController',
        'jadwal' => 'JadwalController',
        'maskapai' => 'MaskapaiController'
    ]);
    Route::prefix(['prefix' => '/maskapai', 'as' => 'maskapai.'], function(){
        Route::get('/{maskapai}/kapal', ['uses' => 'MaskapaiController@showKapalByMaskapaiId', 'as' => '.kapal' ]);
    });
});

Route::fallback(function(){ return response()->json(['message' => 'Url not found'], 404); });