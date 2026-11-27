<?php

use App\Http\Controllers\Hrm\HrmController;
use Illuminate\Support\Facades\Route;
// FARMASI
Route::prefix('hrm/')->group(function (): void {
    Route::get('manajemen/kpi-dan-target/getKpiByDept/{deptCode}', [HrmController::class, 'getKpiByDept'])->name('getKpiByDept');
    Route::post('manajemen/kpi-dan-target/store', [HrmController::class, 'store'])->name('kpi.penilaian.store');
    Route::get('manajemen/kpi-dan-target/getDetailAjax/{pegawaiCode}/{periode}', [HrmController::class, 'show'])->name('kpi.penilaian.show');

    Route::get('payroll/data-gaji/get-data', [HrmController::class, 'payroll_data_gaji_get_data'])->name('payroll_data_gaji_get_data');
    Route::get('payroll/data-gaji/get-detail/{pegawaiCode}', [HrmController::class, 'payroll_data_gaji_get_detail'])->name('payroll_data_gaji_get_detail');
    Route::post('payroll/data-gaji/store', [HrmController::class, 'payroll_data_gaji_store'])->name('payroll_data_gaji_store');
    Route::get('payroll/data-gaji/export-excel', [HrmController::class, 'payroll_data_gaji_export_excel'])->name('payroll_data_gaji_export_excel');
    Route::get('payroll/data-gaji/print-pdf/{pegawaiCode}', [HrmController::class, 'payroll_data_gaji_print'])->name('payroll_data_gaji_print');
    Route::get('payroll/data-gaji/get-status/{pegawaiCode}', [HrmController::class, 'payroll_data_gaji_get_status'])->name('payroll_data_gaji_get_status');
    Route::get('payroll/data-gaji/preview-html/{pegawaiCode}', [HrmController::class, 'payroll_data_gaji_preview_html'])->name('payroll_data_gaji_preview_html');

    Route::get('master-kpi/master-kpi-rekap/get-rekap', [HrmController::class, 'master_data_kpi_rekap_get'])->name('master_data_kpi_rekap_get');
});

Route::prefix('/hrm/payroll')->group(function () {
    // ==========================================
    // ENDPOINT AJAX: GET DATA
    // ==========================================
    // Ambil daftar pegawai beserta perhitungan BPJS Kes, BPJS TK & PPh 21 (bisa difilter periode/divisi/jabatan/ptkp)
    Route::get('/bpjs-pajak/data', [HrmController::class, 'get_data_potongan_pegawai'])
        ->name('hrm.payroll.bpjs-pajak.data');

    // Ambil detail pengaturan & rincian potongan satu pegawai berdasarkan hrm_m_pegawai_code
    Route::get('/bpjs-pajak/detail/{pegawai_code}', [HrmController::class, 'get_detail_potongan_pegawai'])
        ->name('hrm.payroll.bpjs-pajak.detail');

    // Ambil data master referensi (PTKP, TER, Konfigurasi BPJS, Departemen, Jabatan)
    Route::get('/bpjs-pajak/master-referensi', [HrmController::class, 'get_master_referensi_pajak'])
        ->name('hrm.payroll.bpjs-pajak.master-referensi');

    // Ambil arsip/rekap potongan bulanan dari hrm_transaksi_potongan_bulanan berdasarkan periode (YYYY-MM)
    Route::get('/bpjs-pajak/rekap-periode', [HrmController::class, 'get_rekap_potongan_periode'])
        ->name('hrm.payroll.bpjs-pajak.rekap-periode');

    // ==========================================
    // ENDPOINT AJAX: SIMPAN DATA
    // ==========================================
    // Simpan pengaturan per pegawai ke hrm_pegawai_pajak_bpjs
    Route::post('/bpjs-pajak/simpan-pegawai', [HrmController::class, 'simpan_skema_potongan_pegawai'])
        ->name('hrm.payroll.bpjs-pajak.simpan-pegawai');

    // Simpan pengaturan massal (Semua / Divisi / Jabatan)
    Route::post('/bpjs-pajak/simpan-massal', [HrmController::class, 'simpan_skema_potongan_massal'])
        ->name('hrm.payroll.bpjs-pajak.simpan-massal');

    // Simpan parameter tarif baku BPJS ke hrm_master_bpjs_config
    Route::post('/bpjs-pajak/simpan-tarif', [HrmController::class, 'simpan_master_tarif'])
        ->name('hrm.payroll.bpjs-pajak.simpan-tarif');

    // Hitung & simpan potongan bulanan ke hrm_transaksi_potongan_bulanan
    Route::post('/bpjs-pajak/simpan-periode', [HrmController::class, 'simpan_potongan_periode'])
        ->name('hrm.payroll.bpjs-pajak.simpan-periode');

    // Update status posting (DRAFT -> FINAL) pada hrm_transaksi_potongan_bulanan
    Route::post('/bpjs-pajak/posting-periode', [HrmController::class, 'posting_potongan_periode'])
        ->name('hrm.payroll.bpjs-pajak.posting-periode');
});

Route::prefix('hrm/accounting/payroll-payment')->group(function () {
    // API / AJAX endpoints
    Route::get('/data', [HrmController::class, 'payroll_payment_get_data'])
        ->name('accounting_hrm_payroll_payment_data');

    Route::get('/detail/{pegawaiCode}', [HrmController::class, 'payroll_payment_get_detail'])
        ->name('accounting_hrm_payroll_payment_detail');

    Route::post('/pay', [HrmController::class, 'payroll_payment_pay'])
        ->name('accounting_hrm_payroll_payment_pay');

    Route::post('/pay-bulk', [HrmController::class, 'payroll_payment_pay_bulk'])
        ->name('accounting_hrm_payroll_payment_pay_bulk');

    Route::get('/export-excel', [HrmController::class, 'payroll_payment_export_excel'])
        ->name('accounting_hrm_payroll_payment_export_excel');
});
