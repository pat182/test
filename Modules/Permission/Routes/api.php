<?php

use Illuminate\Http\Request;


Route::group(['middleware' => ['api', 'jwt.verify'],'prefix'=>'permission'],function(){
    Route::get('/', 'PermissionController@index')->name('view-permission-mtx');

    Route::post('/', 'PermissionController@create')->middleware('permission')->name('add-permission');

    Route::get('/view-permission/{perm_id}', 'PermissionController@show')->middleware('permission')->name('view-permission');

    Route::post('/add-type', 'PermissionController@addType')->middleware('permission')->name('add-permission-type');

    Route::post('/add-group', 'PermissionController@addPermGroup')->middleware('permission')->name('add-permission-group');


    Route::delete('/remove-permission', 'PermissionController@removePermission')->middleware('permission')->name('remove-permission');

    Route::delete('/delete-type/{type_id}', 'PermissionController@deleteType')->middleware('permission')->name('delete-permission-type');
    
    Route::post('/permissions-auto', 'PermissionController@permAuto')->name('auto-complete-permission');
});
Route::post('permission/role-auto','PermissionController@roleAuto')->name('auto-complete-role');


