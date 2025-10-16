<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/accounting')
->name('accounting.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\AccountingMiddleware::class])
    ->group(function () {

        Route::controller(TCore\Accounting\Http\Controllers\Receipt\ReceiptTypeController::class)
        ->prefix('/receipt-types')
        ->name('receipt_type.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
        });

        Route::controller(TCore\Accounting\Http\Controllers\Receipt\ReceiptController::class)
        ->prefix('/receipts')
        ->name('receipt.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::get('/show/{id}', 'show')->name('show');
        });
    });
});