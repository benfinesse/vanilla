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
    Route::get('record/resend/notice/{uuid}', 'Record\RecordController@resendNotice')->name('resend.notice');
    Route::get('group/record/edit/{uuid}', 'Record\RecordController@editGroupRecord')->name('record.group.edit');
    Route::resource('measure', 'Admin\MeasureController');
    Route::get('measure/action/delete/{uuid}', 'Admin\MeasureController@delete')->name('measure.delete');
    Route::resource('product', 'Admin\ProductController');
    Route::get('product/action/delete/{uuid}', 'Admin\ProductController@delete')->name('product.delete');
    Route::resource('group', 'Admin\GroupController');
    Route::get('group/pop/{uuid}', 'Admin\GroupController@pop')->name('group.pop');
    Route::get('record/manage/{uuid}/{gid}', 'Record\RecordController@manage')->name('record.manage');
    Route::get('record/list/{uuid}', 'Record\RecordController@listItems')->name('record.list');
    Route::post('form/record/store/{uuid}','Record\FormController@store')->name('form.store');
    Route::post('form/record/update/{uuid}','Record\FormController@update')->name('form.update');

    //update items compliance
    Route::post('update/record/item','Record\ItemController@compliance')->name('item.inject');
    Route::get('update/record/toggle/availability/item','Record\ItemController@toggleAvailability')->name('item.toggle.availability');


    //AUDIT ROUTES
    Route::get('record/audit/{uuid}', 'Record\AuditProcessController@show')->name('record.audit');

    Route::resource('process', 'Admin\OfficeProcessController');
    Route::get('process/list/{uuid}', 'Admin\OfficeProcessController@listItems')->name('process.list');
    Route::get('process/pop/{uuid}', 'Admin\OfficeProcessController@popItem')->name('process.pop');
    Route::get('process/item/move/{uuid}/{dir}', 'Process\PositionController@tryPositionMove')->name('process.item.direction');
    Route::get('process/action/toggle/verification/{uuid}', 'Admin\OfficeProcessController@toggleVerification')->name('process.toggle.verification');

    Route::get('process/action/toggle/approvable/{uuid}', 'Admin\OfficeProcessController@toggleApprovable')->name('process.toggle.approvable');

    Route::get('process/action/toggle/funds/{uuid}', 'Admin\OfficeProcessController@toggleFundable')->name('process.toggle.funds');

    Route::resource('supplier', 'Admin\SupplierController');
    Route::get('supplier/pop/{uuid}', 'Admin\SupplierController@pop')->name('supplier.pop');
    Route::get('seed/suppliers', 'Admin\SupplierController@seedSupply');

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

    Route::post('record/process/action/load/{record_id}/{group_id}','Record\RecordController@load')->name('record.load');

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


    Route::get('send/record/email', 'Record\SendRecordController@sendRecord')->name('send.record.email');


//    Route::prefix('dashboard')->group(function () { });
});
Route::get('/', 'HomeController@index')->name('home');
Route::get('register', 'HomeController@register')->name('home');
Route::get('dev/test/email/{email}', 'Developer\TestController@email');

Route::get('account/{t}/co/{r}', 'Admin\AccountController@complete')->name('account.complete');
Route::post('account/finish/{t}/user/{r}', 'Admin\AccountController@completeAccount')->name('complete.account');

Route::get('test/pending/{id}', 'Developer\TestController@pending');

Route::get('refresh-csrf', 'Admin\AccountController@refreshCsrf');