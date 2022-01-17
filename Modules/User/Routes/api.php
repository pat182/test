<?php

use Illuminate\Http\Request;


Route::group(['middleware' => ['api', 'jwt.verify'],'prefix'=>'user'],function(){
    // Route::post('/', 'PermissionController@create')->middleware('permission')->name('add-permission');
    Route::put('/update-profile', 'UserController@updateProfile')->name('update-user-profile');
    Route::put('/update-permission/{user_id}', 'UserController@updateUserPerm')->middleware('permission')->name('update-user-permission');
    Route::delete('/delete/{user_id}', 'UserController@destroy')->middleware('permission')->name('delete-user');
});