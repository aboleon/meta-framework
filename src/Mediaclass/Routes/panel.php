<?php

use Illuminate\Support\Facades\Route;
use Aboleon\MetaFramework\Mediaclass\Cropable;
use Aboleon\MetaFramework\Mediaclass\Models\Media;


Route::prefix('mediaclass')
    ->name('mediaclass.')
    ->middleware(['web', 'auth:sanctum'])
    ->group(function () {
        Route::get('cropable/{media}', fn(Media $media) => Cropable::form($media))->name('cropable');
    });
