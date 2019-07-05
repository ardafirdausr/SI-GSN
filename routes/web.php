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
        Route::get('/profil', ['uses' => 'UserController@showProfile', 'as' => 'profil']);
        Route::resource('user', 'UserController');
        // Agent Pelayaran Resource Route
        Route::resource('agen-pelayaran', 'AgenPelayaranController');
        // Kapal Resource Route
        Route::resource('kapal', 'KapalController');
        // Jadwal Resource Route
        Route::group(['prefix' => '/jadwal', 'as' => 'jadwal.'], function(){
            Route::get('/keberangkatan', ['uses' => 'JadwalController@showJadwalKeberangkatan', 'as' => 'keberangkatan']);
            Route::get('/kedatangan', ['uses' => 'JadwalController@showJadwalKedatangan', 'as' => 'kedatangan']);
        });
        Route::resource('jadwal', 'JadwalController');
    });
});


Route::get('/', function(){ return redirect()->route('login'); });