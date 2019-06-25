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
    Route::get('/jadwal-keberangkatan', ['uses' => 'KeberangkatanController@index', 'as' => 'jadwal-keberangkatan.index']);
    Route::get('/jadwal-kedatangan', ['uses' => 'KedatanganController@index', 'as' => 'jadwal-kedatangan.index']);
});

Route::get('/home', function(){
    return redirect()->route('web.jadwal-keberangkatan.index');
})->name('home');

