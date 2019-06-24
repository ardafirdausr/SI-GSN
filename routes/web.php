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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Web', 'as' => 'web.'], function(){
    Route::resource('jadwal-keberangkatan', 'KeberangkatanController')->except(['create', 'edit']);
    Route::resource('jadwal-kedatangan', 'KedatanganController')->except(['create', 'edit']);
});

