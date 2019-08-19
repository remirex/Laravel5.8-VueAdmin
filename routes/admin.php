<?php


Route::prefix('admin')->group(function () {
    Route::get('dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
});

/* VueJS routes */
Route::get('{path}','Admin\AdminController@index')->where( 'path', '([A-z\d-\/_.]+)?' );


