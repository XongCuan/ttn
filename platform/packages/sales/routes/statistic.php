<?php

use Illuminate\Support\Facades\Route;

Route::middleware([TCore\Acl\Http\Middleware\ManagerSalesMiddleware::class])
->prefix('/sales')
->name('sales.')
->group(function() {
    Route::controller(TCore\Sales\Http\Controllers\Statistic\StatisticController::class)
    ->prefix('/statistics')
    ->name('statistic.')
    ->group(function() {
        Route::get('/', 'index')->name('index');
    });
});