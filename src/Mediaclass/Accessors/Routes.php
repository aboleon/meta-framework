<?php

namespace MetaFramework\Mediaclass\Accessors;


use Illuminate\Support\Facades\Route;

class Routes
{
    public static function panel(): void
    {
        Route::prefix('mediaclass')->name('mediaclass.')->group(function() {
           Route::get('cropable/{media}', fn(\MetaFramework\Mediaclass\Models\Mediaclass $media) => Cropable::form($media))->name('cropable');
        });
    }
}
