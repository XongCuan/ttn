<?php

use Illuminate\Support\Facades\Route;

Route::middleware([TCore\Acl\Http\Middleware\ManagerMarketingMiddleware::class])
->prefix('/marketings')
->name('marketing.')
->group(function() {
    Route::controller(TCore\Marketing\Http\Controllers\Statistic\StatisticController::class)
    ->prefix('/statistics')
    ->name('statistic.')
    ->group(function() {
        Route::get('/', 'index')->name('index');
    });
});