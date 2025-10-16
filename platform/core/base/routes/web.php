<?php

use Illuminate\Support\Facades\Route;
use TCore\Acl\Http\Middleware\AuthMiddleware;

Route::prefix('/base')
->name('base.')
->group(function() {

    Route::middleware(AuthMiddleware::class)->group(function() {

        Route::controller(TCore\Base\Http\Controllers\SelectRegionController::class)
        ->prefix('/select-region')
        ->name('select_region.')
        ->group(function() {
            Route::get('/provinces', 'getProvinces')->name('province');
            Route::get('/districts/{province_code}', 'getDistricts')->name('district');
            Route::get('/wards/{district_code}', 'getWards')->name('ward');
        });

        Route::prefix('/manager-file')->name('ckfinder.')->group(function () {
            Route::any('/connect', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
                ->name('connector');
            Route::any('/duyet', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
                ->name('browser');
        });
    });
});
