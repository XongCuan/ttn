<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/sales')
->name('sales.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\SalesMiddleware::class])
    ->group(function () {

        Route::controller(TCore\Sales\Http\Controllers\Contact\ContactController::class)
        ->prefix('/contacts')
        ->name('contact.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'delete')->name('delete');

            Route::controller(TCore\Sales\Http\Controllers\Contact\ActivityController::class)
            ->prefix('/activities')
            ->name('activity.')
            ->group(function () {
                Route::get('/{contact_id}', 'index')->name('index');
                Route::get('/{contact_id}/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
            });

        });
    });
});