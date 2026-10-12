<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\Medic\MasterMedController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\RadiologiController;
use App\Http\Controllers\TatController;
use Illuminate\Support\Facades\Route;

// MEDICA HEALTH
Route::prefix('{akses}/{id}/application')->group(function () {
    Route::get('home', [ApplicationController::class, 'home'])->name('home');
    // PELAYANAN
    Route::get('registrasi-pasien', [PelayananController::class, 'registrasi_pasien'])->name('registrasi_pasien');
    Route::get('registrasi-pasien-v2', [PelayananController::class, 'registrasi_pasien_v2'])->name('registrasi_pasien_v2');
    Route::get('data-registrasi', [PelayananController::class, 'data_registrasi'])->name('data_registrasi');
    Route::get('menu-pelayanan/verifikasi-data-registrasi', [PelayananController::class, 'menu_pelayanan_verifikasi_registrasi'])->name('menu_pelayanan_verifikasi_registrasi');
    Route::get('menu-pelayanan/menu-supervisior', [PelayananController::class, 'menu_pelayanan_supervisior'])->name('menu_pelayanan_supervisior');
    // POLIKLINIK
    Route::get('poliklinik/registrasi-poliklinik', [PoliklinikController::class, 'poliklinik_register_poli'])->name('poliklinik_register_poli');
    Route::get('menu-poliklinik/data-registrasi', [PoliklinikController::class, 'data_registrasi_poli'])->name('data_registrasi_poli');
    Route::get('menu-poliklinik/poliklinik-handling', [PoliklinikController::class, 'data_registrasi_poliklinik_handling'])->name('data_registrasi_poliklinik_handling');
    Route::get('verifikasi-poliklinik/verifikasi-dokter', [PoliklinikController::class, 'verifikasi_poliklinik_dokter'])->name('verifikasi_poliklinik_dokter');
    Route::get('verifikasi-poliklinik/dokumentasi-hasil', [PoliklinikController::class, 'verifikasi_poliklinik_dokumentasi_hasil'])->name('verifikasi_poliklinik_dokumentasi_hasil');
    // LABORATORIUM
    Route::get('menu-laboratorium/data-registrasi', [LaboratoriumController::class, 'data_registrasi_lab'])->name('data_registrasi_lab');
    Route::get('menu-laboratorium/specimen-collection', [LaboratoriumController::class, 'data_specimen_collection_lab'])->name('data_specimen_collection_lab');
    Route::get('menu-laboratorium/proses-result', [LaboratoriumController::class, 'menu_lab_proses_result'])->name('menu_lab_proses_result');
    Route::get('hasil-lab/verifikasi-hasil', [LaboratoriumController::class, 'verifikasi_laboratorium'])->name('verifikasi_laboratorium');
    Route::get('hasil-lab/dokumentasi-hasil', [LaboratoriumController::class, 'dokumentasi_hasil_laboratorium'])->name('dokumentasi_hasil_laboratorium');
    Route::get('hasil-lab/pengiriman-hasil', [LaboratoriumController::class, 'pengiriman_hasil_laboratorium'])->name('pengiriman_hasil_laboratorium');
    Route::get('pendaftaran-lab/registrasi', [LaboratoriumController::class, 'pendaftaran_lab_registrasi'])->name('pendaftaran_lab_registrasi');
    Route::get('interface-lab/data-result', [LaboratoriumController::class, 'interfave_lab_data_result'])->name('interfave_lab_data_result');
    // RADIOLOGI
    Route::get('menu-radiologi/data-registrasi-radiologi', [RadiologiController::class, 'data_registrasi_radiologi'])->name('data_registrasi_radiologi');
    Route::get('menu-radiologi/radiologi-handling', [RadiologiController::class, 'menu_radiologi_handling'])->name('menu_radiologi_handling');
    Route::get('hasil-radiologi/verifikasi-hasil', [RadiologiController::class, 'hasil_radiologi_verifikasi'])->name('hasil_radiologi_verifikasi');
    Route::get('hasil-radiologi/dokumntasi-hasil', [RadiologiController::class, 'hasil_radiologi_dokumnatasi'])->name('hasil_radiologi_dokumnatasi');
    Route::get('hasil-radiologi/pengiriman-hasil', [RadiologiController::class, 'hasil_radiologi_pengiriman'])->name('hasil_radiologi_pengiriman');
    Route::get('pacs-server/studies-list', [RadiologiController::class, 'pacs_server_studies_list'])->name('pacs_server_studies_list');
    // KEUANGAN
    Route::get('keuangan/menu-kasir', [KeuanganController::class, 'keuangan_menu_cashier'])->name('keuangan_menu_cashier');
    Route::get('transaksi-keuangan/penerimaan-transaksi', [KeuanganController::class, 'keuangan_penerimaan_transaksi'])->name('keuangan_penerimaan_transaksi');

    Route::get('master-company', [ApplicationController::class, 'master_company'])->name('master_company');
    Route::get('mou-company', [ApplicationController::class, 'mou_company'])->name('mou_company');
    Route::get('agreement-perusahaan', [ApplicationController::class, 'agreement_perusahaan'])->name('agreement_perusahaan');

    Route::get('master-pemeriksaan', [ApplicationController::class, 'master_pemeriksaan'])->name('master_pemeriksaan');
    Route::get('master-access-mou', [ApplicationController::class, 'master_access_mou'])->name('master_access_mou');
    Route::get('master-doctor/data-doctor', [MasterDataController::class, 'master_doctor_data_doctor'])->name('master_doctor_data_doctor');
    Route::get('master-doctor/doctor-poliklinik', [MasterDataController::class, 'master_doctor_poliklinik'])->name('master_doctor_poliklinik');
    Route::get('master-doctor/jadwal-dokter-poli', [MasterDataController::class, 'master_jadwal_doctor_poliklinik'])->name('master_jadwal_doctor_poliklinik');
    Route::get('master-pemeriksaan/category-pemeriksaan', [MasterDataController::class, 'master_pemeriksaan_category'])->name('master_pemeriksaan_category');
    Route::get('master-pemeriksaan/data-pemeriksaan', [MasterDataController::class, 'master_pemeriksaan_data'])->name('master_pemeriksaan_data');
    Route::get('master-pemeriksaan/group-pemeriksaan', [MasterDataController::class, 'master_pemeriksaan_group'])->name('master_pemeriksaan_group');
    Route::get('master-pemeriksaan/harga-pemeriksaan', [MasterDataController::class, 'master_pemeriksaan_harga'])->name('master_pemeriksaan_harga');
    Route::get('master-pemeriksaan/specimen-pemeriksaan', [MasterDataController::class, 'master_pemeriksaan_specimen'])->name('master_pemeriksaan_specimen');

    // MASTER MEDIK PASIEN
    Route::get('master-data-patient', [MasterMedController::class, 'master_data_patient'])->name('master_data_patient');
    Route::get('master-member-patient', [MasterMedController::class, 'master_member_patient'])->name('master_member_patient');

    Route::get('master-medical/interface-architec', [MasterMedController::class, 'master_medical_interface_architec'])->name('master_medical_interface_architec');
    Route::get('master-medical/xn-500', [MasterMedController::class, 'master_medical_interface_xn_500'])->name('master_medical_interface_xn_500');

    Route::get('master-medical/update-tat', [MasterMedController::class, 'master_medical_update_tat'])->name('master_medical_update_tat');

    Route::get('master-perusahaan/data-perusahaan', [MasterDataController::class, 'master_perusahaan_data'])->name('master_perusahaan_data');
    Route::get('master-perusahaan/mou-perusahaan', [MasterDataController::class, 'master_perusahaan_mou'])->name('master_perusahaan_mou');
    Route::get('master-perusahaan/agreement-perusahaan', [MasterDataController::class, 'master_perusahaan_agreement'])->name('master_perusahaan_agreement');
    Route::get('master-layanan/category-layanan', [MasterDataController::class, 'master_layanan_category'])->name('master_layanan_category');
    Route::get('master-layanan/data-layanan', [MasterDataController::class, 'master_layanan_data'])->name('master_layanan_data');
    Route::get('master-layanan/formulir-layanan', [MasterDataController::class, 'master_layanan_formulir'])->name('master_layanan_formulir');
    // MASTER PENJUALAN
    Route::get('master-penjualan/data-penjualan', [MasterDataController::class, 'master_penjualan_data'])->name('master_penjualan_data');
    Route::get('master-penjualan/kategori-penjualan', [MasterDataController::class, 'master_penjualan_kategori'])->name('master_penjualan_kategori');
});
// MENU PELAYANAN
Route::prefix('application')->group(function () {
    // PENDAFTARAAN SATU PINTU
    Route::post('registrasi-pasien/add', [PelayananController::class, 'registrasi_pasien_add'])->name('registrasi_pasien_add');
    Route::post('registrasi-pasien/reader-passport-pasien', [PelayananController::class, 'registrasi_pasien_reader_passport'])->name('registrasi_pasien_reader_passport');
    Route::post('registrasi-pasien/reader-passport-pasien/scan', [PelayananController::class, 'registrasi_pasien_reader_passport_scan'])->name('registrasi_pasien_reader_passport_scan');
    Route::post('registrasi-pasien/create-pasien', [PelayananController::class, 'registrasi_pasien_create'])->name('registrasi_pasien_create');
    Route::post('registrasi-pasien/create-pasien-pilih-provinsi', [PelayananController::class, 'registrasi_pasien_create_pilih_provinsi'])->name('registrasi_pasien_create_pilih_provinsi');
    Route::post('registrasi-pasien/create-pasien/save', [PelayananController::class, 'registrasi_pasien_create_save'])->name('registrasi_pasien_create_save');
    Route::post('registrasi-pasien/cari-data-pasien', [PelayananController::class, 'registrasi_pasien_cari_data_pasien'])->name('registrasi_pasien_cari_data_pasien');
    Route::post('registrasi-pasien/pilih-data-pasien', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien'])->name('registrasi_pasien_pilih_data_pasien');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-layanan', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_layanan'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_layanan');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/upload-file', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_upload_file'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_upload_file');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-laboratorium', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-laboratorium/pilih-agrement', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_agrement'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_agrement');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-laboratorium/pilih-type-agrement', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_type_agrement'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_type_agrement');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-laboratorium/pilih-pemeriksaan', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_pemeriksaan'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_pemeriksaan');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-laboratorium/remove-pemeriksaan-lab', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_remove_pemeriksaan_lab'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_remove_pemeriksaan_lab');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli/get-doctor-poli', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_get_dokter_poli'])->name('registrasi_pasien_pilih_data_pasien_get_dokter_poli');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli/get-doctor-quota', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_get_dokter_quota'])->name('registrasi_pasien_pilih_data_pasien_get_dokter_quota');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli/save-registration', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_storeRegistration'])->name('registrasi_pasien_pilih_data_pasien_storeRegistration');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli/print-ticket', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_print_ticket'])->name('registrasi_pasien_pilih_data_pasien_print_ticket');

    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli/pilih-agrement', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_agrement'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_agrement');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli/pilih-type-agrement', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_type_agrement'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_type_agrement');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli/pilih-pemeriksaan', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_pemeriksaan'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_pemeriksaan');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-poli/remove-pemeriksaan-rad', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_remove_pemeriksaan_rad'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_remove_pemeriksaan_rad');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/pilih-dokter', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_dokter'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_dokter');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/fix-registrasi-poli', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_poli'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_poli');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/fix-registrasi-lab', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_lab'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_lab');
    Route::post('registrasi-pasien/pilih-data-pasien/kebutuhan/fix-registrasi-rad', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_rad'])->name('registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_rad');
    Route::post('registrasi-pasien/pilih-data-pasien/end-proses', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_end_proses'])->name('registrasi_pasien_pilih_data_pasien_end_proses');
    Route::post('registrasi-pasien/pilih-data-pasien/preview-pdf', [PelayananController::class, 'registrasi_pasien_pilih_data_pasien_preview_pdf'])->name('registrasi_pasien_pilih_data_pasien_preview_pdf');
    // ANTRIAN
    Route::post('registrasi-pasien/list-que', [PelayananController::class, 'registrasi_pasien_list_que'])->name('registrasi_pasien_list_que');
    Route::get('registrasi-pasien/proses-registrasi-pasien', [PelayananController::class, 'registrasi_pasien_poses_registrasi_pasien'])->name('registrasi_pasien_poses_registrasi_pasien');
    Route::get('registrasi-pasien/find-data-pasien', [PelayananController::class, 'registrasi_pasien_find_data_pasien'])->name('registrasi_pasien_find_data_pasien');
    Route::get('registrasi-pasien/find-data-pasien-bpjs', [PelayananController::class, 'registrasi_pasien_find_bpjs'])->name('registrasi_pasien_find_bpjs');
    Route::get('registrasi-pasien/get-poli-schedules', [PelayananController::class, 'getPoliSchedules'])->name('registrasi_pasien_get_poli_schedules');

    Route::get('registrasi-pasien/save-data-pasien', [PelayananController::class, 'registrasi_pasien_save_data_pasien'])->name('registrasi_pasien_save_data_pasien');
    // TAMBAHKAN ROUTE BARU INI:
    Route::post('/registrasi-pasien/save-pemeriksaan-layanan', [PelayananController::class, 'savePemeriksaanLayanan'])->name('registrasi_pasien_save_pemeriksaan_layanan');

    Route::post('registrasi-pasien/choose-data-que', [PelayananController::class, 'registrasi_pasien_choose_data_que'])->name('registrasi_pasien_choose_data_que');
    // DATA REGISTRASI
    Route::post('data-registrasi/data-table', [PelayananController::class, 'data_registrasi_data_table'])->name('data_registrasi_data_table');
    Route::post('data-registrasi/history', [PelayananController::class, 'data_registrasi_history'])->name('data_registrasi_history');
    Route::post('data-registrasi/find-date', [PelayananController::class, 'data_registrasi_find_data'])->name('data_registrasi_find_data');
    Route::post('data-registrasi/refresh-data', [PelayananController::class, 'data_registrasi_refresh_data'])->name('data_registrasi_refresh_data');
    // SUPERVISIOR PELAYANAN
    Route::post('menu-pelayanan/menu-supervisior/find', [PelayananController::class, 'menu_pelayanan_supervisior_find'])->name('menu_pelayanan_supervisior_find');
    Route::post('menu-pelayanan/menu-supervisior/detail-pasien', [PelayananController::class, 'menu_pelayanan_supervisior_detail_pasien'])->name('menu_pelayanan_supervisior_detail_pasien');
    // VERIFIKASI PENDAFTARAN
    Route::post('menu-pelayanan/verifikasi-data-registrasi/verifikasi', [PelayananController::class, 'menu_pelayanan_verifikasi_registrasi_data'])->name('menu_pelayanan_verifikasi_registrasi_data');
    Route::post('menu-pelayanan/verifikasi-data-registrasi/verifikasi-detail', [PelayananController::class, 'menu_pelayanan_verifikasi_registrasi_data_detail'])->name('menu_pelayanan_verifikasi_registrasi_data_detail');
    Route::post('menu-pelayanan/verifikasi-data-registrasi/pembatalan-registrasi', [PelayananController::class, 'menu_pelayanan_verifikasi_pembatalan_registrasi'])->name('menu_pelayanan_verifikasi_pembatalan_registrasi');
    Route::post('menu-pelayanan/verifikasi-data-registrasi/verifikasi-save', [PelayananController::class, 'menu_pelayanan_verifikasi_registrasi_data_save'])->name('menu_pelayanan_verifikasi_registrasi_data_save');
});
Route::prefix('tat')->name('master_tat.')->group(function () {
    Route::get('/get-lab', [TatController::class, 'getDataLab'])->name('get_lab');
    Route::get('/get-nonlab', [TatController::class, 'getDataNonLab'])->name('get_nonlab');
    Route::post('/update-lab', [TatController::class, 'updateLab'])->name('update_lab');
    Route::post('/update-nonlab', [TatController::class, 'updateNonLab'])->name('update_nonlab');
});
