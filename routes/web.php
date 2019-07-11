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

// Auth::routes();

Route::group(['middleware' => 'guest'], function(){
    Route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
    Route::post('/login', ['uses' => 'Auth\LoginController@login']);
});

Route::group(['middleware' => 'auth:web'], function(){

    Route::get('/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);

    Route::group(['namespace' => 'Web', 'as' => 'web.'], function(){

        // User Resource Route
        Route::group(['prefix' => '/user', 'as' => 'user.'], function(){
            Route::get('/', ['uses' => 'UserController@index', 'as' => 'index']);
            Route::get('/profil', ['uses' => 'UserController@showProfile', 'as' => 'profil']);
            Route::post('/', ['uses' => 'UserController@store', 'as' => 'store']);
            Route::put('/{user}', ['uses' => 'UserController@update', 'as' => 'update']);
            Route::delete('/{user}', ['uses' => 'UserController@destroy', 'as' => 'destroy']);
        });

        // Agent Pelayaran Resource Route
        Route::group(['prefix' => '/agen-pelayaran', 'as' => 'agen-pelayaran.'], function(){
            Route::get('/', ['uses' => 'AgenPelayaranController@index', 'as' => 'index']);
            Route::post('/', ['uses' => 'AgenPelayaranController@store', 'as' => 'store']);
            Route::put('/{agenPelayaran}', ['uses' => 'AgenPelayaranController@update', 'as' => 'update']);
            Route::delete('/{agenPelayaran}', ['uses' => 'AgenPelayaranController@destroy', 'as' => 'destroy']);
        });

        // Kapal Resource Route
        Route::group(['prefix' => '/kapal', 'as' => 'kapal.'], function(){
            Route::get('/', ['uses' => 'KapalController@index', 'as' => 'index']);
            Route::post('/', ['uses' => 'KapalController@store', 'as' => 'store']);
            Route::put('/{kapal}', ['uses' => 'KapalController@update', 'as' => 'update']);
            Route::delete('/{kapal}', ['uses' => 'KapalController@destroy', 'as' => 'destroy']);
        });

        // Jadwal Resource Route
        Route::group(['prefix' => '/jadwal', 'as' => 'jadwal.'], function(){
            Route::get('/', ['uses' => 'JadwalController@index', 'as' => 'index']);
            Route::get('/keberangkatan', ['uses' => 'JadwalController@showJadwalKeberangkatan', 'as' => 'keberangkatan']);
            Route::get('/kedatangan', ['uses' => 'JadwalController@showJadwalKedatangan', 'as' => 'kedatangan']);
            Route::post('/', ['uses' => 'JadwalController@store', 'as' => 'store']);
            Route::put('/{jadwal}', ['uses' => 'JadwalController@update', 'as' => 'update']);
            Route::delete('/{jadwal}', ['uses' => 'JadwalController@destroy', 'as' => 'destroy']);
        });

    });
});


Route::get('/', function(){ return redirect()->route('login'); });