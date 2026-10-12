<?php

use App\Http\Controllers\BrainTest\BrainTestController;
use App\Http\Controllers\Exam\ExamController;
use Illuminate\Support\Facades\Route;

Route::prefix('{akses}/{id}')->group(function () {
    Route::get('master-brain-test/master-data-test', [BrainTestController::class, 'brain_test_master_data'])->name('brain_test_master_data');
});

Route::prefix('exam')->name('exam.')->group(function () {
    Route::get('/test', [ExamController::class, 'test'])->name('test');
});
Route::group(['prefix' => 'admin/brain-test', 'as' => 'admin.brain-test.'], function () {
    // Halaman Utama Master Data (Klasifikasi & Kategori)

    // Proses Simpan Klasifikasi
    Route::post('/klasifikasi', [BrainTestController::class, 'storeKlasifikasi'])->name('klasifikasi.store');

    // Proses Simpan Kategori
    Route::post('/kategori', [BrainTestController::class, 'storeKategori'])->name('kategori.store');

    // Hapus data
    Route::delete('/klasifikasi/{id}', [BrainTestController::class, 'destroyKlasifikasi'])->name('klasifikasi.destroy');
    Route::delete('/kategori/{id}', [BrainTestController::class, 'destroyKategori'])->name('kategori.destroy');

    // Route soal
    Route::get('/kategori/{kategoriId}/soal', [BrainTestController::class, 'index'])->name('soal.index');
    Route::post('/kategori/{kategoriId}/soal', [BrainTestController::class, 'storeSoal'])->name('soal.store');
    Route::post('/kategori/{kategoriId}/soal/import', [BrainTestController::class, 'import'])->name('soal.import');
    Route::delete('/soal/{id}', [BrainTestController::class, 'destroy'])->name('soal.destroy');
    Route::get('/kategori/{kategoriId}/json-soal', [BrainTestController::class, 'getJsonSoal'])->name('soal.json');
    Route::get('/kategori/template-excel', [BrainTestController::class, 'downloadTemplate'])->name('soal.template');
});
Route::get('/admin/brain-test/kategori/{kategoriId}/preview', [BrainTestController::class, 'preview'])->name('admin.brain-test.preview');
