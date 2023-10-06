<?php
/**
 * Utilisateurs
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AccountDocumentController,
    AccountMailController,
    AccountPhoneController,
    AccountController,
    GroupAddressController,
    GroupController,
    RoleController,
    AccountAddressController,
    UserController};

Route::get('role', [RoleController::class, 'index'])->name('roles');

Route::get('users/oftype/{role}', [UserController::class, 'index'])->name('users.index');
Route::get('users/create/{role}', [UserController::class, 'create'])->name('users.create_type');
Route::resource('users', UserController::class)->except(['index']);

Route::prefix('accounts')->name('accounts.')->group(function () {
    Route::get('oftype/{role}', [AccountController::class, 'index'])->name('index');
    Route::get('oftype/{role}/archived', [AccountController::class, 'index'])->name('archived');
    Route::post('restore/{account}', [AccountController::class, 'restore'])->name('restore');
    Route::any('search', [AccountController::class, 'search'])->name('search');
});
Route::resource('accounts', AccountController::class)->except('index');

Route::resource('accounts.addresses', AccountAddressController::class);
Route::resource('accounts.phone', AccountPhoneController::class);
Route::resource('accounts.mail', AccountMailController::class);
Route::resource('accounts.documents', AccountDocumentController::class);
//Route::resource('useraddresses', UserAddressController::class);
//Route::any('accountSearch', [AccountSearchController::class, 'index'])->name('accounts.search');






