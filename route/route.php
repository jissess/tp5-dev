<?php

use think\facade\Route;

Route::group('api', function () {
    //前台页面
    Route::group('home', function () {
        Route::get('test', 'test/index');
    })->prefix('home/');

    //后台页面
    Route::group('admin', function () {
        Route::get('test', 'test/index');
        Route::post('login', 'login/login');

        Route::post('logout', 'login/logout')->middleware('jwt-verify');
        Route::get('test1', 'test/test1')->middleware('jwt-verify');

    })->prefix('admin/');
});
