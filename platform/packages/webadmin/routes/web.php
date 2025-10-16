<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/webadmins')
->name('webadmin.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\WebadminMiddleware::class])
    ->group(function () {

        Route::get('/select-order', [TCore\Webadmin\Http\Controllers\SelectOrderController::class, 'lists'])->name('select_order');
        Route::get('/select-team', [TCore\Webadmin\Http\Controllers\SelectTeamController::class, 'lists'])->name('select_team');
        Route::get('/select-employees/{team_id?}', [TCore\Webadmin\Http\Controllers\SelectEmployeeController::class, 'lists'])->name('select_employee');

    });
});