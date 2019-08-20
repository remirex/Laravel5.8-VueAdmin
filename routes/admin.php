<?php


Route::prefix('admin')->group(function () {
    Route::get('dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('users', 'Admin\UserManagementController@users')->name('admin.users');
});

/* VueJS routes */
Route::get('{path}','Admin\AdminController@index')->where( 'path', '([A-z\d-\/_.]+)?' );


