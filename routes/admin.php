<?php


Route::prefix('admin')->group(function () {
    Route::get('dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('users', 'Admin\UserManagementController@users')->name('admin.users');
    Route::post('users', 'Admin\UserManagementController@create')->name('admin.users.create');
    Route::put('users/{userID}', 'Admin\UserManagementController@edit')->name('admin.users.edit');
    Route::delete('users/{userID}', 'Admin\UserManagementController@delete')->name('admin.users.delete');
    Route::get('roles', 'Admin\RoleController@roles')->name('admin.roles');
    Route::get('permissions', 'Admin\PermissionController@permissions')->name('admin.permissions');
});

/* VueJS routes */
Route::get('{path}','Admin\AdminController@index')->where( 'path', '([A-z\d-\/_.]+)?' );


