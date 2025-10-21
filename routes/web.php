<?php

use App\Http\Controllers\Accounting\AccountingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Brodcast\BrodcastController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\Hrm\HrmController;
use App\Http\Controllers\inventaris\MasterBarangController;
use App\Http\Controllers\inventaris\MasterController as InventarisMasterController;
use App\Http\Controllers\inventaris\PeminjamanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\Logsitik\LogistikController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\Medic\MasterMedController;
use App\Http\Controllers\PacsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\Pembelian\PurchaseController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RadiologiController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\UploadFileController;
// use App\Http\Controllers\inventaris\PeminjamanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('reader', [PelayananController::class, 'reader_pasien']);
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::get('registration', 'registration')->name('register');
    Route::get('confrim_user', 'confrim_user')->name('confrim_user');
    Route::get('register_status', 'register_status')->name('register_status');
    Route::get('forget_password', 'forget_password')->name('forget_password');
    Route::get('logout', 'logout')->name('logout');
    Route::post('post-registration', 'postRegistration')->name('register.post');
    Route::post('post-login', 'postLogin')->name('login.post');
    Route::post('verifikasi-Login', 'verifikasi_Login')->name('verifikasi_Login');
    // Route::get('dashboard', [AuthController::class, 'dashboard']);
});
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'fisrt')->name('/');
    Route::get('/app-hrm', 'app_hrm')->name('public-hrm');
    Route::get('/app-medical', 'app_medical')->name('public-medical');
    Route::get('/app-accounting', 'app_accounting')->name('public-accounting');
    Route::get('/app-inventaris', 'app_inventaris')->name('public-inventaris');
    Route::get('/app-logistik', 'app_logistik')->name('public-logistik');
    Route::get('/app-purchase', 'app_purchase')->name('public-purchase');
    Route::get('/app-supplier', 'app_supplier')->name('public-supplier');
    Route::get('/app-brodcast', 'app_brodcast')->name('public-brodcast');
    Route::get('/app-farmasi', 'app_farmasi')->name('public-farmasi');
    Route::get('/product', 'product')->name('product');
    Route::get('/product/detail/{detail}', 'product_detail')->name('product_detail');
    Route::get('/changelog', 'changelog')->name('changelog');

});

