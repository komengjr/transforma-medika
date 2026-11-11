<?php

use App\Http\Controllers\Farmasi\FarmasiController;
use Illuminate\Support\Facades\Route;
// FARMASI
Route::prefix('{akses}/{id}')->group(function (): void {
    // FARMASI
    Route::get('menu-farmasi/order-pasien-internal', [FarmasiController::class, 'menu_farmasi_order_internal'])->name('menu_farmasi_order_internal');
    Route::get('penjualan/penjualan-non-resep', [FarmasiController::class, 'penjualan_non_resep'])->name('penjualan_non_resep');
    Route::get('penjualan/penjualan-dengan-resep', [FarmasiController::class, 'penjualan_farmasi_resep'])->name('penjualan_farmasi_resep');
    Route::get('penjualan/verifikasi-resep-dan-dosis', [FarmasiController::class, 'penjualan_verifikasi_dosis_resep'])->name('penjualan_verifikasi_dosis_resep');
    Route::get('penjualan/cetak-nota-pembelian', [FarmasiController::class, 'penjualan_cetak_nota_farmmasi'])->name('penjualan_cetak_nota_farmmasi');
    Route::get('penjualan/history-penjualan', [FarmasiController::class, 'penjualan_history_penjualan'])->name('penjualan_history_penjualan');
    Route::get('manajemen-farmasi/pembelian-obat', [FarmasiController::class, 'manajemen_farmasi_pembelian_obat'])->name('manajemen_farmasi_pembelian_obat');
    Route::get('manajemen-farmasi/penerimaan-barang', [FarmasiController::class, 'manajemen_farmasi_penerimaan_barang'])->name('manajemen_farmasi_penerimaan_barang');
    Route::get('manajemen-farmasi/pembuatan-faktur', [FarmasiController::class, 'manajemen_farmasi_pembuatan_faktur'])->name('manajemen_farmasi_pembuatan_faktur');
    Route::get('manajemen-farmasi/riwayat-transaksi-pembelian', [FarmasiController::class, 'manajemen_farmasi_riwayat_transaksi'])->name('manajemen_farmasi_riwayat_transaksi');
    Route::get('manajemen-farmasi/data-obat', [FarmasiController::class, 'manajemen_farmasi_data_obat'])->name('manajemen_farmasi_data_obat');
    Route::get('manajemen-farmasi/obat-masuk-dan-keluar', [FarmasiController::class, 'manajemen_farmasi_obat_in_out'])->name('manajemen_farmasi_obat_in_out');
    Route::get('manajemen-farmasi/stok-min-and-max', [FarmasiController::class, 'manajemen_farmasi_stock_min_max'])->name('manajemen_farmasi_stock_min_max');
    Route::get('manajemen-farmasi/data-supplier', [FarmasiController::class, 'manajemen_farmasi_data_supplier'])->name('manajemen_farmasi_data_supplier');
    Route::get('manajemen-farmasi/data-pelanggan', [FarmasiController::class, 'manajemen_farmasi_data_pelanggan'])->name('manajemen_farmasi_data_pelanggan');
    Route::get('master-data-farmasi/data-harga', [FarmasiController::class, 'master_data_farmasi_harga_obat'])->name('master_data_farmasi_harga_obat');
});
Route::prefix('farmasi/')->group(function (): void {
    // Route untuk DataTables List Order Internal
    Route::get('order-internal/data', [FarmasiController::class, 'getOrderInternalData'])->name('farmasi.order.internal.data');

    // Route untuk Modal Detail Order Resep Internal
    Route::get('order-internal/detail', [FarmasiController::class, 'getDetailOrderInternal'])->name('farmasi.order.internal.detail');

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

    Route::post('master-data-farmasi/master-harga-obat/save', [FarmasiController::class, 'master_data_farmasi_harga_obat_save'])->name('farmasi.harga.obat.save');
    Route::get('master-data-farmasi/master-harga-obat/get', [FarmasiController::class, 'master_data_farmasi_harga_obat_get'])->name('manajemen_farmasi_harga_obat_get');
});
