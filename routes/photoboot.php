<?php

use App\Http\Controllers\Photobooth\PhotoboothController;
use App\Http\Controllers\Photobooth\ViewPhotoboothController;
use Illuminate\Support\Facades\Route;

Route::prefix('{akses}/{id}')->group(function (): void {
    Route::get('menu-photobooth/setup-photobooth', [PhotoboothController::class, 'menu_photobooth_setup'])->name('menu_photobooth_setup');
    Route::get('menu-photobooth/data-photobooth', [PhotoboothController::class, 'menu_photobooth_data'])->name('menu_photobooth_data');
});

Route::post('/photobooth/setup', [PhotoboothController::class, 'storesetup'])->name('photobooth.setup.store');
Route::post('/photobooth/setup/{id}/frame', [PhotoboothController::class, 'storeFrame'])->name('photobooth.setup.frame.store');

// Route Photobooth Client (Akses per Organisasi via Kode)
Route::get('/photobooth/{org_code}', [PhotoboothController::class, 'clientView'])->name('photobooth.client');
Route::get('photobooth/{org_code}/results', [PhotoboothController::class, 'showResults'])->name('photobooth.results');
Route::get('photobooth/{org_code}/results-json', [PhotoboothController::class, 'getResultsJson'])->name('photobooth.results.json');
Route::get('/setup-photo', [PhotoboothController::class, 'index'])->name('photobooth.index');
Route::post('/photobooth/store', [PhotoboothController::class, 'store'])->name('photobooth.store');
Route::get('/photobooth/result/{code}', [ViewPhotoboothController::class, 'show'])->name('photobooth.show');
// Route::get('/photobooth/{id}', [PhotoboothController::class, 'show'])->name('photobooth.show');
Route::get('/photobooth/{code}/image', [PhotoboothController::class, 'getImage'])->name('photobooth.image');


Route::get('/photobooth-file/{path}', function ($path) {
    // 1. Cek jika path langsung di storage/app/photobooth/
    $fullPath = storage_path('app/photobooth/' . $path);

    // 2. Jika tidak ada, cek di storage/app/
    if (!file_exists($fullPath)) {
        $fullPath = storage_path('app/' . $path);
    }

    if (!file_exists($fullPath) || is_dir($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->where('path', '.*')->name('photobooth.file');
