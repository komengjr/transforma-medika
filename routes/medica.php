<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\Medic\IgdController;
use App\Http\Controllers\Medic\LayananMedisController;
use App\Http\Controllers\Medic\MasterMedController;
use App\Http\Controllers\Medic\PasienController;
use App\Http\Controllers\Medic\RanapController;
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
    Route::get('master-poliklinik/master-template', [PoliklinikController::class, 'master_poliklinik_template'])->name('master_poliklinik_template');
    // IGD
    Route::get('menu-igd/daftar-registrasi-igd', [IgdController::class, 'data_registrasi_igd'])->name('data_registrasi_igd');
    Route::get('menu-igd/verifikasi-data-igd', [IgdController::class, 'verifikasi_data_igd'])->name('verifikasi_data_igd');
    Route::get('menu-igd/riwayat-pasien-igd', [IgdController::class, 'riwayat_pasien_igd'])->name('riwayat_pasien_igd');
    // RAWAT INAP
    Route::get('menu-rawat-inap/data-registrasi-rawat-inap', [RanapController::class, 'data_registrasi_ranap'])->name('data_registrasi_ranap');
    Route::get('menu-rawat-inap/verifikasi-pasien-rawat-inap', [RanapController::class, 'verifikasi_pasien_ranap'])->name('verifikasi_pasien_ranap');
    Route::get('menu-rawat-inap/riwayat-pasien-rawat-inap', [RanapController::class, 'riwayat_pasien_ranap'])->name('riwayat_pasien_ranap');
    Route::get('master-rawat-inap/data-kelas-ruangan', [RanapController::class, 'master_ranap_ruangan_kelas'])->name('master_ranap_ruangan_kelas');
    // LABORATORIUM
    Route::get('menu-laboratorium/data-registrasi', [LaboratoriumController::class, 'data_registrasi_lab'])->name('data_registrasi_lab');
    Route::get('menu-laboratorium/specimen-collection', [LaboratoriumController::class, 'data_specimen_collection_lab'])->name('data_specimen_collection_lab');
    Route::get('menu-laboratorium/proses-result', [LaboratoriumController::class, 'menu_lab_proses_result'])->name('menu_lab_proses_result');
    Route::get('hasil-lab/verifikasi-hasil', [LaboratoriumController::class, 'verifikasi_laboratorium'])->name('verifikasi_laboratorium');
    Route::get('hasil-lab/dokumentasi-hasil', [LaboratoriumController::class, 'dokumentasi_hasil_laboratorium'])->name('dokumentasi_hasil_laboratorium');
    Route::get('hasil-lab/pengiriman-hasil', [LaboratoriumController::class, 'pengiriman_hasil_laboratorium'])->name('pengiriman_hasil_laboratorium');
    Route::get('pendaftaran-lab/registrasi', [LaboratoriumController::class, 'pendaftaran_lab_registrasi'])->name('pendaftaran_lab_registrasi');
    Route::get('interface-lab/data-result', [LaboratoriumController::class, 'interfave_lab_data_result'])->name('interfave_lab_data_result');
    Route::get('master-laboratorium/parameter-pemeriksaan', [LaboratoriumController::class, 'master_lab_parameter_pemeriksaan'])->name('master_lab_parameter_pemeriksaan');
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
    // MASTER PENJAMIN
    Route::get('master-penjamin/data-penjamin', [MasterDataController::class, 'master_data_penjamin'])->name('master_data_penjamin');
    Route::get('master-penjamin/tarif-penjamin', [MasterDataController::class, 'master_tarif_penjamin'])->name('master_tarif_penjamin');
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
    // Route::post('menu-pelayanan/menu-supervisior/detail-pasien', [PelayananController::class, 'menu_pelayanan_supervisior_detail_pasien'])->name('menu_pelayanan_supervisior_detail_pasien');
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
Route::prefix('pasien')->group(function () {
    Route::get('/search', [PasienController::class, 'search'])->name('pasien.search');
    Route::post('/store', [PasienController::class, 'store'])->name('pasien.store');
    Route::post('/update/{id}', [PasienController::class, 'update'])->name('pasien.update');
});
Route::get('/pemeriksaan/by-sub-penjamin/{id}', [LayananMedisController::class, 'getPemeriksaanBySubPenjamin']);
// Route Proses Pembayaran dan Cetak Nota
Route::post('/pembayaran/proses-cetak', [LayananMedisController::class, 'prosesDanCetak']);
Route::get('/pembayaran/nota/{id}', [LayananMedisController::class, 'tampilkanNota'])->name('pembayaran.nota');
Route::get('/tarif/get-otomatis', [LayananMedisController::class, 'getTarifOtomatis']);
Route::prefix('application')->group(function () {
    Route::post('menu-laboratorium/data-registrasi-lab/handling', [LaboratoriumController::class, 'data_registrasi_lab_handling'])->name('data_registrasi_lab_handling');
    Route::post('menu-laboratorium/data-registrasi-lab/handling-proses', [LaboratoriumController::class, 'data_registrasi_lab_handling_proses'])->name('data_registrasi_lab_handling_proses');
    Route::post('menu-laboratorium/specimen-collection/detail', [LaboratoriumController::class, 'data_specimen_collection_lab_detail'])->name('data_specimen_collection_lab_detail');
    Route::post('menu-laboratorium/specimen-collection/cari-data', [LaboratoriumController::class, 'data_specimen_collection_lab_cari_data'])->name('data_specimen_collection_lab_cari_data');
    Route::get('menu-laboratorium/specimen-collection/print-barcode', [LaboratoriumController::class, 'data_specimen_collection_lab_print_barcode'])->name('data_specimen_collection_lab_print_barcode');
    Route::post('menu-laboratorium/specimen-collection/print-barcode-proses', [LaboratoriumController::class, 'data_specimen_collection_lab_print_barcode_proses'])->name('data_specimen_collection_lab_print_barcode_proses');
    Route::post('menu-laboratorium/specimen-collection/proses', [LaboratoriumController::class, 'data_specimen_collection_lab_proses'])->name('data_specimen_collection_lab_proses');
    Route::post('menu-laboratorium/specimen-collection/proses-simpan', [LaboratoriumController::class, 'data_specimen_collection_lab_proses_simpan'])->name('data_specimen_collection_lab_proses_simpan');
    Route::post('menu-laboratorium/specimen-collection/proses-fix-simpan', [LaboratoriumController::class, 'data_specimen_collection_lab_proses_simpan_fix'])->name('data_specimen_collection_lab_proses_simpan_fix');
    Route::post('menu-laboratorium/proses-result/detail', [LaboratoriumController::class, 'menu_lab_proses_result_detail'])->name('menu_lab_proses_result_detail');
    Route::post('menu-laboratorium/proses-result/detail/proses-sinkronisasi', [LaboratoriumController::class, 'menu_lab_proses_result_detail_sinkronisasi'])->name('menu_lab_proses_result_detail_sinkronisasi');
    Route::post('menu-laboratorium/proses-result/detail/simpan-sinkronisasi', [LaboratoriumController::class, 'menu_lab_proses_result_simpan_sinkronisasi'])->name('menu_lab_proses_result_simpan_sinkronisasi');
    Route::post('menu-laboratorium/proses-result/detail/proses-save', [LaboratoriumController::class, 'menu_lab_proses_result_detail_proses_save'])->name('menu_lab_proses_result_detail_proses_save');
    Route::post('verifikasi-lab/verifikasi-hasil/detail', [LaboratoriumController::class, 'verifikasi_laboratorium_detail'])->name('verifikasi_laboratorium_detail');
    Route::post('verifikasi-lab/verifikasi-hasil/verifikasi-data', [LaboratoriumController::class, 'verifikasi_laboratorium_verifikasi_data'])->name('verifikasi_laboratorium_verifikasi_data');
    Route::post('verifikasi-lab/verifikasi-hasil/preview-report', [LaboratoriumController::class, 'verifikasi_laboratorium_preview_report'])->name('verifikasi_laboratorium_preview_report');
    Route::post('verifikasi-lab/dokumentasi-hasil/detail', [LaboratoriumController::class, 'dokumentasi_hasil_laboratorium_detail'])->name('dokumentasi_hasil_laboratorium_detail');
    Route::post('verifikasi-lab/dokumentasi-hasil/kirim-hasil', [LaboratoriumController::class, 'dokumentasi_hasil_laboratorium_detail_kirim_hasil'])->name('dokumentasi_hasil_laboratorium_detail_kirim_hasil');
    Route::post('verifikasi-lab/dokumentasi-hasil/batal-kirim-hasil', [LaboratoriumController::class, 'dokumentasi_hasil_laboratorium_detail_batal_kirim_hasil'])->name('dokumentasi_hasil_laboratorium_detail_batal_kirim_hasil');
    Route::post('verifikasi-lab/pengiriman-hasil/add', [LaboratoriumController::class, 'pengiriman_hasil_laboratorium_add'])->name('pengiriman_hasil_laboratorium_add');
    Route::post('verifikasi-lab/pengiriman-hasil/save', [LaboratoriumController::class, 'pengiriman_hasil_laboratorium_save'])->name('pengiriman_hasil_laboratorium_save');
    Route::get('verifikasi-lab/pengiriman-hasil/template', [LaboratoriumController::class, 'pengiriman_hasil_laboratorium_template'])->name('pengiriman_hasil_laboratorium_template');

    Route::get('interface-lab/data-result/data', [LaboratoriumController::class, 'interfave_lab_data_result_get_data'])->name('interfave_lab_data_result_get_data');
    Route::get('interface-lab/data-result/{id}/detail', [LaboratoriumController::class, 'interfave_lab_data_result_show_data_detail'])->name('interfave_lab_data_result_show_data_detail');
    Route::get('interface-lab/data-result/{id}/raw', [LaboratoriumController::class, 'interfave_lab_data_result_show_data_raw'])->name('interfave_lab_data_result_show_data_raw');

    Route::get('/master-lab/get-parameters', [LaboratoriumController::class, 'get_parameters_by_pemeriksaan'])->name('lab.get_parameters');
    Route::post('/master-lab/save-parameter', [LaboratoriumController::class, 'save_parameter'])->name('lab.save_parameter');
    Route::delete('/master-lab/delete-parameter', [LaboratoriumController::class, 'delete_parameter'])->name('lab.delete_parameter');
});
// IGD
Route::prefix('igd')->group(function () {
    Route::get('data-registrasi-table', [IgdController::class, 'data_registrasi_igd_table'])->name('data_registrasi_igd_table');
    // Rute Tambahan untuk Handling IGD
    Route::post('handling-form', [IgdController::class, 'igd_handling_form'])->name('igd.handling.form');
    Route::get('get-sub-penjamin', [IgdController::class, 'getSubPenjaminByPenjamin'])->name('api.get.sub.penjamin');
    Route::get('get-tarif-igd', [IgdController::class, 'getTarifIgdBySubPenjamin'])->name('api.get.tarif.igd');
    Route::post('handling/store', [IgdController::class, 'igd_handling_save'])->name('igd.handling.store');

    Route::get('/medic/igd/verifikasi/datatable', [IgdController::class, 'data_verifikasi_igd_table'])->name('igd.verifikasi.datatable');
    Route::get('/medic/igd/detail-verifikasi', [IgdController::class, 'getDetailVerifikasiIgd'])->name('igd.detail.verifikasi');
    Route::post('/detail/cancel-item', [IgdController::class, 'cancelDetailIgd'])->name('igd.detail.cancel-item');

    Route::get('/medic/igd/riwayat/datatable', [IgdController::class, 'data_riwayat_igd_table'])->name('igd.riwayat.datatable');
});
Route::prefix('poliklinik')->group(function () {
    Route::post('handling/store', [PoliklinikController::class, 'store_handling_medis'])->name('store_handling_medis');
});
// RANAP
Route::prefix('ranap')->group(function () {
    Route::get('/registrasi/table', [RanapController::class, 'data_registrasi_ranap_table'])->name('data_registrasi_ranap_table');
    Route::post('/handling/form', [RanapController::class, 'ranap_handling_form'])->name('ranap.handling.form');
    Route::post('/handling/store', [RanapController::class, 'ranap_handling_store'])->name('ranap.handling.store');
    Route::post('/medic/master/ruangan/store', [RanapController::class, 'storeRuangan'])->name('master.ruangan.store');
    Route::get('/medic/ranap/get-sub-penjamin', [RanapController::class, 'getSubPenjaminByPenjamin'])->name('ranap.get.subpenjamin');
    Route::get('/medic/ranap/get-layanan', [RanapController::class, 'getLayananBySubPenjamin'])->name('ranap.get.layanan');
    Route::get('/medic/ranap/verifikasi/datatable', [RanapController::class, 'data_verifikasi_ranap_table'])->name('ranap.verifikasi.datatable');
    Route::post('/medic/ranap/proses-pulang', [RanapController::class, 'prosesPulangRanap'])->name('ranap.proses.pulang');
    Route::get('/ranap/get-harga-obat', [RanapController::class, 'ranap_get_harga_obat'])->name('ranap.get.harga.obat');
    Route::get('/medic/ranap/riwayat/datatable', [RanapController::class, 'data_riwayat_pasien_ranap_table'])->name('ranap.riwayat.datatable');
    Route::post('/ranap/verify-order', [RanapController::class, 'ranap_verify_order'])->name('ranap.verify.order');
    Route::post('/medic/master/bed/store', [RanapController::class, 'storeBed'])->name('master.bed.store');
    Route::post('/medic/master/bed/update/{id}', [RanapController::class, 'updateBed']);
    Route::delete('/medic/master/bed/delete/{id}', [RanapController::class, 'destroyBed']);
    Route::post('/medic/master/bed/toggle-active/{id}', [RanapController::class, 'toggleActiveBed']);

    Route::get('/ranap/handling/detail', [RanapController::class, 'getDetailHandlingRanap'])->name('ranap.detail.handling');
    Route::post('/ranap/handling/verifikasi-granular', [RanapController::class, 'prosesVerifikasiHandling'])->name('ranap.proses.verifikasi.handling');
    Route::post('/ranap/handling/verify-order-soap', [RanapController::class, 'verifyOrderSoap'])->name('ranap.verify.orders');
});
Route::get('/pelayanan/get-specimen-barcode/{registrasi_id}', [PelayananController::class, 'getSpecimenBarcodeList'])->name('get_specimen_barcode_list');
Route::get('/pelayanan/get-filter-options', [PelayananController::class, 'getFilterOptions'])->name('get_filter_options');
Route::get('/poli/dokter-berjadwal', [LayananMedisController::class, 'getDokterBerjadwal']);
Route::get('/master/doctors-json', [LayananMedisController::class, 'getDoctorsJson']);
Route::get('/igd/dokter-jaga', [LayananMedisController::class, 'getDokterJagaIgd']);
Route::get('/master/edc-list', [LayananMedisController::class, 'getListEdc']);
Route::get('/penjamin/get-utama', [LayananMedisController::class, 'getUtama']);
Route::get('/penjamin/get-sub', [LayananMedisController::class, 'getSub']);
Route::post('/pelayanan/verifikasi/datatable', [PelayananController::class, 'data_verifikasi_registrasi_table'])->name('data_verifikasi_registrasi_table');
// Rute untuk Supervisi / Detail Pasien
Route::post('/pelayanan/supervisior/detail-pasien', [PelayananController::class, 'menu_pelayanan_supervisior_detail_pasien'])->name('menu_pelayanan_supervisior_detail_pasien');
Route::post('/pelayanan/supervisior/update-pasien', [PelayananController::class, 'menu_pelayanan_supervisior_update_pasien'])->name('menu_pelayanan_supervisior_update_pasien');
Route::post('/pelayanan/supervisior/tambah-pemeriksaan', [PelayananController::class, 'menu_pelayanan_supervisior_tambah_pemeriksaan'])->name('menu_pelayanan_supervisior_tambah_pemeriksaan');
Route::post('/pelayanan/supervisior/hapus-pemeriksaan', [PelayananController::class, 'menu_pelayanan_supervisior_hapus_pemeriksaan'])->name('menu_pelayanan_supervisior_hapus_pemeriksaan');
Route::post('/pelayanan/supervisior/void-registrasi', [PelayananController::class, 'menu_pelayanan_supervisior_void_registrasi'])->name('menu_pelayanan_supervisior_void_registrasi');
// LABORATTORIUM
Route::post('/laboratorium/registrasi/datatable', [LaboratoriumController::class, 'data_registrasi_lab_table'])->name('data_registrasi_lab_table');
Route::post('menu-radiologi/registrasi/datatable', [RadiologiController::class, 'data_registrasi_radiologi_table'])->name('data_registrasi_radiologi_table');
Route::post('/menu-radiolog/mulai-handling', [RadiologiController::class, 'mulaiHandling'])->name('radiologi.mulai_handling');
Route::post('/menu-radiolog/selesai-handling', [RadiologiController::class, 'selesaiHandling'])->name('radiologi.selesai_handling');
Route::get('/menu-radiologi/handling/get-data', [App\Http\Controllers\RadiologiController::class, 'getDataRadiologiHandling'])->name('radiologi.get_data_handling');
Route::get('/menu-radiologi/verifikasi/get-data', [App\Http\Controllers\RadiologiController::class, 'getDataVerifikasiRadiologi'])->name('radiologi.get_data_verifikasi');
Route::post('/menu-radiologi/verifikasi/handling-data', [App\Http\Controllers\RadiologiController::class, 'menu_radiologi_verifikasi_handling_pasien'])->name('menu_radiologi_verifikasi_handling_pasien');
Route::post('/menu-radiologi/handling-pasien/simpan-hasil', [App\Http\Controllers\RadiologiController::class, 'simpan_hasil_ekspertise'])->name('menu_radiologi_handling_pasien_simpan_hasil');
Route::post('/menu-radiologi/verifikasi/final', [App\Http\Controllers\RadiologiController::class, 'verifikasi_final'])->name('radiologi.verifikasi_final');
// MENU RADIOLOGI
Route::prefix('application')->group(function () {
    Route::post('menu-radiologi/data-registrasi-radiologi/handling', [RadiologiController::class, 'data_registrasi_radiologi_handling'])->name('data_registrasi_radiologi_handling');
    Route::post('menu-radiologi/data-registrasi-radiologi/handling-pasien', [RadiologiController::class, 'menu_radiologi_handling_pasien'])->name('menu_radiologi_handling_pasien');
    Route::get('menu-radiologi/data-registrasi-radiologi/handling-pasien/print-barcode/{code}', [RadiologiController::class, 'menu_radiologi_handling_pasien_print_barcode'])->name('menu_radiologi_handling_pasien_print_barcode');
    Route::get('menu-radiologi/data-registrasi-radiologi/handling-pasien/images/{code}', [RadiologiController::class, 'menu_radiologi_handling_pasien_image'])->name('menu_radiologi_handling_pasien_image');
    Route::get('menu-radiologi/data-registrasi-radiologi/handling-pasien/render/{instanceId}', [RadiologiController::class, 'menu_radiologi_handling_pasien_rander_image'])->name('menu_radiologi_handling_pasien_rander_image');
    // Route::post('menu-radiologi/data-registrasi-radiologi/handling-pasien/proses-simpan-hasil', [RadiologiController::class, 'menu_radiologi_handling_pasien_simpan_hasil'])->name('menu_radiologi_handling_pasien_simpan_hasil');

    Route::post('hasil-radiologi/verifikasi-hasil/detail', [RadiologiController::class, 'hasil_radiologi_verifikasi_detail'])->name('hasil_radiologi_verifikasi_detail');
    Route::post('hasil-radiologi/verifikasi-hasil/verifikasi-data', [RadiologiController::class, 'hasil_radiologi_verifikasi_data'])->name('hasil_radiologi_verifikasi_data');
    Route::post('hasil-radiologi/verifikasi-hasil/preview-report', [RadiologiController::class, 'verifikasi_radiologi_preview_report'])->name('verifikasi_radiologi_preview_report');
    Route::post('hasil-radiologi/dokumentasi-hasil/detail', [RadiologiController::class, 'dokumentasi_hasil_radiologi_detail'])->name('dokumentasi_hasil_radiologi_detail');
    Route::post('hasil-radiologi/dokumentasi-hasil/kirim-hasil', [RadiologiController::class, 'dokumentasi_hasil_radiologi_detail_kirim_hasil'])->name('dokumentasi_hasil_radiologi_detail_kirim_hasil');
    Route::get('pacs-server/studies-get/{studyId}', [RadiologiController::class, 'pacs_server_studies_show'])->name('pacs_server_studies_show');
});
Route::prefix('master-data')->group(function () {
    Route::get('/master-doctor/get-data', [MasterDataController::class, 'master_doctor_get_data'])->name('master_doctor_get_data');
    Route::get('/get-sub-penjamin/{penjamin_id}', [MasterDataController::class, 'getSubPenjamin']);
    Route::get('/get-penjamin-pemeriksaan-filter', [MasterDataController::class, 'getPenjaminPemeriksaanFilter']);
    Route::post('/penjamin-price-store', [MasterDataController::class, 'storePenjaminPemeriksaan'])->name('penjamin-price.store');
    Route::get('/get-package-items/{master_pemeriksaan_id}', [MasterDataController::class, 'getPackageItems']);
    Route::post('/penjamin-price-save-package-items', [MasterDataController::class, 'savePackageItems'])->name('penjamin-price.save-package-items');
    Route::post('master-penjamin/store-utama', [MasterDataController::class, 'store_penjamin_utama'])->name('master_penjamin_utama_store');
    Route::put('master-penjamin/update-utama/{id}', [MasterDataController::class, 'update_penjamin_utama'])->name('master_penjamin_utama_update');
    Route::delete('master-penjamin/delete-utama/{id}', [MasterDataController::class, 'delete_penjamin_utama'])->name('master_penjamin_utama_delete');
    Route::post('master-penjamin/store-sub', [MasterDataController::class, 'store_sub_penjamin'])->name('sub_penjamin_store');
    Route::put('master-penjamin/update-sub/{id}', [MasterDataController::class, 'update_sub_penjamin'])->name('sub_penjamin_update');
    Route::delete('master-penjamin/delete-sub/{id}', [MasterDataController::class, 'delete_sub_penjamin'])->name('sub_penjamin_delete');
    Route::get('master-penjamin/tarif-penjamin', [MasterDataController::class, 'tarif_penjamin'])->name('master_tarif_penjamin');
    Route::post('master-penjamin/tarif-poli/store', [MasterDataController::class, 'store_tarif_poli'])->name('tarif_poli_store');
    Route::put('master-penjamin/tarif-poli/update/{id}', [MasterDataController::class, 'update_tarif_poli'])->name('tarif_poli_update');
    Route::post('master-penjamin/tarif-rawatinap/store', [MasterDataController::class, 'store_tarif_rawatinap'])->name('tarif_rawatinap_store');
    Route::put('master-penjamin/tarif-rawatinap/update/{id}', [MasterDataController::class, 'update_tarif_rawatinap'])->name('tarif_rawatinap_update');
    Route::post('master-penjamin/tarif-igd/store', [MasterDataController::class, 'store_tarif_igd'])->name('tarif_igd_store');
    Route::put('master-penjamin/tarif-igd/update/{id}', [MasterDataController::class, 'update_tarif_igd'])->name('tarif_igd_update');
});
Route::get('/poliklinik/data-pasien-json', [PoliklinikController::class, 'getDataPasienPoliJson'])->name('poliklinik.data.json');
Route::get('/pelayanan/dokter-berjadwal', [LayananMedisController::class, 'getDokterBerjadwal']);
Route::get('/ruangan/bed-tersedia/{ruangan_id}', [LayananMedisController::class, 'getBedTersedia']);
Route::get('/laporan/belum-dilaporkan', [LayananMedisController::class, 'getBelumDilaporkan'])->middleware('auth');
Route::post('/laporan/simpan-setoran', [LayananMedisController::class, 'storeLaporanKeuangan'])->middleware('auth');
Route::get('/laporan/daftar-nota', [LayananMedisController::class, 'getDaftarNota'])->middleware('auth');
Route::get('/laporan/print-setoran/{no_laporan}', [LayananMedisController::class, 'printSetoran'])->middleware('auth');

