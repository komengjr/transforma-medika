<?php

use App\Http\Controllers\Koperasi\KoperasiController;
use Illuminate\Support\Facades\Route;
// FARMASI
Route::prefix('koperasi/')->group(function (): void {
    Route::post('menu-koperasi/registrasi-peserta/add-data', [KoperasiController::class, 'menu_koperasi_registrasi_peserta_add'])->name('menu_koperasi_registrasi_peserta_add');

    Route::post('menu-peminjaman/peminjaman-uang/cari-data-peserta', [KoperasiController::class, 'menu_peminjaman_uang_cari_peserta'])->name('menu_peminjaman_uang_cari_peserta');
    Route::post('menu-peminjaman/peminjaman-uang/pilih-data-peserta', [KoperasiController::class, 'menu_peminjaman_uang_pilih_peserta'])->name('menu_peminjaman_uang_pilih_peserta');

    Route::post('master-koperasi/peserta-koperasi/add-peserta', [KoperasiController::class, 'master_koperasi_peserta_add'])->name('master_koperasi_peserta_add');
    Route::post('master-koperasi/peserta-koperasi/save-peserta', [KoperasiController::class, 'master_koperasi_peserta_save'])->name('master_koperasi_peserta_save');

    Route::post('master-koperasi/cabang-koperasi/add-verifikasi', [KoperasiController::class, 'master_koperasi_cabang_add_verifikasi'])->name('master_koperasi_cabang_add_verifikasi');
    Route::post('master-koperasi/cabang-koperasi/save-data-verifikasi', [KoperasiController::class, 'master_koperasi_cabang_save_data_verifikasi'])->name('master_koperasi_cabang_save_data_verifikasi');
    Route::post('master-koperasi/cabang-koperasi/update-data-setup', [KoperasiController::class, 'master_koperasi_cabang_update_data_setup'])->name('master_koperasi_cabang_update_data_setup');
    Route::post('master-koperasi/cabang-koperasi/save-data-setup', [KoperasiController::class, 'master_koperasi_cabang_save_data_setup'])->name('master_koperasi_cabang_save_data_setup');

    Route::post('master-koperasi/divisi-koperasi/add-divisi', [KoperasiController::class, 'master_koperasi_divisi_add'])->name('master_koperasi_divisi_add');
    Route::post('master-koperasi/divisi-koperasi/save-divisi', [KoperasiController::class, 'master_koperasi_divisi_save'])->name('master_koperasi_divisi_save');
    Route::post('master-koperasi/divisi-koperasi/add-divisi-bagian', [KoperasiController::class, 'master_koperasi_divisi_add_bagian'])->name('master_koperasi_divisi_add_bagian');
    Route::post('master-koperasi/divisi-koperasi/save-divisi-bagian', [KoperasiController::class, 'master_koperasi_divisi_save_bagian'])->name('master_koperasi_divisi_save_bagian');

    Route::post('master-koperasi/klasifikasi-simpanan-pokok/add-data', [KoperasiController::class, 'master_koperasi_simpanan_pokok_add'])->name('master_koperasi_simpanan_pokok_add');
    Route::post('master-koperasi/klasifikasi-simpanan-pokok/save-data', [KoperasiController::class, 'master_koperasi_simpanan_pokok_save'])->name('master_koperasi_simpanan_pokok_save');

    Route::post('master-koperasi/klasifikasi-simpanan-wajib/add-data', [KoperasiController::class, 'master_koperasi_simpanan_wajib_add'])->name('master_koperasi_simpanan_wajib_add');
    Route::post('master-koperasi/klasifikasi-simpanan-wajib/save-data', [KoperasiController::class, 'master_koperasi_simpanan_wajib_save'])->name('master_koperasi_simpanan_wajib_save');
});
