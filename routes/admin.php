<?php


Route::prefix('admin')->group(function () {
    Route::get('dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('users', 'Admin\UserManagementController@users')->name('admin.users');
    Route::get('roles', 'Admin\AdminController@roles')->name('admin.roles');
    Route::get('permissions', 'Admin\AdminController@permissions')->name('admin.permissions');
});

/* VueJS routes */
Route::get('{path}','Admin\AdminController@index')->where( 'path', '([A-z\d-\/_.]+)?' );


