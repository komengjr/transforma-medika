<?php

use App\Http\Controllers\BrainTest\BrainTestController;
use App\Http\Controllers\Exam\ExamController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::prefix('{akses}/{id}')->group(function () {
    Route::get('master-brain-test/master-data-test', [BrainTestController::class, 'brain_test_master_data'])->name('brain_test_master_data');
    Route::get('menu-brain-test/menu-responden', [BrainTestController::class, 'brain_test_menu_responden'])->name('brain_test_menu_responden');
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
    Route::post('/paket', [BrainTestController::class, 'storePaket'])->name('paket.store');
    Route::delete('/paket/{id}', [BrainTestController::class, 'destroyPaket'])->name('paket.destroy');
    // Route soal
    Route::get('/kategori/{kategoriId}/soal', [BrainTestController::class, 'index'])->name('soal.index');
    Route::post('/kategori/{kategoriId}/soal', [BrainTestController::class, 'storeSoal'])->name('soal.store');
    Route::post('/kategori/{kategoriId}/soal/import', [BrainTestController::class, 'import'])->name('soal.import');
    Route::delete('/soal/{id}', [BrainTestController::class, 'destroy'])->name('soal.destroy');
    Route::get('/kategori/{kategoriId}/json-soal', [BrainTestController::class, 'getJsonSoal'])->name('soal.json');
    // Route::get('/kategori/template-excel', [BrainTestController::class, 'downloadTemplate'])->name('soal.template');


    Route::get('/preview/{paketId}', [BrainTestController::class, 'preview'])->name('preview');
    Route::get('/paket/{paketId}/json-soal', [BrainTestController::class, 'jsonSoalPaket'])->name('paket.json-soal');
});
// Route::get('/admin/brain-test/kategori/{kategoriId}/preview', [BrainTestController::class, 'preview'])->name('admin.brain-test.preview');
Route::prefix('tes')->name('brain-test.tes.')->group(function () {
    // Halaman form identitas & ujian per paket
    Route::get('/{paketId}', [ExamController::class, 'halamanTes'])->name('halaman');

    // Mulai / lanjutkan sesi berdasarkan Email atau No. HP (unique ID)
    Route::post('/{paketId}/mulai', [ExamController::class, 'mulaiSesiTes'])->name('mulai');

    // Cek / lanjutkan sesi aktif berdasarkan tokenSesi
    Route::get('/{paketId}/sesi/{tokenSesi}', [ExamController::class, 'resumeSesiTes'])->name('resume');

    // Simpan jawaban / status ragu-ragu per soal
    Route::post('/sesi/{tokenSesi}/jawab', [ExamController::class, 'simpanJawabanSesi'])->name('jawab');

    // Selesaikan ujian & hitung skor
    Route::post('/sesi/{tokenSesi}/selesai', [ExamController::class, 'selesaiSesiTes'])->name('selesai');
});
Route::prefix('bank-soal')->name('public.brain-test.')->group(function () {
    Route::get('/', [PageController::class, 'publicBankSoal'])->name('index');
});
// routes/web.php (contoh di dalam grup route admin)
Route::post('admin/brain-test/sesi/{sesiId}/reset', [PageController::class, 'resetSesiResponden'])->name('admin.brain-test.sesi.reset');

Route::prefix('admin/brain-test')->name('admin.brain-test.')->group(function () {
    // Import soal ke dalam kategori tertentu (sesuai modalImportExcelInModal)
    Route::post('/kategori/{kategoriId}/soal/import', [BrainTestController::class, 'importSoal'])->name('soal.import');
    // Download template CSV/Excel contoh soal
    Route::get('/soal/template', [BrainTestController::class, 'downloadTemplateSoal'])->name('soal.template');
    Route::post('/master/import', [BrainTestController::class, 'importMasterLengkap'])->name('master.import');
});
