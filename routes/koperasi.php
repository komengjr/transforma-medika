<?php

use App\Http\Controllers\Koperasi\KoperasiController;
use App\Http\Controllers\Koperasi\MenuPenjualanController;
use Illuminate\Support\Facades\Route;
// FARMASI
Route::prefix('koperasi/')->group(function (): void {
    Route::post('menu-koperasi/registrasi-peserta/add-data', [KoperasiController::class, 'menu_koperasi_registrasi_peserta_add'])->name('menu_koperasi_registrasi_peserta_add');

    Route::post('menu-peminjaman/peminjaman-uang/cari-data-peserta', [KoperasiController::class, 'menu_peminjaman_uang_cari_peserta'])->name('menu_peminjaman_uang_cari_peserta');
    Route::post('menu-peminjaman/peminjaman-uang/pilih-data-peserta', [KoperasiController::class, 'menu_peminjaman_uang_pilih_peserta'])->name('menu_peminjaman_uang_pilih_peserta');
    Route::post('menu-peminjaman/peminjaman-uang/proses-pengajuan-peminjaman', [KoperasiController::class, 'menu_peminjaman_uang_proses_pengajuan'])->name('menu_peminjaman_uang_proses_pengajuan');

    Route::get('menu-koperasi/simpanan-pokok/get-data', [KoperasiController::class, 'menu_koperasi_simpanan_pokok_get_data'])->name('menu_koperasi_simpanan_pokok_get_data');
    Route::post('menu-koperasi/simpanan-pokok/bayar/{id}', [KoperasiController::class, 'menu_koperasi_simpanan_pokok_bayar'])->name('menu_koperasi_simpanan_pokok_bayar');

    Route::get('menu-koperasi/simpanan-wajib/get-data', [KoperasiController::class, 'menu_koperasi_simpanan_wajib_get_data'])->name('menu_koperasi_simpanan_wajib_get_data');
    Route::post('menu-koperasi/simpanan-wajib/bayar', [KoperasiController::class, 'menu_koperasi_simpanan_wajib_bayar'])->name('menu_koperasi_simpanan_wajib_bayar');

    Route::get('menu-koperasi/simpanan-sukarela-koperasi/get-data', [KoperasiController::class, 'menu_koperasi_simpanan_sukarela_koperasi_get_data'])->name('menu_koperasi_simpanan_sukarela_koperasi_get_data');
    Route::post('menu-koperasi/simpanan-sukarela-koperasi/bayar', [KoperasiController::class, 'menu_koperasi_simpanan_sukarela_koperasi_bayar'])->name('menu_koperasi_simpanan_sukarela_koperasi_bayar');

    Route::post('menu-peminjaman/peminjaman-barang/cari-data-peserta', [KoperasiController::class, 'menu_peminjaman_barang_cari_peserta'])->name('menu_peminjaman_barang_cari_peserta');
    Route::post('menu-peminjaman/peminjaman-barang/pilih-data-peserta', [KoperasiController::class, 'menu_peminjaman_barang_pilih_peserta'])->name('menu_peminjaman_barang_pilih_peserta');
    Route::post('menu-peminjaman/peminjaman-barang/proses-pengajuan-peminjaman', [KoperasiController::class, 'menu_peminjaman_barang_proses_pengajuan'])->name('menu_peminjaman_barang_proses_pengajuan');

    Route::post('menu-peminjaman/list-peminjaman/proses-pengajuan-peminjaman-uang', [KoperasiController::class, 'menu_peminjaman_list_proses_pengajuan'])->name('menu_peminjaman_list_proses_pengajuan');
    Route::post('menu-peminjaman/list-peminjaman/proses-pengajuan-peminjaman-uang/send-verifikasi', [KoperasiController::class, 'menu_peminjaman_list_proses_pengajuan_send_verif'])->name('menu_peminjaman_list_proses_pengajuan_send_verif');
    Route::post('menu-peminjaman/list-peminjaman/proses-pengajuan-peminjaman-uang/save-verifikasi', [KoperasiController::class, 'menu_peminjaman_list_proses_pengajuan_save_verif'])->name('menu_peminjaman_list_proses_pengajuan_save_verif');
    Route::post('menu-peminjaman/list-peminjaman/cetak-slip-pengajuan-peminjaman-uang', [KoperasiController::class, 'menu_peminjaman_list_cetak_slip_pengajuan'])->name('menu_peminjaman_list_cetak_slip_pengajuan');
    Route::post('menu-peminjaman/list-peminjaman/cetak-slip-pengajuan-peminjaman-uang/report', [KoperasiController::class, 'menu_peminjaman_list_cetak_slip_pengajuan_report'])->name('menu_peminjaman_list_cetak_slip_pengajuan_report');
    Route::post('menu-peminjaman/list-peminjaman/cetak-pengajuan-peminjaman-uang', [KoperasiController::class, 'menu_peminjaman_list_cetak_pengajuan'])->name('menu_peminjaman_list_cetak_pengajuan');
    Route::post('menu-peminjaman/list-peminjaman/cetak-pengajuan-peminjaman-uang/report', [KoperasiController::class, 'menu_peminjaman_list_cetak_pengajuan_report'])->name('menu_peminjaman_list_cetak_pengajuan_report');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak'])->name('menu_peminjaman_list_cek_kontrak');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak/payment', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak_payment'])->name('menu_peminjaman_list_cek_kontrak_payment');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak/payment_fix', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak_payment_fix'])->name('menu_peminjaman_list_cek_kontrak_payment_fix');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak/payment-multi', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak_payment_multi'])->name('menu_peminjaman_list_cek_kontrak_payment_multi');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak/penyelesaian-kontrak', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak_penyelesaian_kontrak'])->name('menu_peminjaman_list_cek_kontrak_penyelesaian_kontrak');

    Route::post('menu-peminjaman/list-peminjaman-barang/proses-pengajuan-peminjaman-barang', [KoperasiController::class, 'menu_peminjaman_list_barang_proses_pengajuan'])->name('menu_peminjaman_list_barang_proses_pengajuan');
    Route::post('menu-peminjaman/list-peminjaman-barang/proses-pengajuan-peminjaman-barang/send-verifikasi', [KoperasiController::class, 'menu_peminjaman_list_barang_proses_pengajuan_send'])->name('menu_peminjaman_list_barang_proses_pengajuan_send');
    Route::post('menu-peminjaman/list-peminjaman-barang/proses-pengajuan-peminjaman-barang/save-verifikasi', [KoperasiController::class, 'menu_peminjaman_list_barang_proses_pengajuan_save'])->name('menu_peminjaman_list_barang_proses_pengajuan_save');
    Route::post('menu-peminjaman/list-peminjaman-barang/cek-status-kontrak', [KoperasiController::class, 'menu_peminjaman_list_barang_cek_status_kontrak'])->name('menu_peminjaman_list_barang_cek_status_kontrak');
    Route::post('menu-peminjaman/list-peminjaman-barang/cek-status-kontrak/payment', [KoperasiController::class, 'menu_peminjaman_list_barang_cek_status_kontrak_payment'])->name('menu_peminjaman_list_barang_cek_status_kontrak_payment');
    Route::post('menu-peminjaman/list-peminjaman-barang/cek-status-kontrak/payment-fix', [KoperasiController::class, 'menu_peminjaman_list_barang_cek_status_kontrak_payment_fix'])->name('menu_peminjaman_list_barang_cek_status_kontrak_payment_fix');
    Route::post('menu-peminjaman/list-peminjaman-barang/cek-status-kontrak/payment-multi', [KoperasiController::class, 'menu_peminjaman_list_barang_cek_status_kontrak_payment_multi'])->name('menu_peminjaman_list_barang_cek_status_kontrak_payment_multi');

    Route::post('menu-peminjaman/list-peminjaman/proses-pengajuan-peminjaman-uang-baru', [KoperasiController::class, 'menu_peminjaman_list_proses_pengajuan_baru'])->name('menu_peminjaman_list_proses_pengajuan_baru');
    Route::post('menu-peminjaman/list-peminjaman/proses-pengajuan-peminjaman-uang-baru/save', [KoperasiController::class, 'menu_peminjaman_list_proses_pengajuan_baru_save'])->name('menu_peminjaman_list_proses_pengajuan_baru_save');

    Route::post('menu-koperasi/arisan-koperasi/add-group', [KoperasiController::class, 'menu_koperasi_arisan_add_group'])->name('menu_koperasi_arisan_add_group');
    Route::post('menu-koperasi/arisan-koperasi/save-group', [KoperasiController::class, 'menu_koperasi_arisan_save_group'])->name('menu_koperasi_arisan_save_group');
    Route::post('menu-koperasi/arisan-koperasi/add-group-peserta', [KoperasiController::class, 'menu_koperasi_arisan_add_group_peserta'])->name('menu_koperasi_arisan_add_group_peserta');
    Route::post('menu-koperasi/arisan-koperasi/save-group-peserta', [KoperasiController::class, 'menu_koperasi_arisan_save_group_peserta'])->name('menu_koperasi_arisan_save_group_peserta');
    Route::post('menu-koperasi/arisan-koperasi/generate-proses-arisan', [KoperasiController::class, 'menu_koperasi_arisan_generate_proses_arisan'])->name('menu_koperasi_arisan_generate_proses_arisan');
    Route::post('menu-koperasi/arisan-koperasi/periode-group-arisan', [KoperasiController::class, 'menu_koperasi_arisan_periode_group_arisan'])->name('menu_koperasi_arisan_periode_group_arisan');
    Route::post('menu-koperasi/arisan-koperasi/periode-group-arisan/create-token', [KoperasiController::class, 'menu_koperasi_arisan_periode_group_arisan_create_token'])->name('menu_koperasi_arisan_periode_group_arisan_create_token');
    Route::post('menu-koperasi/arisan-koperasi/proses-group-arisan', [KoperasiController::class, 'menu_koperasi_arisan_proses_group_arisan'])->name('menu_koperasi_arisan_proses_group_arisan');
    Route::post('menu-koperasi/arisan-koperasi/proses-group-arisan/spin', [KoperasiController::class, 'menu_koperasi_arisan_proses_group_arisan_spin'])->name('menu_koperasi_arisan_proses_group_arisan_spin');

    Route::post('menu-koperasi/setup-arisan/master-arisan-save', [KoperasiController::class, 'menu_koperasi_setup_arisan_save_master_arisan'])->name('menu_koperasi_setup_arisan_save_master_arisan');
    Route::get('menu-koperasi/setup-arisan/get-data', [KoperasiController::class, 'menu_koperasi_setup_arisan_get_data'])->name('menu_koperasi_setup_arisan_get_data');
    Route::get('menu-koperasi/setup-arisan/peserta-by-cabang/{cabang}', [KoperasiController::class, 'menu_koperasi_setup_arisan_get_peserta'])->name('menu_koperasi_setup_arisan_get_peserta');
    Route::get('menu-koperasi/setup-arisan/jadwal', [KoperasiController::class, 'menu_koperasi_setup_arisan_get_jadwal'])->name('menu_koperasi_setup_arisan_get_jadwal');
    Route::post('menu-koperasi/setup-arisan/jadwal/store', [KoperasiController::class, 'menu_koperasi_setup_arisan_get_jadwal_store'])->name('menu_koperasi_setup_arisan_get_jadwal_store');
    Route::delete('menu-koperasi/setup-arisan/jadwal/delete/{id}', [KoperasiController::class, 'menu_koperasi_setup_arisan_get_jadwal_delete'])->name('menu_koperasi_setup_arisan_get_jadwal_delete');

    Route::get('menu-koperasi/penagihan-arisan/get-data', [KoperasiController::class, 'menu_koperasi_penagihan_arisan_get_data'])->name('menu_koperasi_penagihan_arisan_get_data');
    Route::get('menu-koperasi/penagihan-arisan/get-laporan', [KoperasiController::class, 'menu_koperasi_penagihan_arisan_get_laporan'])->name('menu_koperasi_penagihan_arisan_get_laporan');
    Route::post('menu-koperasi/penagihan-arisan/payment', [KoperasiController::class, 'menu_koperasi_penagihan_arisan_payment'])->name('menu_koperasi_penagihan_arisan_payment');

    Route::get('menu-koperasi/pencairan-arisan/get-data', [KoperasiController::class, 'menu_koperasi_pencairan_arisan_get_data'])->name('menu_koperasi_pencairan_arisan_get_data');
    Route::get('menu-koperasi/pencairan-arisan/cek-pemenang', [KoperasiController::class, 'menu_koperasi_pencairan_arisan_cek_pemenang'])->name('menu_koperasi_pencairan_arisan_cek_pemenang');
    Route::post('menu-koperasi/pencairan-arisan/proses', [KoperasiController::class, 'menu_koperasi_pencairan_arisan_proses'])->name('menu_koperasi_pencairan_arisan_proses');

    Route::post('menu-koperasi/voucher-koperasi/store', [KoperasiController::class, 'menu_koperasi_vocher_store'])->name('menu_koperasi_vocher_store');
    Route::post('menu-koperasi/voucher-koperasi/add-data', [KoperasiController::class, 'menu_koperasi_vocher_add'])->name('menu_koperasi_vocher_add');
    Route::post('menu-koperasi/voucher-koperasi/save-data', [KoperasiController::class, 'menu_koperasi_vocher_save'])->name('menu_koperasi_vocher_save');
    Route::post('menu-koperasi/voucher-koperasi/proses-data-vocher', [KoperasiController::class, 'menu_koperasi_vocher_proses'])->name('menu_koperasi_vocher_proses');
    Route::post('menu-koperasi/voucher-koperasi/proses-data-vocher/send-token', [KoperasiController::class, 'menu_koperasi_vocher_proses_send_token'])->name('menu_koperasi_vocher_proses_send_token');
    Route::post('menu-koperasi/voucher-koperasi/proses-data-vocher/save-data', [KoperasiController::class, 'menu_koperasi_vocher_proses_save'])->name('menu_koperasi_vocher_proses_save');
    Route::post('menu-koperasi/voucher-koperasi/pelunasan-data-vocher', [KoperasiController::class, 'menu_koperasi_vocher_pelunasan'])->name('menu_koperasi_vocher_pelunasan');
    Route::post('menu-koperasi/voucher-koperasi/pelunasan-data-vocher/payment', [KoperasiController::class, 'menu_koperasi_vocher_pelunasan_payment'])->name('menu_koperasi_vocher_pelunasan_payment');

    Route::post('menu-koperasi/iuran-koperasi/add-data', [KoperasiController::class, 'menu_koperasi_iuran_add'])->name('menu_koperasi_iuran_add');
    Route::post('menu-koperasi/iuran-koperasi/save-data', [KoperasiController::class, 'menu_koperasi_iuran_save'])->name('menu_koperasi_iuran_save');
    Route::post('menu-koperasi/iuran-koperasi/proses-data', [KoperasiController::class, 'menu_koperasi_iuran_proses'])->name('menu_koperasi_iuran_proses');
    Route::post('menu-koperasi/iuran-koperasi/proses-create-data', [KoperasiController::class, 'menu_koperasi_iuran_proses_create'])->name('menu_koperasi_iuran_proses_create');
    Route::post('menu-koperasi/iuran-koperasi/proses-data-peserta', [KoperasiController::class, 'menu_koperasi_iuran_proses_peserta'])->name('menu_koperasi_iuran_proses_peserta');
    Route::post('menu-koperasi/iuran-koperasi/proses-data-peserta/payment', [KoperasiController::class, 'menu_koperasi_iuran_proses_peserta_payment'])->name('menu_koperasi_iuran_proses_peserta_payment');

    Route::post('menu-koperasi/simpanan-sukarela/add-data', [KoperasiController::class, 'menu_koperasi_sukarela_add'])->name('menu_koperasi_sukarela_add');
    Route::post('menu-koperasi/simpanan-sukarela/save-data', [KoperasiController::class, 'menu_koperasi_sukarela_save'])->name('menu_koperasi_sukarela_save');
    Route::post('menu-koperasi/simpanan-sukarela/proses-data', [KoperasiController::class, 'menu_koperasi_sukarela_proses'])->name('menu_koperasi_sukarela_proses');
    Route::post('menu-koperasi/simpanan-sukarela/proses-save-data', [KoperasiController::class, 'menu_koperasi_sukarela_proses_save'])->name('menu_koperasi_sukarela_proses_save');

    Route::get('menu-koperasi/tagihan-koperasi/load', [KoperasiController::class, 'menu_koperasi_tagihan_koperasi_load'])->name('menu_koperasi_tagihan_koperasi_load');

    Route::get('menu-koperasi/pembelian-barang-koperasi/get-data', [KoperasiController::class, 'menu_koperasi_pembelian_barang_get_data'])->name('menu_koperasi_pembelian_barang_get_data');
    Route::post('menu-koperasi/pembelian-barang-koperasi/save-data', [KoperasiController::class, 'menu_koperasi_pembelian_barang_save'])->name('menu_koperasi_pembelian_barang_save');

    Route::post('menu-koperasi/mutasi-rekening-bank/save', [KoperasiController::class, 'menu_koperasi_mutasi_rekening_bank_save'])->name('menu_koperasi_mutasi_rekening_bank_save');

    Route::post('menu-peminjaman/peminjaman-uang-angdgota/save', [KoperasiController::class, 'menu_koperasi_peminjaman_uang_anggota_save'])->name('menu_koperasi_peminjaman_uang_anggota_save');
    Route::post('menu-peminjaman/peminjaman-uang-angdgota/print', [KoperasiController::class, 'menu_koperasi_peminjaman_uang_anggota_print'])->name('menu_koperasi_peminjaman_uang_anggota_print');

    Route::get('menu-peminjaman/approval-peminjaman-uang-anggota/detail/{id}', [KoperasiController::class, 'menu_koperasi_approval_peminjaman_uang_anggota_detail'])->name('menu_koperasi_approval_peminjaman_uang_anggota_detail');
    Route::post('menu-peminjaman/approval-peminjaman-uang-anggota/approve', [KoperasiController::class, 'menu_koperasi_approval_peminjaman_uang_anggota_approve'])->name('menu_koperasi_approval_peminjaman_uang_anggota_approve');
    Route::post('menu-peminjaman/approval-peminjaman-uang-anggota/reject', [KoperasiController::class, 'menu_koperasi_approval_peminjaman_uang_anggota_reject'])->name('menu_koperasi_approval_peminjaman_uang_anggota_reject');

   Route::get('menu-koperasi/penagihan-peminjaman/get-data/{id}', [KoperasiController::class, 'menu_koperasi_approval_penagihan_peminjaman_uang_anggota_get_data'])->name('menu_koperasi_approval_penagihan_peminjaman_uang_anggota_get_data');
   Route::post('menu-peminjaman/penagihan-peminjaman-uang-anggota/save', [KoperasiController::class, 'menu_koperasi_approval_penagihan_peminjaman_uang_anggota_save'])->name('menu_koperasi_approval_penagihan_peminjaman_uang_anggota_save');

    Route::post('menu-koperasi/pembelian-barang-anggota/save', [KoperasiController::class, 'menu_koperasi_pembelian_barang_anggota_save'])->name('menu_koperasi_pembelian_barang_anggota_save');

    Route::get('menu-koperasi/apporval-pembelian-barang/detail/{id}', [KoperasiController::class, 'menu_koperasi_approval_pembelian_barang_detail'])->name('menu_koperasi_approval_pembelian_barang_detail');
    Route::post('menu-koperasi/apporval-pembelian-barang/approve/{id}', [KoperasiController::class, 'menu_koperasi_approval_pembelian_barang_approve'])->name('menu_koperasi_approval_pembelian_barang_approve');
    Route::post('menu-koperasi/apporval-pembelian-barang/reject/{id}', [KoperasiController::class, 'menu_koperasi_approval_pembelian_barang_reject'])->name('menu_koperasi_approval_pembelian_barang_reject');

    Route::get('menu-koperasi/penagihan-barang-anggota/get-data/{id_pembelian}', [KoperasiController::class, 'menu_koperasi_penagihan_barang_anggota_get_data'])->name('menu_koperasi_penagihan_barang_anggota_get_data');
    Route::post('menu-koperasi/penagihan-barang-anggota/save', [KoperasiController::class, 'menu_koperasi_penagihan_barang_anggota_save'])->name('menu_koperasi_penagihan_barang_anggota_save');

    Route::post('menu-peminjaman/pembelian-vocher-layanan/save', [KoperasiController::class, 'menu_koperasi_pembelian_vocher_layanan_save'])->name('menu_koperasi_pembelian_vocher_layanan_save');
    Route::put('menu-peminjaman/pembelian-vocher-layanan/lunas', [KoperasiController::class, 'menu_koperasi_pembelian_vocher_layanan_lunas'])->name('menu_koperasi_pembelian_vocher_layanan_lunas');
    Route::delete('menu-peminjaman/pembelian-vocher-layanan/delete/{id}', [KoperasiController::class, 'menu_koperasi_pembelian_vocher_layanan_destroy'])->name('menu_koperasi_pembelian_vocher_layanan_destroy');

    Route::get('menu-koperasi/menu-create-product/get-data', [MenuPenjualanController::class, 'menu_koperasi_penjualan_product_koperasi_get_data'])->name('menu_koperasi_penjualan_product_koperasi_get_data');
    Route::post('menu-koperasi/menu-create-product/save-master', [MenuPenjualanController::class, 'menu_koperasi_penjualan_product_koperasi_save_master'])->name('menu_koperasi_penjualan_product_koperasi_save_master');
    Route::post('menu-koperasi/menu-create-product/save-stok', [MenuPenjualanController::class, 'menu_koperasi_penjualan_product_koperasi_save_stok'])->name('menu_koperasi_penjualan_product_koperasi_save_stok');

    Route::post('menu-koperasi/penagihan-belanja-koperasi/tagih', [MenuPenjualanController::class, 'menu_koperasi_penagihan_belanja_koperasi_tagih'])->name('menu_koperasi_penagihan_belanja_koperasi_tagih');
    Route::post('menu-koperasi/penagihan-belanja-koperasi/bayar', [MenuPenjualanController::class, 'menu_koperasi_penagihan_belanja_koperasi_bayar'])->name('menu_koperasi_penagihan_belanja_koperasi_bayar');

    Route::post('laporan-koperasi/laporan-tagihan/find-data', [KoperasiController::class, 'laporan_koperasi_tagihan_find'])->name('laporan_koperasi_tagihan_find');

    Route::post('laporan-koperasi/laporan-mutasi-bank/add-data', [KoperasiController::class, 'laporan_koperasi_mutasi_bank_add'])->name('laporan_koperasi_mutasi_bank_add');
    Route::post('laporan-koperasi/laporan-mutasi-bank/save-data', [KoperasiController::class, 'laporan_koperasi_mutasi_bank_save'])->name('laporan_koperasi_mutasi_bank_save');

    Route::get('laporan-koperasi/laporan-jurnal-umum/get-coa', [KoperasiController::class, 'laporan_koperasi_jurnal_umum_get_coa'])->name('laporan_koperasi_jurnal_umum_get_coa');
    Route::post('laporan-koperasi/laporan-jurnal-umum/save-data', [KoperasiController::class, 'laporan_koperasi_jurnal_umum_save_data'])->name('laporan_koperasi_jurnal_umum_save_data');

    Route::post('master-koperasi/peserta-koperasi/add-peserta', [KoperasiController::class, 'master_koperasi_peserta_add'])->name('master_koperasi_peserta_add');
    Route::post('master-koperasi/peserta-koperasi/save-peserta', [KoperasiController::class, 'master_koperasi_peserta_save'])->name('master_koperasi_peserta_save');
    Route::post('master-koperasi/peserta-koperasi/import-peserta', [KoperasiController::class, 'master_koperasi_peserta_import'])->name('master_koperasi_peserta_import');
    Route::post('master-koperasi/peserta-koperasi/import-peserta-save', [KoperasiController::class, 'master_koperasi_peserta_import_save'])->name('master_koperasi_peserta_import_save');
    Route::post('master-koperasi/peserta-koperasi/update-data-peserta', [KoperasiController::class, 'master_koperasi_peserta_update'])->name('master_koperasi_peserta_update');
    Route::post('master-koperasi/peserta-koperasi/update-data-peserta-save', [KoperasiController::class, 'master_koperasi_peserta_update_save'])->name('master_koperasi_peserta_update_save');

    Route::post('master-koperasi/cabang-koperasi/add-cabang', [KoperasiController::class, 'master_koperasi_cabang_add_cabang'])->name('master_koperasi_cabang_add_cabang');
    Route::post('master-koperasi/cabang-koperasi/save-cabang', [KoperasiController::class, 'master_koperasi_cabang_save_cabang'])->name('master_koperasi_cabang_save_cabang');
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

    Route::post('master-koperasi/data-bank/add-data', [KoperasiController::class, 'master_koperasi_data_bank_add'])->name('master_koperasi_data_bank_add');
    Route::post('master-koperasi/data-bank/save-data', [KoperasiController::class, 'master_koperasi_data_bank_save'])->name('master_koperasi_data_bank_save');

    Route::post('master-koperasi/data-coa/add-level', [KoperasiController::class, 'master_koperasi_data_coa_add_level'])->name('master_koperasi_data_coa_add_level');
    Route::post('master-koperasi/data-coa/save-level', [KoperasiController::class, 'master_koperasi_data_coa_save_level'])->name('master_koperasi_data_coa_save_level');
    Route::post('master-koperasi/data-coa/sinkronisasi', [KoperasiController::class, 'master_koperasi_data_coa_sinskronisasi'])->name('master_koperasi_data_coa_sinskronisasi');
    Route::post('master-koperasi/data-coa/sinkronisasi-proses', [KoperasiController::class, 'master_koperasi_data_coa_sinskronisasi_proses'])->name('master_koperasi_data_coa_sinskronisasi_proses');

    Route::post('master-koperasi/data-coa-setting/setup', [KoperasiController::class, 'master_koperasi_data_coa_setting_setup'])->name('master_koperasi_data_coa_setting_setup');
    Route::post('master-koperasi/data-coa-setting/save', [KoperasiController::class, 'master_koperasi_data_coa_setting_save'])->name('master_koperasi_data_coa_setting_save');
    Route::post('master-koperasi/data-coa-setting/sinkronisasi', [KoperasiController::class, 'master_koperasi_data_coa_setting_sinkronisasi'])->name('master_koperasi_data_coa_setting_sinkronisasi');
    Route::post('master-koperasi/data-coa-setting/sinkronisasi-save', [KoperasiController::class, 'master_koperasi_data_coa_setting_sinkronisasi_save'])->name('master_koperasi_data_coa_setting_sinkronisasi_save');

    // JURNAL
    Route::get('akutansi-koperasi/jurnal-manual/get-peminjaman', [KoperasiController::class, 'akutansi_koperasi_get_peminjaman'])->name('akutansi_koperasi_get_peminjaman');
    Route::post('akutansi-koperasi/jurnal-manual/get-peminjaman/{id}/cairkan', [KoperasiController::class, 'akutansi_koperasi_get_peminjaman_cairkan'])->name('akutansi_koperasi_get_peminjaman_cairkan');
    Route::get('akutansi-koperasi/jurnal-manual/get-peminjaman-barang', [KoperasiController::class, 'akutansi_koperasi_get_peminjaman_barang'])->name('akutansi_koperasi_get_peminjaman_barang');
    Route::post('akutansi-koperasi/jurnal-manual/get-peminjaman-barang/{id}/serahkan', [KoperasiController::class, 'akutansi_koperasi_get_peminjaman_barang_serahkan'])->name('akutansi_koperasi_get_peminjaman_barang_serahkan');

    Route::get('akutansi-koperasi/jurnal-manual/get-vocher', [KoperasiController::class, 'akutansi_koperasi_get_vocher'])->name('akutansi_koperasi_get_vocher');
    Route::post('akutansi-koperasi/jurnal-manual/get-vocher/{id}/cairkan', [KoperasiController::class, 'akutansi_koperasi_get_vocher_cairkan'])->name('akutansi_koperasi_get_vocher_cairkan');
    Route::get('akutansi-koperasi/jurnal-manual/get-arisan', [KoperasiController::class, 'akutansi_koperasi_get_arisan'])->name('akutansi_koperasi_get_arisan');
    Route::post('akutansi-koperasi/jurnal-manual/get-arisan/{id}/cairkan', [KoperasiController::class, 'akutansi_koperasi_get_arisan_cairkan'])->name('akutansi_koperasi_get_arisan_cairkan');
    Route::get('akutansi-koperasi/jurnal-manual/get-tagihan-bulan', [KoperasiController::class, 'akutansi_koperasi_get_tagihan_bulan'])->name('akutansi_koperasi_get_tagihan_bulan');
    Route::post('akutansi-koperasi/jurnal-manual/get-tagihan-bulan/{id}/bayar', [KoperasiController::class, 'akutansi_koperasi_get_tagihan_bulan_cairkan'])->name('akutansi_koperasi_get_tagihan_bulan_cairkan');
    Route::get('akutansi-koperasi/report/jurnal', [KoperasiController::class, 'akutansi_koperasi_report_jurnal'])->name('akutansi_koperasi_report_jurnal');
    Route::get('akutansi-koperasi/report/buku-besar', [KoperasiController::class, 'akutansi_koperasi_report_buku_besar'])->name('akutansi_koperasi_report_buku_besar');
    Route::get('akutansi-koperasi/report/rugi-laba', [KoperasiController::class, 'akutansi_koperasi_report_rugi_laba'])->name('akutansi_koperasi_report_rugi_laba');
    Route::get('akutansi-koperasi/report/neraca', [KoperasiController::class, 'akutansi_koperasi_report_neraca'])->name('akutansi_koperasi_report_neraca');
    Route::get('akutansi-koperasi/report/perubahan-modal', [KoperasiController::class, 'akutansi_koperasi_report_perubahan_modal'])->name('akutansi_koperasi_report_perubahan_modal');
    Route::get('akutansi-koperasi/report/arus-kas', [KoperasiController::class, 'akutansi_koperasi_report_arus_kas'])->name('akutansi_koperasi_report_arus_kas');

    Route::get('akutansi-koperasi/report/jurnal-cabang', [KoperasiController::class, 'akutansi_koperasi_report_jurnal_cabang'])->name('akutansi_koperasi_report_jurnal_cabang');
    Route::get('akutansi-koperasi/report/buku-besar-cabang', [KoperasiController::class, 'akutansi_koperasi_report_buku_besar_cabang'])->name('akutansi_koperasi_report_buku_besar_cabang');
    Route::get('akutansi-koperasi/report/rugi-laba-cabang', [KoperasiController::class, 'akutansi_koperasi_report_rugi_laba_cabang'])->name('akutansi_koperasi_report_rugi_laba_cabang');

    Route::get('laporan-koperasi/laporan-pembagian-shu/get-data', [KoperasiController::class, 'laporan_koperasi_pembagian_shu_get_data'])->name('laporan_koperasi_pembagian_shu_get_data');
    Route::post('laporan-koperasi/laporan-pembagian-shu/cairkan-shu', [KoperasiController::class, 'laporan_koperasi_pembagian_shu_cairkan_shu'])->name('laporan_koperasi_pembagian_shu_cairkan_shu');
});
