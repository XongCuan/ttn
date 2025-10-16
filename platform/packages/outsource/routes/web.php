<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/outsource')
->name('outsource.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\OutsourceMiddleware::class])
    ->group(function () {

        Route::get('/select-order', [TCore\Outsource\Http\Controllers\SelectOrderController::class, 'lists'])->name('select_order');
        Route::get('/select-requirement', [TCore\Outsource\Http\Controllers\SelectRequirementController::class, 'lists'])->name('select_requirement');
        Route::get('/select-team', [TCore\Outsource\Http\Controllers\SelectTeamController::class, 'lists'])->name('select_team');
        Route::get('/select-employees/{team_id?}', [TCore\Outsource\Http\Controllers\SelectEmployeeController::class, 'lists'])->name('select_employee');

        Route::controller(TCore\Outsource\Http\Controllers\ProjectController::class)
        ->prefix('/projects')
        ->name('project.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/change-status/{id}', 'changeStatus')->name('change_status');
            Route::put('/change-status', 'updateStatus')->name('update_change_status');

            Route::get('show/{id}', 'show')->name('show');

            Route::middleware([TCore\Acl\Http\Middleware\LeaderOutsourceMiddleware::class])
            ->group(function () {
                Route::get('/order-info', 'orderInfo')->name('order_info');
                Route::get('/requirement-info', 'requirementInfo')->name('requirement_info');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::put('/update', 'update')->name('update');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
        });

        Route::controller(TCore\Outsource\Http\Controllers\DashboardController::class)->prefix('/dasboard')
        ->middleware([TCore\Acl\Http\Middleware\ManagerOutsourceMiddleware::class])
        ->name('dashboard.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });

        Route::controller(TCore\Outsource\Http\Controllers\LeaveRequestController::class)->prefix('/leave-request')
        ->middleware([TCore\Acl\Http\Middleware\ManagerOutsourceMiddleware::class])
        ->name('leave_request.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
        
    });
});