Route::get('log-eror', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
// PUBLIC


Route::prefix('dashboard')->group(function () {
    Route::get('home', [dashboardController::class, 'index'])->name('dashboard.home');
    Route::get('profile', [dashboardController::class, 'profile'])->name('dashboard.profile');
});
// DASHBOARD CEK
Route::prefix('app')->group(function () {
    Route::post('check-menu', [dashboardController::class, 'app_check_menu'])->name('app_check_menu');
});
// CONSOL DASHBOARD
Route::prefix('console/')->group(function (): void {
    Route::get('{id}/dashboard', [dashboardController::class, 'dashboard_all'])->name('dashboard_all');
});

Route::prefix('{akses}/{id}')->group(function (): void {
    // HRM
    Route::get('dashboard/personal-data', [HrmController::class, 'personal_data'])->name('personal_data');
    Route::get('data-kehadiran/absensi', [HrmController::class, 'hrm_data_kehadiran_absensi'])->name('hrm_data_kehadiran_absensi');
    Route::get('data-kehadiran/schedule', [HrmController::class, 'hrm_data_kehadiran_schedule'])->name('hrm_data_kehadiran_schedule');
    Route::get('payroll/slip-gaji', [HrmController::class, 'payroll_slip_gaji'])->name('payroll_slip_gaji');
    Route::get('payroll/slip-thr', [HrmController::class, 'payroll_slip_thr'])->name('payroll_slip_thr');
    Route::get('payroll/slip-ipc', [HrmController::class, 'payroll_slip_ipc'])->name('payroll_slip_ipc');
    Route::get('master-data/data-pegawai', [HrmController::class, 'master_data_pegawai'])->name('master_data_pegawai');
    Route::get('master-data/data-jabatan', [HrmController::class, 'master_data_jabatan'])->name('master_data_jabatan');
    // Route::get('{id}/dashboard', [dashboardController::class, 'dashboard_medica'])->name('dashboard_medica');
    // INVENTARIS
    Route::get('menu-peminjaman/data-peminjaman', [PeminjamanController::class, 'menu_data_peminjaman'])->name('menu_data_peminjaman');
    Route::get('menu-peminjaman/order-peminjaman', [PeminjamanController::class, 'menu_order_peminjaman'])->name('menu_order_peminjaman');
    Route::get('menu-mutasi/data-mutasi', [PeminjamanController::class, 'menu_data_mutasi'])->name('menu_data_mutasi');
    Route::get('menu-mutasi/order-mutasi', [PeminjamanController::class, 'menu_order_mutasi'])->name('menu_order_mutasi');
    Route::get('master-barang', [InventarisMasterController::class, 'master_barang'])->name('master_barang');
    Route::get('master-lokasi', [InventarisMasterController::class, 'master_lokasi'])->name('master_lokasi');
    Route::get('keuangan/penerimaan-nota', [InventarisMasterController::class, 'inventaris_penerimaan_nota'])->name('inventaris_penerimaan_nota');

    // ACCOUNTING
    Route::get('ledger/general-ledger', [AccountingController::class, 'general_ledger'])->name('general_ledger');
    Route::get('ledger/ledger-report', [AccountingController::class, 'ledger_report'])->name('ledger_report');
    Route::get('statement/profit-loss-statement', [AccountingController::class, 'statement_profit_loss'])->name('statement_profit_loss');
    Route::get('statement/balance-sheet', [AccountingController::class, 'statement_balance_sheet'])->name('statement_balance_sheet');
    Route::get('statement/capital-statement', [AccountingController::class, 'statement_capital_statement'])->name('statement_capital_statement');
    Route::get('master-accounting/master-coa', [AccountingController::class, 'master_accounting_coa'])->name('master_accounting_coa');

    // PEMBELIAN
    Route::get('purchasing/purchase-requisition', [PurchaseController::class, 'purchase_req'])->name('purchase_req');
    Route::get('purchasing/purchase-order', [PurchaseController::class, 'purchase_order'])->name('purchase_order');
    Route::get('purchasing/goods-recived-note', [PurchaseController::class, 'goods_recived_note'])->name('goods_recived_note');
    Route::get('purchasing/purchase-invoice', [PurchaseController::class, 'purchase_invoice'])->name('purchase_invoice');
    Route::get('purchasing/cash-purchase', [PurchaseController::class, 'purchase_cash_purchase'])->name('purchase_cash_purchase');

    // SUPPLIER
    Route::get('master-supplier/data-supplier', [SupplierController::class, 'master_data_supplier'])->name('master_data_supplier');

    // LOGISTIK
    Route::get('transaction-product/product-in', [LogistikController::class, 'transaction_product_in'])->name('transaction_product_in');
    Route::get('transaction-product/product-out', [LogistikController::class, 'transaction_product_out'])->name('transaction_product_out');
    Route::get('master-logistik/master-item', [LogistikController::class, 'master_logistik_item'])->name('master_logistik_item');
    Route::get('master-logistik/master-product', [LogistikController::class, 'master_logistik_product'])->name('master_logistik_product');

    // BRODCAST
    Route::get('menu-brodcast/brodcast-whatsapp', [BrodcastController::class, 'menu_brodcast_whatsapp'])->name('menu_brodcast_whatsapp');
    Route::get('menu-brodcast/brodcast-management', [BrodcastController::class, 'menu_brodcast_management'])->name('menu_brodcast_management');
    Route::get('master-brodcast/master-contact', [BrodcastController::class, 'master_brodcast_contact'])->name('master_brodcast_contact');
});
// MEDICA HEALTH
Route::prefix('{akses}/{id}/application')->group(function () {
    Route::get('home', [ApplicationController::class, 'home'])->name('home');
    // PELAYANAN
    Route::get('registrasi-pasien', [PelayananController::class, 'registrasi_pasien'])->name('registrasi_pasien');
    Route::get('data-registrasi', [PelayananController::class, 'data_registrasi'])->name('data_registrasi');
    Route::get('menu-pelayanan/verifikasi-data-registrasi', [PelayananController::class, 'menu_pelayanan_verifikasi_registrasi'])->name('menu_pelayanan_verifikasi_registrasi');
    Route::get('menu-pelayanan/menu-supervisior', [PelayananController::class, 'menu_pelayanan_supervisior'])->name('menu_pelayanan_supervisior');
    // POLIKLINIK
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
    // RADIOLOGI
    Route::get('menu-radiologi/data-registrasi-radiologi', [RadiologiController::class, 'data_registrasi_radiologi'])->name('data_registrasi_radiologi');
    Route::get('menu-radiologi/radiologi-handling', [RadiologiController::class, 'menu_radiologi_handling'])->name('menu_radiologi_handling');
    Route::get('hasil-radiologi/verifikasi-hasil', [RadiologiController::class, 'hasil_radiologi_verifikasi'])->name('hasil_radiologi_verifikasi');
    Route::get('hasil-radiologi/dokumntasi-hasil', [RadiologiController::class, 'hasil_radiologi_dokumnatasi'])->name('hasil_radiologi_dokumnatasi');
    Route::get('hasil-radiologi/pengiriman-hasil', [RadiologiController::class, 'hasil_radiologi_pengiriman'])->name('hasil_radiologi_pengiriman');
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


    Route::get('master-perusahaan/data-perusahaan', [MasterDataController::class, 'master_perusahaan_data'])->name('master_perusahaan_data');
    Route::get('master-perusahaan/mou-perusahaan', [MasterDataController::class, 'master_perusahaan_mou'])->name('master_perusahaan_mou');
    Route::get('master-perusahaan/agreement-perusahaan', [MasterDataController::class, 'master_perusahaan_agreement'])->name('master_perusahaan_agreement');
    Route::get('master-layanan/category-layanan', [MasterDataController::class, 'master_layanan_category'])->name('master_layanan_category');
    Route::get('master-layanan/data-layanan', [MasterDataController::class, 'master_layanan_data'])->name('master_layanan_data');
    Route::get('master-layanan/formulir-layanan', [MasterDataController::class, 'master_layanan_formulir'])->name('master_layanan_formulir');
    // MASTER PENJUALAN
    Route::get('master-penjualan/data-penjualan', [MasterDataController::class, 'master_penjualan_data'])->name('master_penjualan_data');
    Route::get('master-penjualan/kategori-penjualan', [MasterDataController::class, 'master_penjualan_kategori'])->name('master_penjualan_kategori');

    // SUPPLIER

});

// MENU REGISTRASI
Route::prefix('application')->group(function () {
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
    // DATA REGISTRASI
    Route::post('data-registrasi/history', [PelayananController::class, 'data_registrasi_history'])->name('data_registrasi_history');
    // SUPERVISIOR PELAYANAN
    Route::post('menu-pelayanan/menu-supervisior/find', [PelayananController::class, 'menu_pelayanan_supervisior_find'])->name('menu_pelayanan_supervisior_find');

});

Route::prefix('master-data')->group(function () {
    Route::get('dashboard', [MasterController::class, 'master_dashboard'])->name('master_dashboard');
    Route::get('cabang', [MasterController::class, 'master_cabang'])->name('master_cabang');
    Route::post('cabang/add', [MasterController::class, 'master_cabang_add'])->name('master_cabang_add');
    Route::post('cabang/save', [MasterController::class, 'master_cabang_save'])->name('master_cabang_save');
    Route::get('user', [MasterController::class, 'master_user'])->name('master_user');
    Route::post('user/add', [MasterController::class, 'master_user_add'])->name('master_user_add');
    Route::post('user/save', [MasterController::class, 'master_user_save'])->name('master_user_save');
    Route::get('coa', [MasterController::class, 'master_coa'])->name('master_coa');
    Route::get('menu', [MasterController::class, 'master_menu'])->name('master_menu');
    Route::get('menu-akses', [MasterController::class, 'master_menu_akses'])->name('master_menu_akses');
    Route::post('menu-akses/add', [MasterController::class, 'master_menu_akses_add'])->name('master_menu_akses_add');
    Route::post('menu-akses/save', [MasterController::class, 'master_menu_akses_save'])->name('master_menu_akses_save');
    Route::post('menu-akses/setup-super-menu', [MasterController::class, 'master_menu_akses_setup_super_menu'])->name('master_menu_akses_setup_super_menu');
    Route::post('menu-akses/update-akses-super-menu', [MasterController::class, 'master_menu_akses_update_akses_super_menu'])->name('master_menu_akses_update_akses_super_menu');
    Route::post('menu-akses/setup-sub-menu', [MasterController::class, 'master_menu_akses_setup_sub_menu'])->name('master_menu_akses_setup_sub_menu');
    Route::post('menu-akses/update-akses-menu', [MasterController::class, 'master_menu_akses_update_menu'])->name('master_menu_akses_update_menu');
    Route::post('menu-akses/update-akses-sub-menu', [MasterController::class, 'master_menu_akses_update_sub_menu'])->name('master_menu_akses_update_sub_menu');
    Route::post('menu/add', [MasterController::class, 'master_menu_add'])->name('master_menu_add');
    Route::post('menu/save', [MasterController::class, 'master_menu_save'])->name('master_menu_save');
    Route::post('menu/update', [MasterController::class, 'master_menu_update'])->name('master_menu_update');
    Route::post('menu/update-save', [MasterController::class, 'master_menu_update_save'])->name('master_menu_update_save');
    Route::post('menu/sub-menu-save', [MasterController::class, 'master_sub_menu_save'])->name('master_sub_menu_save');
    Route::get('menu/gateway-whatsapp', [MasterController::class, 'master_gateway_whatsapp'])->name('master_gateway_whatsapp');
    Route::post('menu/gateway-whatsapp/send-message', [MasterController::class, 'master_gateway_whatsapp_send_message'])->name('master_gateway_whatsapp_send_message');
    Route::post('menu/gateway-whatsapp/send-message-prosess', [MasterController::class, 'master_gateway_whatsapp_send_message_prosess'])->name('master_gateway_whatsapp_send_message_prosess');
});
// MENU POLIKLINIK
Route::prefix('application')->group(function () {
    Route::post('menu-poliklinik/data-registrasi/handling', [PoliklinikController::class, 'data_registrasi_poli_handling'])->name('data_registrasi_poli_handling');
    Route::post('menu-poliklinik/data-registrasi/handling-pasien', [PoliklinikController::class, 'data_registrasi_poli_handling_pasien'])->name('data_registrasi_poli_handling_pasien');
    Route::post('menu-poliklinik/poliklinik-handling/detail', [PoliklinikController::class, 'data_registrasi_poliklinik_handling_detail'])->name('data_registrasi_poliklinik_handling_detail');
    Route::post('menu-poliklinik/poliklinik-handling/order-layanan', [PoliklinikController::class, 'data_registrasi_poliklinik_handling_order_layanan'])->name('data_registrasi_poliklinik_handling_order_layanan');
    Route::post('menu-poliklinik/poliklinik-handling/order-layanan/rad', [PoliklinikController::class, 'data_registrasi_poliklinik_handling_order_layanan_rad'])->name('data_registrasi_poliklinik_handling_order_layanan_rad');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/save-odontogram', [PoliklinikController::class, 'data_registrasi_poliklinik_save_odontogram'])->name('data_registrasi_poliklinik_save_odontogram');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/reset-odontogram', [PoliklinikController::class, 'data_registrasi_poliklinik_reset_odontogram'])->name('data_registrasi_poliklinik_reset_odontogram');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/save-diagnosa', [PoliklinikController::class, 'data_registrasi_poliklinik_save_diagnosa'])->name('data_registrasi_poliklinik_save_diagnosa');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/save-diagnosa-pasien-poli', [PoliklinikController::class, 'data_registrasi_poliklinik_save_diagnosa_pasien_poli'])->name('data_registrasi_poliklinik_save_diagnosa_pasien_poli');
    Route::post('menu-poliklinik/poliklinik-handling/poli-gigi/data-penunjang', [PoliklinikController::class, 'data_registrasi_poliklinik_data_penunjang'])->name('data_registrasi_poliklinik_data_penunjang');

    Route::post('verifikasi-poliklinik/verifikasi-dokter/verify', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_verify'])->name('verifikasi_poliklinik_dokter_verify');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/pilih-penjualan', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_pilih_penjualan'])->name('verifikasi_poliklinik_dokter_pilih_penjualan');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/pilih-sub-penjualan', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_pilih_sub_penjualan'])->name('verifikasi_poliklinik_dokter_pilih_sub_penjualan');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/pilih-pemeriksaan', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_pilih_pemeriksaan'])->name('verifikasi_poliklinik_dokter_pilih_pemeriksaan');
    Route::post('verifikasi-poliklinik/verifikasi-dokter/save-verify', [PoliklinikController::class, 'verifikasi_poliklinik_dokter_save_verify'])->name('verifikasi_poliklinik_dokter_save_verify');

    Route::post('verifikasi-poliklinik/dokumentasi-hasil/preview', [PoliklinikController::class, 'verifikasi_poliklinik_dokumentasi_hasil_preview'])->name('verifikasi_poliklinik_dokumentasi_hasil_preview');
    Route::post('verifikasi-poliklinik/dokumentasi-hasil/preview-report', [PoliklinikController::class, 'verifikasi_poliklinik_dokumentasi_hasil_preview_report'])->name('verifikasi_poliklinik_dokumentasi_hasil_preview_report');
    Route::post('verifikasi-poliklinik/dokumentasi-hasil/send-report', [PoliklinikController::class, 'verifikasi_poliklinik_dokumentasi_hasil_send_report'])->name('verifikasi_poliklinik_dokumentasi_hasil_send_report');
});
// MENU RADIOLOGI
Route::prefix('application')->group(function () {
    Route::post('menu-radiologi/data-registrasi-radiologi/handling', [RadiologiController::class, 'data_registrasi_radiologi_handling'])->name('data_registrasi_radiologi_handling');
    Route::post('menu-radiologi/data-registrasi-radiologi/handling-pasien', [RadiologiController::class, 'menu_radiologi_handling_pasien'])->name('menu_radiologi_handling_pasien');
    Route::post('hasil-radiologi/verifikasi-hasil/detail', [RadiologiController::class, 'hasil_radiologi_verifikasi_detail'])->name('hasil_radiologi_verifikasi_detail');
    Route::post('hasil-radiologi/verifikasi-hasil/verifikasi-data', [RadiologiController::class, 'hasil_radiologi_verifikasi_data'])->name('hasil_radiologi_verifikasi_data');
    Route::post('hasil-radiologi/verifikasi-hasil/preview-report', [RadiologiController::class, 'verifikasi_radiologi_preview_report'])->name('verifikasi_radiologi_preview_report');
    Route::post('hasil-radiologi/dokumentasi-hasil/detail', [RadiologiController::class, 'dokumentasi_hasil_radiologi_detail'])->name('dokumentasi_hasil_radiologi_detail');
    Route::post('hasil-radiologi/dokumentasi-hasil/kirim-hasil', [RadiologiController::class, 'dokumentasi_hasil_radiologi_detail_kirim_hasil'])->name('dokumentasi_hasil_radiologi_detail_kirim_hasil');
});
// MENU LABORATORIUM
Route::prefix('application')->group(function () {
    Route::post('menu-laboratorium/data-registrasi-lab/handling', [LaboratoriumController::class, 'data_registrasi_lab_handling'])->name('data_registrasi_lab_handling');
    Route::post('menu-laboratorium/data-registrasi-lab/handling-proses', [LaboratoriumController::class, 'data_registrasi_lab_handling_proses'])->name('data_registrasi_lab_handling_proses');
    Route::post('menu-laboratorium/specimen-collection/detail', [LaboratoriumController::class, 'data_specimen_collection_lab_detail'])->name('data_specimen_collection_lab_detail');
    Route::post('menu-laboratorium/specimen-collection/cari-data', [LaboratoriumController::class, 'data_specimen_collection_lab_cari_data'])->name('data_specimen_collection_lab_cari_data');
    Route::post('menu-laboratorium/specimen-collection/proses', [LaboratoriumController::class, 'data_specimen_collection_lab_proses'])->name('data_specimen_collection_lab_proses');
    Route::post('menu-laboratorium/specimen-collection/proses-simpan', [LaboratoriumController::class, 'data_specimen_collection_lab_proses_simpan'])->name('data_specimen_collection_lab_proses_simpan');
    Route::post('menu-laboratorium/specimen-collection/proses-fix-simpan', [LaboratoriumController::class, 'data_specimen_collection_lab_proses_simpan_fix'])->name('data_specimen_collection_lab_proses_simpan_fix');
    Route::post('menu-laboratorium/proses-result/detail', [LaboratoriumController::class, 'menu_lab_proses_result_detail'])->name('menu_lab_proses_result_detail');
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
});
// MENU KEUANGAN
Route::prefix('application')->group(function () {
    Route::post('keuangan/menu-kasir/find', [KeuanganController::class, 'keuangan_menu_cashier_find'])->name('keuangan_menu_cashier_find');
    Route::post('keuangan/menu-kasir/fix-payment', [KeuanganController::class, 'keuangan_menu_cashier_find_fix_payment'])->name('keuangan_menu_cashier_find_fix_payment');
    Route::post('transaksi-keuangan/penerimaan-transaksi/proses-transaksi', [KeuanganController::class, 'keuangan_penerimaan_proses_transaksi'])->name('keuangan_penerimaan_proses_transaksi');
});
// MASTER DATA
Route::prefix('application')->group(function () {
    Route::post('master-doctor/data-doctor/add', [MasterDataController::class, 'master_doctor_data_doctor_add'])->name('master_doctor_data_doctor_add');
    Route::post('master-doctor/data-doctor/save', [MasterDataController::class, 'master_doctor_data_doctor_save'])->name('master_doctor_data_doctor_save');
    Route::post('master-doctor/doctor-poliklinik/add', [MasterDataController::class, 'master_doctor_poliklinik_add'])->name('master_doctor_poliklinik_add');
    Route::post('master-doctor/doctor-poliklinik/save', [MasterDataController::class, 'master_doctor_poliklinik_save'])->name('master_doctor_poliklinik_save');
    Route::post('master-doctor/doctor-poliklinik/pilih-dokter', [MasterDataController::class, 'master_doctor_poliklinik_pilih_dokter'])->name('master_doctor_poliklinik_pilih_dokter');
    Route::post('master-doctor/doctor-poliklinik/pilih-dokter-save', [MasterDataController::class, 'master_doctor_poliklinik_pilih_dokter_save'])->name('master_doctor_poliklinik_pilih_dokter_save');
    // PEMERIKSAAN
    Route::post('master-pemeriksaan/category-pemeriksaan/add', [MasterDataController::class, 'master_pemeriksaan_category_add'])->name('master_pemeriksaan_category_add');
    Route::post('master-pemeriksaan/category-pemeriksaan/save', [MasterDataController::class, 'master_pemeriksaan_category_save'])->name('master_pemeriksaan_category_save');
    Route::post('master-pemeriksaan/data-pemeriksaan/add', [MasterDataController::class, 'master_pemeriksaan_data_add'])->name('master_pemeriksaan_data_add');
    Route::post('master-pemeriksaan/data-pemeriksaan/save', [MasterDataController::class, 'master_pemeriksaan_data_save'])->name('master_pemeriksaan_data_save');
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
// MASTER DATA
Route::prefix('application')->group(function () {
    // MASTER COMPANY
    Route::post('master-company/add-company', [ApplicationController::class, 'master_company_add_company'])->name('master_company_add_company');
    Route::post('master-company/add-company/save', [ApplicationController::class, 'master_company_add_company_save'])->name('master_company_add_company_save');
    Route::post('master-company/edit-company', [ApplicationController::class, 'master_company_edit_company'])->name('master_company_edit_company');
    Route::post('master-company/edit-company/save', [ApplicationController::class, 'master_company_edit_company_save'])->name('master_company_edit_company_save');
    Route::post('master-company/data-mou-company', [ApplicationController::class, 'master_company_data_mou_company'])->name('master_company_data_mou_company');

    // MOU COMPANY
    Route::post('mou-company/add', [ApplicationController::class, 'mou_company_add'])->name('mou_company_add');
    Route::post('mou-company/save', [ApplicationController::class, 'mou_company_save'])->name('mou_company_save');
    Route::post('mou-company/peserta-mcu', [ApplicationController::class, 'mou_company_peserta_mcu'])->name('mou_company_peserta_mcu');
    Route::post('mou-company/insert-peserta-mcu', [ApplicationController::class, 'mou_company_insert_peserta_mcu'])->name('mou_company_insert_peserta_mcu');
    Route::post('mou-company/insert-peserta-mcu/manual', [ApplicationController::class, 'mou_company_insert_peserta_mcu_manual'])->name('mou_company_insert_peserta_mcu_manual');
    Route::post('mou-company/insert-peserta-mcu/manual-save', [ApplicationController::class, 'mou_company_insert_peserta_mcu_manual_save'])->name('mou_company_insert_peserta_mcu_manual_save');
    Route::post('mou-company/insert-peserta-mcu/upload', [ApplicationController::class, 'mou_company_insert_peserta_mcu_upload'])->name('mou_company_insert_peserta_mcu_upload');
    Route::post('mou-company/insert-peserta-mcu/upload-save', [ApplicationController::class, 'mou_company_insert_peserta_mcu_upload_save'])->name('mou_company_insert_peserta_mcu_upload_save');
    Route::post('mou-company/insert-peserta-mcu/upload-all', [ApplicationController::class, 'mou_company_insert_all_peserta_mcu_upload'])->name('mou_company_insert_all_peserta_mcu_upload');
    Route::post('mou-company/insert-peserta-mcu/upload-all-save', [ApplicationController::class, 'mou_company_insert_all_peserta_mcu_upload_save'])->name('mou_company_insert_all_peserta_mcu_upload_save');
    Route::post('mou-company/insert-pemeriksaan-mcu', [ApplicationController::class, 'mou_company_insert_pemeriksaan_mcu'])->name('mou_company_insert_pemeriksaan_mcu');
    Route::post('mou-company/insert-pemeriksaan-mcu/insert', [ApplicationController::class, 'mou_company_insert_pemeriksaan_mcu_insert'])->name('mou_company_insert_pemeriksaan_mcu_insert');
    Route::post('mou-company/activasi-mou', [ApplicationController::class, 'mou_company_activasi_mou'])->name('mou_company_activasi_mou');
    Route::post('mou-company/activasi-mou/save', [ApplicationController::class, 'mou_company_activasi_mou_save'])->name('mou_company_activasi_mou_save');

    // AGREMENT
    Route::post('agreement-perusahaan/add', [ApplicationController::class, 'agreement_perusahaan_add'])->name('agreement_perusahaan_add');
    Route::post('agreement-perusahaan/save', [ApplicationController::class, 'agreement_perusahaan_save'])->name('agreement_perusahaan_save');
    Route::post('agreement-perusahaan/update-save', [ApplicationController::class, 'agreement_perusahaan_update_save'])->name('agreement_perusahaan_update_save');
    Route::post('agreement-perusahaan/update', [ApplicationController::class, 'agreement_perusahaan_update'])->name('agreement_perusahaan_update');
    Route::post('agreement-perusahaan/add-pemeriksaan', [ApplicationController::class, 'agreement_perusahaan_add_pemeriksaan'])->name('agreement_perusahaan_add_pemeriksaan');
    Route::post('agreement-perusahaan/save-pemeriksaan', [ApplicationController::class, 'agreement_perusahaan_save_pemeriksaan'])->name('agreement_perusahaan_save_pemeriksaan');
    Route::post('agreement-perusahaan/remove-pemeriksaan', [ApplicationController::class, 'agreement_perusahaan_remove_pemeriksaan'])->name('agreement_perusahaan_remove_pemeriksaan');
    Route::post('agreement-perusahaan/remove-agreement', [ApplicationController::class, 'agreement_perusahaan_remove_agreement'])->name('agreement_perusahaan_remove_agreement');

    // PEMERIKSAAN
    Route::post('master-pemeriksaan/add', [ApplicationController::class, 'master_pemeriksaan_add'])->name('master_pemeriksaan_add');
    Route::post('master-pemeriksaan/save', [ApplicationController::class, 'master_pemeriksaan_save'])->name('master_pemeriksaan_save');
    Route::post('master-pemeriksaan/update', [ApplicationController::class, 'master_pemeriksaan_update'])->name('master_pemeriksaan_update');
    Route::post('master-pemeriksaan/update-save', [ApplicationController::class, 'master_pemeriksaan_update_save'])->name('master_pemeriksaan_update_save');

    // KATEGORI PEMERIKSAAN
    Route::post('master-pemeriksaan/group-pemeriksaan/layanan', [MasterDataController::class, 'master_pemeriksaan_group_layanan'])->name('master_pemeriksaan_group_layanan');
    Route::post('master-pemeriksaan/group-pemeriksaan/pilih-pemeriksaan', [MasterDataController::class, 'master_pemeriksaan_group_pilih_pemeriksaan'])->name('master_pemeriksaan_group_pilih_pemeriksaan');
    Route::post('master-pemeriksaan/group-pemeriksaan/add-pemeriksaan', [MasterDataController::class, 'master_pemeriksaan_group_add_pemeriksaan'])->name('master_pemeriksaan_group_add_pemeriksaan');
    Route::post('master-pemeriksaan/group-pemeriksaan/add-pemeriksaan/save', [MasterDataController::class, 'master_pemeriksaan_group_add_pemeriksaan_save'])->name('master_pemeriksaan_group_add_pemeriksaan_save');
    Route::post('master-pemeriksaan/group-pemeriksaan/add-value-pemeriksaan', [MasterDataController::class, 'master_pemeriksaan_group_add_value_pemeriksaan'])->name('master_pemeriksaan_group_add_value_pemeriksaan');
    Route::post('master-pemeriksaan/group-pemeriksaan/add-value-pemeriksaan/save', [MasterDataController::class, 'master_pemeriksaan_group_add_value_pemeriksaan_save'])->name('master_pemeriksaan_group_add_value_pemeriksaan_save');
});

Route::post('file-upload/upload-file-profile', [UploadFileController::class, 'upload_profile'])->name('file-upload.data-profile');

Route::get('test', function () {
    $data = file_get_contents('file://192.168.61.228/pacslis/20211006/022G8N88PA-CR-01.jpg');
    return 'data:image/' . 'jpg' . ';base64,' . base64_encode($data);
    // dd(Storage::disk('c-drive/public'));
});
Route::get('scan', [App\Http\Controllers\OcrController::class, 'scan_passport']);


// INVENTARIS
Route::prefix('inventaris/')->group(function (): void {
    Route::post('master-barang/add-barang', [InventarisMasterController::class, 'master_barang_add'])->name('master_barang_add');
    Route::post('master-barang/add-barang/upload-gambar', [InventarisMasterController::class, 'master_barang_add_upload_gambar'])->name('master_barang_add_upload_gambar');
    Route::post('master-barang/add-barang/save', [InventarisMasterController::class, 'master_barang_add_save_data'])->name('master_barang_add_save_data');
    Route::get('master-barang/show-data', [InventarisMasterController::class, 'master_barang_show_data'])->name('master_barang_show_data');
    Route::post('keuangan/penerimaan-nota/add', [InventarisMasterController::class, 'inventaris_penerimaan_nota_add'])->name('inventaris_penerimaan_nota_add');
    Route::post('keuangan/penerimaan-nota/add-barang', [InventarisMasterController::class, 'inventaris_penerimaan_nota_add_barang'])->name('inventaris_penerimaan_nota_add_barang');
    Route::post('keuangan/penerimaan-nota/save', [InventarisMasterController::class, 'inventaris_penerimaan_nota_save'])->name('inventaris_penerimaan_nota_save');
});

// ACCOUNTING
Route::prefix('accounting/')->group(function (): void {
    Route::post('ledger/general-ledger/search', [AccountingController::class, 'general_ledger_search'])->name('general_ledger_search');

    Route::post('master-accounting/master-coa/add-level', [AccountingController::class, 'master_accounting_coa_add_level'])->name('master_accounting_coa_add_level');
    Route::post('master-accounting/master-coa/save-level', [AccountingController::class, 'master_accounting_coa_save_level'])->name('master_accounting_coa_save_level');
    Route::post('master-accounting/master-coa/update-level', [AccountingController::class, 'master_accounting_coa_update_level'])->name('master_accounting_coa_update_level');
    Route::post('master-accounting/master-coa/update-save-level', [AccountingController::class, 'master_accounting_coa_update_save_level'])->name('master_accounting_coa_update_save_level');
});

// HUMAN RESOURCE
Route::prefix('hrm/')->group(function (): void {
    Route::post('data-kehadiran/absensi/search', [HrmController::class, 'data_kehadiran_search'])->name('data_kehadiran_search');

    Route::post('master-data/data-pegawai/add', [HrmController::class, 'master_data_pegawai_add'])->name('master_data_pegawai_add');
    Route::post('master-data/data-pegawai/save', [HrmController::class, 'master_data_pegawai_save'])->name('master_data_pegawai_save');
});

// PEMBELIAN
Route::prefix('pembelian/')->group(function (): void {
    Route::post('purchasing/purchase-requisition/add', [PurchaseController::class, 'purchase_req_add'])->name('purchase_req_add');
    Route::post('purchasing/purchase-requisition/save', [PurchaseController::class, 'purchase_req_save'])->name('purchase_req_save');
    Route::post('purchasing/purchase-requisition/add-item', [PurchaseController::class, 'purchase_req_add_item'])->name('purchase_req_add_item');
    Route::post('purchasing/purchase-requisition/add-item-data', [PurchaseController::class, 'purchase_req_add_item_data'])->name('purchase_req_add_item_data');
    Route::post('purchasing/purchase-requisition/remove-item-data', [PurchaseController::class, 'purchase_req_remove_item_data'])->name('purchase_req_remove_item_data');
    Route::post('purchasing/purchase-requisition/save-item', [PurchaseController::class, 'purchase_req_add_save_item'])->name('purchase_req_add_save_item');
    Route::post('purchasing/purchase-requisition/verify', [PurchaseController::class, 'purchase_req_verify'])->name('purchase_req_verify');
    Route::post('purchasing/purchase-requisition/verify-reject', [PurchaseController::class, 'purchase_req_verify_reject'])->name('purchase_req_verify_reject');
    Route::post('purchasing/purchase-requisition/verify-save', [PurchaseController::class, 'purchase_req_verify_save'])->name('purchase_req_verify_save');
    Route::post('purchasing/purchase-requisition/preview-pr', [PurchaseController::class, 'purchase_req_preview_pr'])->name('purchase_req_preview_pr');
    Route::post('purchasing/purchase-requisition/report-pr', [PurchaseController::class, 'purchase_req_report_pr'])->name('purchase_req_report_pr');

    Route::post('purchasing/purchase-order/add', [PurchaseController::class, 'purchase_order_add'])->name('purchase_order_add');
    Route::post('purchasing/purchase-order/save', [PurchaseController::class, 'purchase_order_save'])->name('purchase_order_save');
    Route::post('purchasing/purchase-order/add-item', [PurchaseController::class, 'purchase_order_add_item'])->name('purchase_order_add_item');
    Route::post('purchasing/purchase-order/pilih-item', [PurchaseController::class, 'purchase_order_pilih_item'])->name('purchase_order_pilih_item');
    Route::post('purchasing/purchase-order/order-item', [PurchaseController::class, 'purchase_order_order_item'])->name('purchase_order_order_item');
    Route::post('purchasing/purchase-order/remove-item-order', [PurchaseController::class, 'purchase_order_remove_item_order'])->name('purchase_order_remove_item_order');
    Route::post('purchasing/purchase-order/save-proses-order', [PurchaseController::class, 'purchase_order_save_proses_order'])->name('purchase_order_save_proses_order');
    Route::post('purchasing/purchase-order/preview-send', [PurchaseController::class, 'purchase_order_preview_send'])->name('purchase_order_preview_send');
    Route::post('purchasing/purchase-order/preview-report', [PurchaseController::class, 'purchase_order_preview_report'])->name('purchase_order_preview_report');
    Route::post('purchasing/purchase-order/evaluasi-purchase-order', [PurchaseController::class, 'purchase_order_evaluasi_purchase_order'])->name('purchase_order_veluasi_purchase_order');
    Route::post('purchasing/purchase-order/checklist-purchase-order', [PurchaseController::class, 'purchase_order_checklist_purchase_order'])->name('purchase_order_checklist_purchase_order');
    Route::post('purchasing/purchase-order/accept-purchase-order', [PurchaseController::class, 'purchase_order_accept_purchase_order'])->name('purchase_order_accept_purchase_order');
    Route::post('purchasing/purchase-order/save-send-purchase-order', [PurchaseController::class, 'purchase_order_save_send_purchase_order'])->name('purchase_order_save_send_purchase_order');
    Route::post('purchasing/purchase-order/terima-barang', [PurchaseController::class, 'purchase_order_terima_barang'])->name('purchase_order_terima_barang');
    Route::post('purchasing/purchase-order/terima-barang-order', [PurchaseController::class, 'purchase_order_terima_barang_order'])->name('purchase_order_terima_barang_order');
    Route::post('purchasing/purchase-order/save-and-generate-code', [PurchaseController::class, 'purchase_order_save_and_generate_grn'])->name('purchase_order_save_and_generate_grn');

    Route::post('purchasing/goods-recived-note/detail', [PurchaseController::class, 'goods_recived_note_detail'])->name('goods_recived_note_detail');
    Route::post('purchasing/goods-recived-note/report', [PurchaseController::class, 'goods_recived_note_report'])->name('goods_recived_note_report');
    Route::post('purchasing/goods-recived-note/pay', [PurchaseController::class, 'goods_recived_note_pay'])->name('goods_recived_note_pay');
    Route::post('purchasing/goods-recived-note/preview', [PurchaseController::class, 'goods_recived_note_preview'])->name('goods_recived_note_preview');
    Route::post('purchasing/goods-recived-note/preview-report', [PurchaseController::class, 'goods_recived_note_preview_report'])->name('goods_recived_note_preview_report');

    Route::post('purchasing/purchase-invoice/preview-report', [PurchaseController::class, 'purchase_invoice_preview_report'])->name('purchase_invoice_preview_report');
    Route::post('purchasing/purchase-invoice/print-report', [PurchaseController::class, 'purchase_invoice_print_report'])->name('purchase_invoice_print_report');

    Route::post('purchasing/cash-purchase/preview-report', [PurchaseController::class, 'purchase_cash_purchase_preview'])->name('purchase_cash_purchase_preview');
    Route::post('purchasing/cash-purchase/print-report', [PurchaseController::class, 'purchase_cash_purchase_print'])->name('purchase_cash_purchase_print');
});


// SUPLLIER
Route::prefix('supplier/')->group(function (): void {
    Route::post('master-supplier/data-supplier/add', [SupplierController::class, 'master_data_supplier_add'])->name('master_data_supplier_add');
    Route::post('master-supplier/data-supplier/save', [SupplierController::class, 'master_data_supplier_save'])->name('master_data_supplier_save');
});
// BRODCAST
Route::prefix('brodcast/')->group(function (): void {
    Route::post('menu-brodcast/brodcast-whatsapp/send', [BrodcastController::class, 'menu_brodcast_whatsapp_send'])->name('menu_brodcast_whatsapp_send');
    Route::post('menu-brodcast/brodcast-management/add', [BrodcastController::class, 'menu_brodcast_management_add'])->name('menu_brodcast_management_add');
    Route::post('menu-brodcast/brodcast-management/save', [BrodcastController::class, 'menu_brodcast_management_save'])->name('menu_brodcast_management_save');
    Route::post('menu-brodcast/brodcast-management/add-peserta', [BrodcastController::class, 'menu_brodcast_management_add_peserta'])->name('menu_brodcast_management_add_peserta');
    Route::post('menu-brodcast/brodcast-management/save-peserta', [BrodcastController::class, 'menu_brodcast_management_save_peserta'])->name('menu_brodcast_management_save_peserta');
    Route::post('menu-brodcast/brodcast-management/brodcast-whatsapp', [BrodcastController::class, 'menu_brodcast_management_brodcast_whatsapp'])->name('menu_brodcast_management_brodcast_whatsapp');
    Route::post('menu-brodcast/brodcast-management/brodcast-whatsapp-send', [BrodcastController::class, 'menu_brodcast_management_brodcast_whatsapp_send'])->name('menu_brodcast_management_brodcast_whatsapp_send');
    Route::post('menu-brodcast/brodcast-management/export-excel', [BrodcastController::class, 'menu_brodcast_management_export_excel'])->name('menu_brodcast_management_export_excel');
    Route::post('menu-brodcast/brodcast-management/export-excel-start', [BrodcastController::class, 'menu_brodcast_management_export_excel_start'])->name('menu_brodcast_management_export_excel_start');

    Route::post('master-brodcast/master-contact/add', [BrodcastController::class, 'master_brodcast_contact_add'])->name('master_brodcast_contact_add');
    Route::post('master-brodcast/master-contact/save', [BrodcastController::class, 'master_brodcast_contact_save'])->name('master_brodcast_contact_save');
});

// LOGISTIK
Route::prefix('logistik/')->group(function (): void {
    Route::post('transaction-product/product-in/add-schedule', [LogistikController::class, 'transaction_product_in_add_schedule'])->name('transaction_product_in_add_schedule');
    Route::post('transaction-product/product-in/save-schedule', [LogistikController::class, 'transaction_product_in_save_schedule'])->name('transaction_product_in_save_schedule');
    Route::post('transaction-product/product-in/incoming', [LogistikController::class, 'transaction_product_in_incoming'])->name('transaction_product_in_incoming');
    Route::post('transaction-product/product-in/incoming-ceheck', [LogistikController::class, 'transaction_product_in_incoming_check'])->name('transaction_product_in_incoming_check');
    Route::post('transaction-product/product-in/pilih-barang', [LogistikController::class, 'transaction_product_in_pilih_barang'])->name('transaction_product_in_pilih_barang');
    Route::post('transaction-product/product-in/save-incoming', [LogistikController::class, 'transaction_product_in_save_incoming'])->name('transaction_product_in_save_incoming');
    Route::post('transaction-product/product-in/preview-schedule', [LogistikController::class, 'transaction_product_in_preview_schedule'])->name('transaction_product_in_preview_schedule');
    Route::post('transaction-product/product-in/preview-report', [LogistikController::class, 'transaction_product_in_preview_report'])->name('transaction_product_in_preview_report');
    Route::get('master-logistik/master-product/data-item', [LogistikController::class, 'master_logistik_data_item'])->name('master_logistik_data_item');
    Route::post('master-logistik/master-product/add-item', [LogistikController::class, 'master_logistik_add_item'])->name('master_logistik_add_item');
    Route::post('master-logistik/master-product/add-item-upload-file', [LogistikController::class, 'master_logistik_add_item_upload_file'])->name('master_logistik_add_item_upload_file');
    Route::post('master-logistik/master-product/add-item-clear-file', [LogistikController::class, 'master_logistik_add_item_clear_file'])->name('master_logistik_add_item_clear_file');
    Route::post('master-logistik/master-product/save-item', [LogistikController::class, 'master_logistik_save_item'])->name('master_logistik_save_item');
    Route::post('master-logistik/master-product/upload-file-item', [LogistikController::class, 'master_logistik_save_item_upload_file'])->name('master_logistik_save_item_upload_file');
    Route::post('master-logistik/master-product/proses-item-upload-file', [LogistikController::class, 'master_logistik_proses_item_upload_file'])->name('master_logistik_proses_item_upload_file');
    Route::get('master-logistik/master-product/data-product', [LogistikController::class, 'master_logistik_data_product'])->name('master_logistik_data_product');
    Route::post('master-logistik/master-product/add-product', [LogistikController::class, 'master_logistik_add_product'])->name('master_logistik_add_product');
    Route::post('master-logistik/master-product/add-product-clear-file', [LogistikController::class, 'master_logistik_add_product_clear_file'])->name('master_logistik_add_product_clear_file');
    Route::post('master-logistik/master-product/save-product', [LogistikController::class, 'master_logistik_save_product'])->name('master_logistik_save_product');
    Route::post('master-logistik/master-product/upload-file-product', [LogistikController::class, 'master_logistik_upload_file_product'])->name('master_logistik_upload_file_product');
    Route::post('master-logistik/master-product/add-product-upload-file', [LogistikController::class, 'master_logistik_add_product_upload_file'])->name('master_logistik_add_product_upload_file');
    Route::post('master-logistik/master-product/proses-product-upload-file', [LogistikController::class, 'master_logistik_proses_product_upload_file'])->name('master_logistik_proses_product_upload_file');
    Route::post('master-logistik/master-product/add-deskripsi-product', [LogistikController::class, 'master_logistik_add_desc_product'])->name('master_logistik_add_desc_product');
    Route::post('master-logistik/master-product/save-deskripsi-product', [LogistikController::class, 'master_logistik_save_desc_product'])->name('master_logistik_save_desc_product');
});


Route::prefix('app/')->group(function (): void {
    Route::get('supplier/r_token/{id}/{token}', [PublicController::class, 'app_supp_token'])->name('app_supp_token');
    Route::post('supplier/r_token/user_token', [PublicController::class, 'app_supp_user_token'])->name('app_supp_user_token');
    Route::post('supplier/r_token/user_token_next', [PublicController::class, 'app_supp_user_token_next'])->name('app_supp_user_token_next');
    Route::post('supplier/r_token/update-order', [PublicController::class, 'app_supp_update_order'])->name('app_supp_update_order');
    Route::post('supplier/r_token/simpan-order', [PublicController::class, 'app_supp_simpan_order'])->name('app_supp_simpan_order');
    Route::post('supplier/r_token/user_token_last', [PublicController::class, 'app_supp_user_token_last'])->name('app_supp_user_token_last');
    Route::get('testpdf', [PublicController::class, 'app_testpdf'])->name('app_testpdf');
});
Route::prefix('pacs')->group(function (): void {
    Route::get('data/{id}', [PacsController::class, 'pacs_preview'])->name('pacs_preview');
});
