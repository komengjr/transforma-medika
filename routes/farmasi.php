<?php

use App\Http\Controllers\Farmasi\FarmasiController;
use Illuminate\Support\Facades\Route;
// FARMASI
Route::prefix('farmasi/')->group(function (): void {
    Route::post('penjualan/penjualan-non-resep/cari-data', [FarmasiController::class, 'penjualan_non_resep_cari_data'])->name('penjualan_non_resep_cari_data');
    Route::post('penjualan/penjualan-non-resep/save-data', [FarmasiController::class, 'penjualan_non_resep_save_data'])->name('penjualan_non_resep_save_data');
    Route::post('penjualan/penjualan-non-resep/remove-data', [FarmasiController::class, 'penjualan_non_resep_remove_data'])->name('penjualan_non_resep_remove_data');
    Route::post('penjualan/penjualan-non-resep/show-data-list', [FarmasiController::class, 'penjualan_non_resep_show_data_list'])->name('penjualan_non_resep_show_data_list');
    Route::post('penjualan/penjualan-non-resep/payment-data-list', [FarmasiController::class, 'penjualan_non_resep_payment_data_list'])->name('penjualan_non_resep_payment_data_list');
    Route::post('penjualan/penjualan-non-resep/payment-pilih', [FarmasiController::class, 'penjualan_non_resep_payment_pilih'])->name('penjualan_non_resep_payment_pilih');
    Route::post('penjualan/penjualan-non-resep/payment-confrim', [FarmasiController::class, 'penjualan_non_resep_payment_confrim'])->name('penjualan_non_resep_payment_confrim');

    Route::post('penjualan/penjualan-resep/show-data-list', [FarmasiController::class, 'penjualan_resep_show_data_list'])->name('penjualan_resep_show_data_list');
    Route::post('penjualan/penjualan-resep/payment-data-list', [FarmasiController::class, 'penjualan_resep_payment_data_list'])->name('penjualan_resep_payment_data_list');
    Route::post('penjualan/penjualan-resep/payment-pilih', [FarmasiController::class, 'penjualan_resep_payment_pilih'])->name('penjualan_resep_payment_pilih');
    Route::post('penjualan/penjualan-resep/payment-confrim', [FarmasiController::class, 'penjualan_resep_payment_confrim'])->name('penjualan_resep_payment_confrim');

    Route::post('penjualan/history-penjualan/detail', [FarmasiController::class, 'penjualan_history_penjualan_detail'])->name('penjualan_history_penjualan_detail');

    Route::post('manajemen-farmasi/data-obat/add', [FarmasiController::class, 'manajemen_farmasi_data_obat_add'])->name('manajemen_farmasi_data_obat_add');
    Route::post('manajemen-farmasi/data-obat/save', [FarmasiController::class, 'manajemen_farmasi_data_obat_save'])->name('manajemen_farmasi_data_obat_save');
    Route::post('manajemen-farmasi/data-obat/update', [FarmasiController::class, 'manajemen_farmasi_data_obat_update'])->name('manajemen_farmasi_data_obat_update');
    Route::post('manajemen-farmasi/data-obat/update-save', [FarmasiController::class, 'manajemen_farmasi_data_obat_update_save'])->name('manajemen_farmasi_data_obat_update_save');
    Route::post('manajemen-farmasi/data-obat/add-batch', [FarmasiController::class, 'manajemen_farmasi_data_obat_add_batch'])->name('manajemen_farmasi_data_obat_add_batch');
    Route::post('manajemen-farmasi/data-obat/save-batch', [FarmasiController::class, 'manajemen_farmasi_data_obat_save_batch'])->name('manajemen_farmasi_data_obat_save_batch');
    Route::post('manajemen-farmasi/data-obat/batch-detail', [FarmasiController::class, 'manajemen_farmasi_data_obat_batch_detail'])->name('manajemen_farmasi_data_obat_batch_detail');
    Route::post('manajemen-farmasi/data-obat/obat-sale', [FarmasiController::class, 'manajemen_farmasi_data_obat_obat_sale'])->name('manajemen_farmasi_data_obat_obat_sale');
    Route::post('manajemen-farmasi/data-obat/obat-sale-add', [FarmasiController::class, 'manajemen_farmasi_data_obat_obat_sale_add'])->name('manajemen_farmasi_data_obat_obat_sale_add');
});
