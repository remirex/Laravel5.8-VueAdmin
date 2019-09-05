<?php


Route::prefix('admin')->group(function () {
    Route::get('dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
    // Users
    Route::get('users', 'Admin\UserManagementController@users')->name('admin.users');
    Route::post('users', 'Admin\UserManagementController@create')->name('admin.users.create');
    Route::put('users/{userID}', 'Admin\UserManagementController@edit')->name('admin.users.edit');
    Route::delete('users/{userID}', 'Admin\UserManagementController@delete')->name('admin.users.delete');
    Route::get('findUser', 'Admin\UserManagementController@search')->name('admin.users.search');
    // Roles
    Route::get('roles', 'Admin\RoleController@roles')->name('admin.roles');
    Route::post('roles', 'Admin\RoleController@create')->name('admin.roles.create');
    Route::put('roles/{roleID}', 'Admin\RoleController@edit')->name('admin.roles.edit');
    Route::delete('roles/{roleID}', 'Admin\RoleController@delete')->name('admin.roles.delete');
    // Permission
    Route::get('permissions', 'Admin\PermissionController@permissions')->name('admin.permissions');
    Route::post('permissions', 'Admin\PermissionController@create')->name('admin.permissions.create');
    Route::put('permissions/{permissionID}', 'Admin\PermissionController@edit')->name('admin.permissions.edit');
    Route::delete('permissions/{permissionID}', 'Admin\PermissionController@delete')->name('admin.permissions.delete');
});

/* VueJS routes */
Route::get('{path}','Admin\AdminController@index')->where( 'path', '([A-z\d-\/_.]+)?' );


