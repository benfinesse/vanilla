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

Route::group(['middleware'=>['auth','access']], function (){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::resource('record', 'Record\RecordController');
    Route::resource('measure', 'Admin\MeasureController');
    Route::resource('group', 'Admin\GroupController');
    Route::get('record/manage/{uuid}', 'Record\RecordController@manage')->name('record.manage');
    Route::get('record/list/{uuid}', 'Record\RecordController@listItems')->name('record.list');

    Route::resource('process', 'Admin\OfficeProcessController');
    Route::get('process/list/{uuid}', 'Admin\OfficeProcessController@listItems')->name('process.list');

//    Route::prefix('dashboard')->group(function () { });
});
Route::get('/', 'HomeController@index')->name('home');

