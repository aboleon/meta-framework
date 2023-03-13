<?php

use Illuminate\Support\Facades\Route;
use MetaFramework\Controllers\AjaxController;


// Ajax requests
Route::post('ajax', [AjaxController::class, 'distribute'])->name('ajax');
include(__DIR__ . '/../Mediaclass/Routes/panel.php');