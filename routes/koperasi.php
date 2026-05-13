<?php

use App\Http\Controllers\Koperasi\KoperasiController;
use Illuminate\Support\Facades\Route;
// FARMASI
Route::prefix('koperasi/')->group(function (): void {
    Route::post('menu-koperasi/registrasi-peserta/add-data', [KoperasiController::class, 'menu_koperasi_registrasi_peserta_add'])->name('menu_koperasi_registrasi_peserta_add');

    Route::post('menu-peminjaman/peminjaman-uang/cari-data-peserta', [KoperasiController::class, 'menu_peminjaman_uang_cari_peserta'])->name('menu_peminjaman_uang_cari_peserta');
    Route::post('menu-peminjaman/peminjaman-uang/pilih-data-peserta', [KoperasiController::class, 'menu_peminjaman_uang_pilih_peserta'])->name('menu_peminjaman_uang_pilih_peserta');
    Route::post('menu-peminjaman/peminjaman-uang/proses-pengajuan-peminjaman', [KoperasiController::class, 'menu_peminjaman_uang_proses_pengajuan'])->name('menu_peminjaman_uang_proses_pengajuan');

    Route::post('menu-peminjaman/list-peminjaman/proses-pengajuan-peminjaman-uang', [KoperasiController::class, 'menu_peminjaman_list_proses_pengajuan'])->name('menu_peminjaman_list_proses_pengajuan');
    Route::post('menu-peminjaman/list-peminjaman/proses-pengajuan-peminjaman-uang/send-verifikasi', [KoperasiController::class, 'menu_peminjaman_list_proses_pengajuan_send_verif'])->name('menu_peminjaman_list_proses_pengajuan_send_verif');
    Route::post('menu-peminjaman/list-peminjaman/proses-pengajuan-peminjaman-uang/save-verifikasi', [KoperasiController::class, 'menu_peminjaman_list_proses_pengajuan_save_verif'])->name('menu_peminjaman_list_proses_pengajuan_save_verif');
    Route::post('menu-peminjaman/list-peminjaman/cetak-pengajuan-peminjaman-uang', [KoperasiController::class, 'menu_peminjaman_list_cetak_pengajuan'])->name('menu_peminjaman_list_cetak_pengajuan');
    Route::post('menu-peminjaman/list-peminjaman/cetak-pengajuan-peminjaman-uang/report', [KoperasiController::class, 'menu_peminjaman_list_cetak_pengajuan_report'])->name('menu_peminjaman_list_cetak_pengajuan_report');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak'])->name('menu_peminjaman_list_cek_kontrak');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak/payment', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak_payment'])->name('menu_peminjaman_list_cek_kontrak_payment');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak/payment_fix', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak_payment_fix'])->name('menu_peminjaman_list_cek_kontrak_payment_fix');
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak/penyelesaian-kontrak', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak_penyelesaian_kontrak'])->name('menu_peminjaman_list_cek_kontrak_penyelesaian_kontrak');

    Route::post('menu-koperasi/arisan-koperasi/add-group', [KoperasiController::class, 'menu_koperasi_arisan_add_group'])->name('menu_koperasi_arisan_add_group');
    Route::post('menu-koperasi/arisan-koperasi/save-group', [KoperasiController::class, 'menu_koperasi_arisan_save_group'])->name('menu_koperasi_arisan_save_group');
    Route::post('menu-koperasi/arisan-koperasi/add-group-peserta', [KoperasiController::class, 'menu_koperasi_arisan_add_group_peserta'])->name('menu_koperasi_arisan_add_group_peserta');
    Route::post('menu-koperasi/arisan-koperasi/save-group-peserta', [KoperasiController::class, 'menu_koperasi_arisan_save_group_peserta'])->name('menu_koperasi_arisan_save_group_peserta');
    Route::post('menu-koperasi/arisan-koperasi/generate-proses-arisan', [KoperasiController::class, 'menu_koperasi_arisan_generate_proses_arisan'])->name('menu_koperasi_arisan_generate_proses_arisan');
    Route::post('menu-koperasi/arisan-koperasi/periode-group-arisan', [KoperasiController::class, 'menu_koperasi_arisan_periode_group_arisan'])->name('menu_koperasi_arisan_periode_group_arisan');
    Route::post('menu-koperasi/arisan-koperasi/periode-group-arisan/create-token', [KoperasiController::class, 'menu_koperasi_arisan_periode_group_arisan_create_token'])->name('menu_koperasi_arisan_periode_group_arisan_create_token');
    Route::post('menu-koperasi/arisan-koperasi/proses-group-arisan', [KoperasiController::class, 'menu_koperasi_arisan_proses_group_arisan'])->name('menu_koperasi_arisan_proses_group_arisan');
    Route::post('menu-koperasi/arisan-koperasi/proses-group-arisan/spin', [KoperasiController::class, 'menu_koperasi_arisan_proses_group_arisan_spin'])->name('menu_koperasi_arisan_proses_group_arisan_spin');

    Route::post('menu-koperasi/voucher-koperasi/add-data', [KoperasiController::class, 'menu_koperasi_vocher_add'])->name('menu_koperasi_vocher_add');
    Route::post('menu-koperasi/voucher-koperasi/save-data', [KoperasiController::class, 'menu_koperasi_vocher_save'])->name('menu_koperasi_vocher_save');
    Route::post('menu-koperasi/voucher-koperasi/proses-data-vocher', [KoperasiController::class, 'menu_koperasi_vocher_proses'])->name('menu_koperasi_vocher_proses');
    Route::post('menu-koperasi/voucher-koperasi/proses-data-vocher/send-token', [KoperasiController::class, 'menu_koperasi_vocher_proses_send_token'])->name('menu_koperasi_vocher_proses_send_token');
    Route::post('menu-koperasi/voucher-koperasi/proses-data-vocher/save-data', [KoperasiController::class, 'menu_koperasi_vocher_proses_save'])->name('menu_koperasi_vocher_proses_save');

    Route::post('laporan-koperasi/laporan-tagihan/find-data', [KoperasiController::class, 'laporan_koperasi_tagihan_find'])->name('laporan_koperasi_tagihan_find');

    Route::post('master-koperasi/peserta-koperasi/add-peserta', [KoperasiController::class, 'master_koperasi_peserta_add'])->name('master_koperasi_peserta_add');
    Route::post('master-koperasi/peserta-koperasi/save-peserta', [KoperasiController::class, 'master_koperasi_peserta_save'])->name('master_koperasi_peserta_save');

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
});
