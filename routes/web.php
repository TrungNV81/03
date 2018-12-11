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

Route::get('login','LoginController@getLogin')->name('login');
Route::post('login','LoginController@postLogin');

Route::get('logout', function(){
    Auth::logout();
    return Redirect::to('login');
});

Route::get('batch', 'HomeController@batch');
Route::get('export', 'HomeController@handle')->name('export');


Route::get('','AdminController@getIndex');
Route::get('history','AdminController@manageHistory')->name('history');