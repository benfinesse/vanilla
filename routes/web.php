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
    Route::get('record/pop/{uuid}', 'Record\RecordController@pop')->name('record.pop');
    Route::resource('measure', 'Admin\MeasureController');
    Route::resource('group', 'Admin\GroupController');
    Route::get('record/manage/{uuid}/{gid}', 'Record\RecordController@manage')->name('record.manage');
    Route::get('record/list/{uuid}', 'Record\RecordController@listItems')->name('record.list');
    Route::post('form/record/store/{uuid}','Record\FormController@store')->name('form.store');


    //AUDIT ROUTES
    Route::get('record/audit/{uuid}', 'Record\AuditProcessController@show')->name('record.audit');

    Route::resource('process', 'Admin\OfficeProcessController');
    Route::get('process/list/{uuid}', 'Admin\OfficeProcessController@listItems')->name('process.list');
    Route::get('process/item/move/{uuid}/{dir}', 'Process\PositionController@tryPositionMove')->name('process.item.direction');

    Route::get('process/state/create/{uuid}', 'Admin\OfficeController@create')->name('process.stage.create');
    Route::post('process/state/store/{uuid}', 'Admin\OfficeController@store')->name('process.stage.store');
    Route::get('process/item/manage/{uuid}', 'Admin\OfficeController@manage')->name('process.item.manage');

    Route::get('office/action/delete/{uuid}', 'Admin\OfficeController@pop')->name('office.pop');
    Route::get('office/action/add/member', 'Admin\OfficeController@addMember')->name('office.add.member');
    Route::get('office/action/remove/member', 'Admin\OfficeController@removeMember')->name('office.remove.member');

    //RECORD PROCESS
    Route::get('record/process/action/start/{record_id}','Record\ProcessController@start')->name('record.process.start');
    Route::get('record/process/action/next/{record_id}/{dir}','Record\ProcessController@moveOffice')->name('record.process.next_office');

    Route::get('record/process/action/close/{record_id}','Record\ProcessController@close')->name('record.close');
    Route::get('record/action/show/history/{record_id}','Record\ProcessController@history')->name('record.history');


    //NOTIFICATION LIST
    Route::get('notifications','Admin\NotificationController@index')->name('notice.index');
    Route::get('notifications/preview/{uuid}','Admin\NotificationController@preview')->name('open.notice');

    //USER ROUTES
    Route::resource('account','Admin\AccountController');

    //ROLE ROUTES
    Route::resource('role','Admin\RoleController');
    Route::get('account/role/manage/{uuid}','Admin\RoleController@manage')->name('role.manage');
    Route::get('role/action/add/member', 'Admin\RoleController@addMember')->name('role.add.member');
    Route::get('role/action/remove/member', 'Admin\RoleController@removeMember')->name('role.remove.member');


//    Route::prefix('dashboard')->group(function () { });
});
Route::get('/', 'HomeController@index')->name('home');
Route::get('dev/test/email/{email}', 'Developer\TestController@email');

