<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/superadmin')
->name('superadmin.')
->group(function() {
    Route::middleware([TCore\Acl\Http\Middleware\SuperadminMiddleware::class])
    ->group(function () {
        Route::controller(TCore\Superadmin\Http\Controllers\Document\DocumentTypeController::class)
        ->prefix('/document-types')
        ->name('document_type.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
        });

        Route::controller(TCore\Superadmin\Http\Controllers\Document\DocumentController::class)
        ->prefix('/documents')
        ->name('document.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::get('/show/{id}', 'show')->name('show');
        });

        Route::get('/quan-ly-tai-lieu', function() {
            
            return view('packages_superadmin::documents.ckfinder');

        })->name('ckfinder');

    });
});