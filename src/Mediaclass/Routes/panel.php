<?php

use MetaFramework\Mediaclass\Accessors\Cropable;
use Illuminate\Support\Facades\Route;
use MetaFramework\Mediaclass\Models\Mediaclass;

Route::prefix('mediaclass')->name('mediaclass.')->group(function () {
    Route::get('cropable/{media}', fn(Mediaclass $media) => Cropable::form($media))->name('cropable');
});
