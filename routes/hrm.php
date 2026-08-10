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
