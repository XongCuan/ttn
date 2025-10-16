<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/webadmin')
->name('webadmin.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\WebadminMiddleware::class])
    ->group(function () {

        Route::controller(TCore\Webadmin\Http\Controllers\ProjectRequirementController::class)
        ->prefix('/project_requirements')
        ->name('project_requirement.')
        ->group(function () {

            Route::middleware([TCore\Acl\Http\Middleware\LeaderWebadminMiddleware::class])
            ->group(function () {
                Route::get('/order-info', 'orderInfo')->name('order_info');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });  
                     
            Route::get('/change-status/{id}', 'changeStatus')->name('change_status');
            Route::put('/change-status', 'updateStatus')->name('update_change_status');
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/confirm-demo/{id}', 'confirmDemo')->name('confirm_demo');
            Route::put('/confirm-demo', 'handleConfirmDemo')->name('handle_confirm_demo');

            Route::put('/update', 'update')->name('update');

        });
    });
});