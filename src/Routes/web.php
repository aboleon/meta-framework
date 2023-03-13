<?php

use Illuminate\Support\Facades\Route;
use MetaFramework\Accessors\Routing;
use MetaFramework\Controllers\AjaxController;

Route::prefix(Routing::backend())
    ->middleware(['web', 'auth:sanctum'])->group(function () {
        // Ajax requests
        Route::post('ajax', [AjaxController::class, 'distribute'])->name('ajax');
    });