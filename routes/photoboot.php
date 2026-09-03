<?php

use App\Http\Controllers\Photobooth\PhotoboothController;
use Illuminate\Support\Facades\Route;

Route::prefix('{akses}/{id}')->group(function (): void {
    Route::get('menu-photobooth/setup-photobooth', [PhotoboothController::class, 'menu_photobooth_setup'])->name('menu_photobooth_setup');
});

Route::post('/photobooth/setup', [PhotoboothController::class, 'storesetup'])->name('photobooth.setup.store');
Route::post('/photobooth/setup/{id}/frame', [PhotoboothController::class, 'storeFrame'])->name('photobooth.setup.frame.store');

// Route Photobooth Client (Akses per Organisasi via Kode)
Route::get('/photobooth/{org_code}', [PhotoboothController::class, 'clientView'])->name('photobooth.client');

Route::get('/setup-photo', [PhotoboothController::class, 'index'])->name('photobooth.index');
Route::post('/photobooth/store', [PhotoboothController::class, 'store'])->name('photobooth.store');
Route::get('/photobooth/result/{code}', [PhotoboothController::class, 'show'])->name('photobooth.show');
// Route::get('/photobooth/{id}', [PhotoboothController::class, 'show'])->name('photobooth.show');
Route::get('/photobooth/{code}/image', [PhotoboothController::class, 'getImage'])->name('photobooth.image');


