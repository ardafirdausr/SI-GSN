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

Auth::routes();

Route::group(['namespace' => 'Web', 'as' => 'web.'], function(){
    // User Resource Route
    Route::resource('user', 'UserController');
    // Agent Pelayaran Resource Route
    Route::resource('agent-pelayaran', 'AgentPelayaran');
    // Kapal Resource Route
    Route::resource('kapal', 'KapalController');
    // Jadwal Resource Route
    Route::resource('jadwal', 'JadwalController');
    Route::group(['prefix' => '/jadwal', 'as' => 'jadwal.'], function(){
        Route::get('/keberangkatan', ['uses' => 'JadwalController@showJadwalKeberangkatan', 'as' => 'keberangkatan']);
        Route::get('/kedatangan', ['uses' => 'JadwalController@showJadwalKedatangan', 'as' => 'kedatangan']);
    });
});

Route::get('/', function(){ return response('Nothing here'); });
// Route::fallback(function(){ return redirect('/') ; });