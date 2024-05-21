<?php

use Illuminate\Support\Facades\Route;
use Aboleon\MetaFramework\Accessors\Routing;
use Aboleon\MetaFramework\Controllers\{AjaxController,
    MailController,
    MetaController,
    NavController,
    VatController};


Route::prefix(Routing::backend())
    ->name('aboleon-framework.')
    ->middleware(['web', 'auth'])->group(function () {

        // Ajax requests
        Route::post('ajax', [AjaxController::class, 'distribute'])->name('ajax');

        Route::any('mailer/{type}/{identifier}', [MailController::class, 'distribute'])->name('mailer');

        Route::prefix('meta')->name('meta.')->group(function () {
            Route::any('admin/create', [MetaController::class, 'createAdmin'])->name('create_admin');
            Route::get('create/{type}', [MetaController::class, 'create'])->name('create');
            Route::get('index/{type?}', [MetaController::class, 'index'])->name('list');
            Route::get('show/{type}/{id?}', [MetaController::class, 'show'])->name('show');
        });

        Route::patch('meta/{id}', [MetaController::class, 'patch']);
        Route::resource('meta', MetaController::class)->except(['create', 'index'])->except(['create','show']);
    });