// MASTER DATA MEDICAL
Route::prefix('application')->group(function () {
    Route::post('master-doctor/data-doctor/import', [MasterDataController::class, 'master_doctor_data_doctor_import'])->name('master_doctor_data_doctor_import');
    Route::get('master-doctor/data-doctor/download-template', [MasterDataController::class, 'master_doctor_download_template'])->name('master_doctor_download_template');
    Route::post('master-doctor/data-doctor/add', [MasterDataController::class, 'master_doctor_data_doctor_add'])->name('master_doctor_data_doctor_add');
    Route::post('master-doctor/data-doctor/save', [MasterDataController::class, 'master_doctor_data_doctor_save'])->name('master_doctor_data_doctor_save');

    Route::get('master-doctor/doctor-poliklinik/list', [MasterDataController::class, 'master_doctor_poliklinik_list'])->name('master_doctor_poliklinik_list');
    Route::get('master-doctor/doctor-poliklinik/get-doctor', [MasterDataController::class, 'master_doctor_poliklinik_get_doctor'])->name('master_doctor_poliklinik_get_doctor');

    Route::post('master-doctor/doctor-poliklinik/add', [MasterDataController::class, 'master_doctor_poliklinik_add'])->name('master_doctor_poliklinik_add');
    Route::post('master-doctor/doctor-poliklinik/save', [MasterDataController::class, 'master_doctor_poliklinik_save'])->name('master_doctor_poliklinik_save');
    Route::delete('master-doctor/doctor-poliklinik/remove', [MasterDataController::class, 'master_doctor_poliklinik_remove'])->name('master_doctor_poliklinik_remove');
    Route::post('master-doctor/doctor-poliklinik/pilih-dokter', [MasterDataController::class, 'master_doctor_poliklinik_pilih_dokter'])->name('master_doctor_poliklinik_pilih_dokter');
    Route::post('master-doctor/doctor-poliklinik/pilih-dokter-save', [MasterDataController::class, 'master_doctor_poliklinik_pilih_dokter_save'])->name('master_doctor_poliklinik_pilih_dokter_save');
    // JADWAL DOKTER POLI
    Route::get('master-doctor/jadwal-dokter-poli/getSchedules', [MasterDataController::class, 'master_jadwal_doctor_poliklinik_getSchedules'])->name('master_jadwal_doctor_poliklinik_getSchedules');
    Route::get('master-doctor/jadwal-dokter-poli/getDoctorsByPoli', [MasterDataController::class, 'master_jadwal_doctor_poliklinik_getDoctorsByPoli'])->name('master_jadwal_doctor_poliklinik_getDoctorsByPoli');
    Route::post('master-doctor/jadwal-dokter-poli/saveSchedule', [MasterDataController::class, 'master_jadwal_doctor_poliklinik_saveSchedule'])->name('master_jadwal_doctor_poliklinik_saveSchedule');
    Route::delete('master-doctor/jadwal-dokter-poli/remove', [MasterDataController::class, 'master_jadwal_doctor_poliklinik_remove'])->name('master_jadwal_doctor_poliklinik_remove');

    // PEMERIKSAAN
    Route::post('master-pemeriksaan/category-pemeriksaan/add', [MasterDataController::class, 'master_pemeriksaan_category_add'])->name('master_pemeriksaan_category_add');
    Route::post('master-pemeriksaan/category-pemeriksaan/save', [MasterDataController::class, 'master_pemeriksaan_category_save'])->name('master_pemeriksaan_category_save');
    Route::post('master-pemeriksaan/data-pemeriksaan/add', [MasterDataController::class, 'master_pemeriksaan_data_add'])->name('master_pemeriksaan_data_add');
    Route::post('master-pemeriksaan/data-pemeriksaan/save', [MasterDataController::class, 'master_pemeriksaan_data_save'])->name('master_pemeriksaan_data_save');
    Route::get('master-data/pemeriksaan/download-template', [MasterDataController::class, 'master_pemeriksaan_download_template'])->name('master_pemeriksaan_download_template');
    Route::post('master-data/pemeriksaan/import', [MasterDataController::class, 'master_pemeriksaan_import'])->name('master_pemeriksaan_import');
    Route::post('master-pemeriksaan/harga-pemeriksaan/master', [MasterDataController::class, 'master_pemeriksaan_harga_master'])->name('master_pemeriksaan_harga_master');
    Route::post('master-pemeriksaan/harga-pemeriksaan/group', [MasterDataController::class, 'master_pemeriksaan_harga_group'])->name('master_pemeriksaan_harga_group');
    Route::post('master-pemeriksaan/specimen-pemeriksaan/detail', [MasterDataController::class, 'master_pemeriksaan_specimen_detail'])->name('master_pemeriksaan_specimen_detail');
    Route::post('master-pemeriksaan/specimen-pemeriksaan/save', [MasterDataController::class, 'master_pemeriksaan_specimen_save'])->name('master_pemeriksaan_specimen_save');
    // LAYANAN
    Route::post('master-layanan/category-layanan/add', [MasterDataController::class, 'master_layanan_category_add'])->name('master_layanan_category_add');
    Route::post('master-layanan/category-layanan/save', [MasterDataController::class, 'master_layanan_category_save'])->name('master_layanan_category_save');
    Route::post('master-layanan/data-layanan/add', [MasterDataController::class, 'master_layanan_data_add'])->name('master_layanan_data_add');
    Route::post('master-layanan/data-layanan/save', [MasterDataController::class, 'master_layanan_data_save'])->name('master_layanan_data_save');
    Route::post('master-layanan/formulir-layanan/add', [MasterDataController::class, 'master_layanan_formulir_add'])->name('master_layanan_formulir_add');
    Route::post('master-layanan/formulir-layanan/save', [MasterDataController::class, 'master_layanan_formulir_save'])->name('master_layanan_formulir_save');
    Route::post('master-layanan/formulir-layanan/add-field', [MasterDataController::class, 'master_layanan_formulir_add_field'])->name('master_layanan_formulir_add_field');
    Route::post('master-layanan/formulir-layanan/save-field', [MasterDataController::class, 'master_layanan_formulir_save_field'])->name('master_layanan_formulir_save_field');

    // PENJUALAN DATA
    Route::post('master-penjualan/data-penjualan/master', [MasterDataController::class, 'master_penjualan_data_master'])->name('master_penjualan_data_master');
    Route::post('master-penjualan/data-penjualan/group', [MasterDataController::class, 'master_penjualan_data_group'])->name('master_penjualan_data_group');
    Route::post('master-penjualan/data-penjualan/add-data', [MasterDataController::class, 'master_penjualan_data_add'])->name('master_penjualan_data_add');
    Route::post('master-penjualan/data-penjualan/save-data', [MasterDataController::class, 'master_penjualan_data_save'])->name('master_penjualan_data_save');
    Route::post('master-penjualan/data-penjualan/import-data', [MasterDataController::class, 'master_penjualan_data_import'])->name('master_penjualan_data_import');
    Route::post('master-penjualan/data-penjualan/save-import-data', [MasterDataController::class, 'master_penjualan_data_import_save'])->name('master_penjualan_data_import_save');
    // KATEGORI PENJUALAN
    Route::post('master-penjualan/kategori-penjualan/add-kategori', [MasterDataController::class, 'master_penjualan_kategori_add_kategori'])->name('master_penjualan_kategori_add_kategori');
    Route::post('master-penjualan/kategori-penjualan/save-kategori', [MasterDataController::class, 'master_penjualan_kategori_save_kategori'])->name('master_penjualan_kategori_save_kategori');
});

