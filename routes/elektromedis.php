<?php

use App\Http\Controllers\Medic\ElektromedisController;
use App\Http\Controllers\Movie\MovieController;
use Illuminate\Support\Facades\Route;

Route::prefix('{akses}/{id}/application')->group(function () {
    Route::get('elektromedis/pendaftaran-elektromedis', [ElektromedisController::class, 'pendaftaran_elektromedis'])->name('pendaftaran_elektromedis');
    Route::get('menu-elektromedis/elektromedis-handling', [ElektromedisController::class, 'menu_elektromedis_handling'])->name('menu_elektromedis_handling');
});

Route::prefix('elektromedis')->name('elektromedis.')->group(function () {
    Route::get('/pendaftaran', [ElektromedisController::class, 'create'])->name('create');
    Route::post('/pendaftaran', [ElektromedisController::class, 'store'])->name('store');
    Route::get('/pendaftaran/sukses/{id}', [ElektromedisController::class, 'success'])->name('success');
});
Route::post('elektromedis/pendaftaran-elektromedis/store', [ElektromedisController::class, 'store_pendaftaran'])->name('pendaftaran_elektromedis.store');
Route::post('menu-elektromedis/update-status/{regId}', [ElektromedisController::class, 'update_handling_status'])->name('elektromedis.update_handling');
// Rute untuk Form Pemeriksaan ECG
Route::get('/elektromedis/ecg-form/{registration_number}', [ElektromedisController::class, 'form_pemeriksaan_ecg'])
    ->name('elektromedis.form_ecg');

// Rute untuk Menyimpan Hasil Pemeriksaan ECG
Route::post('/elektromedis/ecg-store/{registration_id}', [ElektromedisController::class, 'store_pemeriksaan_ecg'])
    ->name('elektromedis.store_ecg');
