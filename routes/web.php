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

Route::get('','ManageHistoryController@dashboard');

Route::get('dashboard','ManageHistoryController@dashboard')->name('dashboard');

Route::get('historyFile','ManageHistoryController@historyFile')->name('historyFile');

Route::get('historySendMail','ManageHistoryController@historySendMail')->name('historySendMail');

Route::get('manageMail', 'ManageMailController@manageMail')->name('manageMail');

Route::post('edit-mail', 'ManageMailController@editMail')->name('edit-mail');

Route::post('add-mail', 'ManageMailController@addMail')->name('add-mail');

Route::post('del-mail', 'ManageMailController@delMail')->name('del-mail');

Route::get('templateMail','ManageMailController@templateMail')->name('templateMail');

Route::post('updateTemplate','ManageMailController@updateTemplate');

Route::get('uploadFile','UploadFileController@uploadFile')->name('uploadFile');

Route::post('uploadSubmit', 'UploadFileController@uploadSubmit')->name('uploadSubmit');
