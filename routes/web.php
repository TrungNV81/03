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

Route::get('v1/api/export', 'HomeController@handle')->name('v1/api/export');

Route::get('','AdminController@getIndex');

Route::get('dashboard','AdminController@dashboard')->name('dashboard');

Route::get('historyFile','AdminController@historyFile')->name('historyFile');

Route::get('historySendMail','AdminController@historySendMail')->name('historySendMail');

Route::get('manageMail', 'AdminController@manageMail')->name('manageMail');

Route::post('edit-mail', 'AdminController@editMail')->name('edit-mail');

Route::post('add-mail', 'AdminController@addMail')->name('add-mail');

Route::post('del-mail', 'AdminController@delMail')->name('del-mail');

Route::get('setting','CmdController@getIndex')->name('setting');

Route::post('update','CmdController@updateSetting');