// MENU KEUANGAN
Route::prefix('application')->group(function () {
    Route::post('keuangan/menu-kasir/find-data', [KeuanganController::class, 'keuangan_menu_cashier_find_data'])->name('keuangan_menu_cashier_find_data');
    Route::get('keuangan/menu-kasir/list-all-patient', [KeuanganController::class, 'keuangan_menu_cashier_list_all_patient'])->name('keuangan_menu_cashier_list_all_patient');
    Route::get('keuangan/menu-kasir/find-data-v2', [KeuanganController::class, 'keuangan_menu_cashier_find_data_v2'])->name('keuangan_menu_cashier_find_data_v2');
    Route::post('keuangan/menu-kasir/proses-payment', [KeuanganController::class, 'keuangan_menu_cashier_proses_payment'])->name('keuangan_menu_cashier_proses_payment');
    Route::post('keuangan/menu-kasir/find', [KeuanganController::class, 'keuangan_menu_cashier_find'])->name('keuangan_menu_cashier_find');
    Route::post('keuangan/menu-kasir/fix-payment', [KeuanganController::class, 'keuangan_menu_cashier_find_fix_payment'])->name('keuangan_menu_cashier_find_fix_payment');
    Route::post('transaksi-keuangan/penerimaan-transaksi/proses-transaksi', [KeuanganController::class, 'keuangan_penerimaan_proses_transaksi'])->name('keuangan_penerimaan_proses_transaksi');
    Route::post('/keuangan/penerimaan/get-data', [App\Http\Controllers\KeuanganController::class, 'keuangan_penerimaan_get_data'])->name('keuangan_penerimaan_get_data');
    Route::get('/cashier/download-receipt-pdf/{orderCode}', [KeuanganController::class, 'downloadReceiptPdf'])->name('keuangan_menu_cashier_download_pdf');
    Route::get('/get-belum-dilaporkan-keuangan', [KeuanganController::class, 'getBelumDilaporkanKeuangan'])->name('keuangan.get_belum_dilaporkan_keuangan');
    Route::post('keuangan/store-laporan-keuangan-keuangan', [KeuanganController::class, 'storeLaporanKeuanganKeuangan'])->name('keuangan.store_laporan_keuangan_keuangan');
    Route::post('keuangan/verifikasi-laporan-setoran', [KeuanganController::class, 'verifikasiLaporanSetoran'])->name('keuangan.verifikasi_laporan_setoran');
});
// MENU KEUANGAN
Route::prefix('master')->group(function () {
    Route::post('poliklinik-template/save', [PoliklinikController::class, 'save_poliklinik_template'])->name('save_template_poli');
});
// MENU POLIKLINIK
Route::prefix('application')->group(function () {
    Route::get('poliklinik/registrasi-poliklinik/searchPatient', [PoliklinikController::class, 'poliklinik_register_poli_searchPatient'])->name('poliklinik_register_poli_searchPatient');
    Route::get('poliklinik/registrasi-poliklinik/getAvailableDoctors', [PoliklinikController::class, 'poliklinik_register_poli_getAvailableDoctors'])->name('poliklinik_register_poli_getAvailableDoctors');
    Route::get('poliklinik/registrasi-poliklinik/store', [PoliklinikController::class, 'poliklinik_register_poli_store'])->name('poliklinik_register_poli_store');

    Route::post('menu-poliklinik/data-registrasi/handling', [PoliklinikController::class, 'data_registrasi_poli_handling'])->name('data_registrasi_poli_handling');
    Route::post('menu-poliklinik/data-registrasi/handling-pasien', [PoliklinikController::class, 'data_registrasi_poli_handling_pasien'])->name('data_registrasi_poli_handling_pasien');
    Route::post('menu-poliklinik/poliklinik-handling/detail', [PoliklinikController::class, 'data_registrasi_poliklinik_handling_detail'])->name('data_registrasi_poliklinik_handling_detail');
    Route::post('menu-poliklinik/poliklinik-handling/order-layanan', [PoliklinikController::class, 'data_registrasi_poliklinik_handling_order_layanan'])->name('data_registrasi_poliklinik_handling_order_layanan');
    Route::post('menu-poliklinik/poliklinik-handling/order-layanan/save', [PoliklinikController::class, 'data_registrasi_poliklinik_handling_order_layanan_save'])->name('data_registrasi_poliklinik_handling_order_layanan_save');
    Route::post('menu-poliklinik/poliklinik-handling/order-layanan/rad', [PoliklinikController::class, 'data_registrasi_poliklinik_handling_order_layanan_rad'])->name('data_registrasi_poliklinik_handling_order_layanan_rad');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/save-odontogram', [PoliklinikController::class, 'data_registrasi_poliklinik_save_odontogram'])->name('data_registrasi_poliklinik_save_odontogram');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/reset-odontogram', [PoliklinikController::class, 'data_registrasi_poliklinik_reset_odontogram'])->name('data_registrasi_poliklinik_reset_odontogram');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/save-diagnosa', [PoliklinikController::class, 'data_registrasi_poliklinik_save_diagnosa'])->name('data_registrasi_poliklinik_save_diagnosa');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/save-diagnosa-pasien-poli', [PoliklinikController::class, 'data_registrasi_poliklinik_save_diagnosa_pasien_poli'])->name('data_registrasi_poliklinik_save_diagnosa_pasien_poli');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/data-penunjang', [PoliklinikController::class, 'data_registrasi_poliklinik_data_penunjang'])->name('data_registrasi_poliklinik_data_penunjang');

    Route::post('verifikasi-poliklinik/verifikasi-dokter/detail', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_detail'])->name('verifikasi_poliklinik_dokter_detail');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/verify', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_verify'])->name('verifikasi_poliklinik_dokter_verify');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/pilih-penjualan', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_pilih_penjualan'])->name('verifikasi_poliklinik_dokter_pilih_penjualan');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/pilih-sub-penjualan', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_pilih_sub_penjualan'])->name('verifikasi_poliklinik_dokter_pilih_sub_penjualan');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/pilih-pemeriksaan', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_pilih_pemeriksaan'])->name('verifikasi_poliklinik_dokter_pilih_pemeriksaan');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/remove-pemeriksaan', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_remove_pemeriksaan'])->name('verifikasi_poliklinik_dokter_remove_pemeriksaan');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/save-verify', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_save_verify'])->name('verifikasi_poliklinik_dokter_save_verify');

    Route::post('verifikasi-poliklinik/dokumentasi-hasil/preview', [PoliklinikController::class, 'verifikasi_poliklinik_dokumentasi_hasil_preview'])->name('verifikasi_poliklinik_dokumentasi_hasil_preview');
    Route::post('verifikasi-poliklinik/dokumentasi-hasil/preview-report', [PoliklinikController::class, 'verifikasi_poliklinik_dokumentasi_hasil_preview_report'])->name('verifikasi_poliklinik_dokumentasi_hasil_preview_report');
    Route::post('verifikasi-poliklinik/dokumentasi-hasil/send-report', [PoliklinikController::class, 'verifikasi_poliklinik_dokumentasi_hasil_send_report'])->name('verifikasi_poliklinik_dokumentasi_hasil_send_report');
});
Route::get('/kasir/detail-tagihan/{regId}', [KeuanganController::class, 'getDetailTagihanKasir'])->name('kasir.detail_tagihan');
