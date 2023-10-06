<?php

use App\Models\User;
use App\Printers\ContractDocumentPrinter;
use App\Printers\XMLDocument;
use App\Services\LaPoste\Actions\ShowGenerated;
use App\Services\YouSign\Controllers\CallLogController;
use App\Http\Controllers\{
    ContractController,
    DashboardController,
    ForceDeleteController,
    NavController,
    RestoreController,
    SearchController,
    SepaController,
    UnpaidLetterController
};
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified', 'roles:' . (new User())->adminUsers()->pluck('id')->join('|')])
    ->prefix('panel')->name('panel.')->group(callback: function () {

        Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard');

        include('users.php');

        // NAV
        Route::resource('nav', NavController::class);

        // Recherche
        Route::get('search', [SearchController::class, 'parse'])->name('search');

        // Generic
        Route::delete('forceDelete', [ForceDeleteController::class, 'process'])->name('forcedelete');
        Route::post('restore', [RestoreController::class, 'process'])->name('restore');



    });
