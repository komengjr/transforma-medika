<?php

use App\Http\Controllers\Koperasi\KoperasiController;
use Illuminate\Support\Facades\Route;
// FARMASI
Route::prefix('koperasi/')->group(function (): void {
    Route::post('menu-koperasi/registrasi-peserta/add-data', [KoperasiController::class, 'menu_koperasi_registrasi_peserta_add'])->name('menu_koperasi_registrasi_peserta_add');

    Route::post('menu-peminjaman/peminjaman-uang/cari-data-peserta', [KoperasiController::class, 'menu_peminjaman_uang_cari_peserta'])->name('menu_peminjaman_uang_cari_peserta');
    Route::post('menu-peminjaman/peminjaman-uang/pilih-data-peserta', [KoperasiController::class, 'menu_peminjaman_uang_pilih_peserta'])->name('menu_peminjaman_uang_pilih_peserta');
    Route::post('menu-peminjaman/peminjaman-uang/proses-pengajuan-peminjaman', [KoperasiController::class, 'menu_peminjaman_uang_proses_pengajuan'])->name('menu_peminjaman_uang_proses_pengajuan');

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
    Route::post('menu-peminjaman/list-peminjaman/cek-status-kontrak/penyelesaian-kontrak', [KoperasiController::class, 'menu_peminjaman_list_cek_kontrak_penyelesaian_kontrak'])->name('menu_peminjaman_list_cek_kontrak_penyelesaian_kontrak');

    Route::post('menu-peminjaman/list-peminjaman-barang/proses-pengajuan-peminjaman-barang', [KoperasiController::class, 'menu_peminjaman_list_barang_proses_pengajuan'])->name('menu_peminjaman_list_barang_proses_pengajuan');
    Route::post('menu-peminjaman/list-peminjaman-barang/proses-pengajuan-peminjaman-barang/send-verifikasi', [KoperasiController::class, 'menu_peminjaman_list_barang_proses_pengajuan_send'])->name('menu_peminjaman_list_barang_proses_pengajuan_send');
    Route::post('menu-peminjaman/list-peminjaman-barang/proses-pengajuan-peminjaman-barang/save-verifikasi', [KoperasiController::class, 'menu_peminjaman_list_barang_proses_pengajuan_save'])->name('menu_peminjaman_list_barang_proses_pengajuan_save');
    Route::post('menu-peminjaman/list-peminjaman-barang/cek-status-kontrak', [KoperasiController::class, 'menu_peminjaman_list_barang_cek_status_kontrak'])->name('menu_peminjaman_list_barang_cek_status_kontrak');
    Route::post('menu-peminjaman/list-peminjaman-barang/cek-status-kontrak/payment', [KoperasiController::class, 'menu_peminjaman_list_barang_cek_status_kontrak_payment'])->name('menu_peminjaman_list_barang_cek_status_kontrak_payment');
    Route::post('menu-peminjaman/list-peminjaman-barang/cek-status-kontrak/payment-fix', [KoperasiController::class, 'menu_peminjaman_list_barang_cek_status_kontrak_payment_fix'])->name('menu_peminjaman_list_barang_cek_status_kontrak_payment_fix');

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

    Route::post('laporan-koperasi/laporan-tagihan/find-data', [KoperasiController::class, 'laporan_koperasi_tagihan_find'])->name('laporan_koperasi_tagihan_find');

    Route::post('laporan-koperasi/laporan-mutasi-bank/add-data', [KoperasiController::class, 'laporan_koperasi_mutasi_bank_add'])->name('laporan_koperasi_mutasi_bank_add');
    Route::post('laporan-koperasi/laporan-mutasi-bank/save-data', [KoperasiController::class, 'laporan_koperasi_mutasi_bank_save'])->name('laporan_koperasi_mutasi_bank_save');

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
});
