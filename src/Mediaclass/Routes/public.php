<?php

use Illuminate\Support\Facades\Route;
use Aboleon\MetaFramework\Mediaclass\Controllers\AjaxController;

Route::middleware(['web'])->post('mediaclass-ajax', [AjaxController::class, 'distribute'])->name('mediaclass.ajax');