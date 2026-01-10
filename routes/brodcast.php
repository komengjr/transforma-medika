<?php

use App\Http\Controllers\Brodcast\BrodcastController;
use Illuminate\Support\Facades\Route;

// BRODCAST
Route::prefix('brodcast/')->group(function (): void {
    Route::post('menu-brodcast/brodcast-whatsapp/send', [BrodcastController::class, 'menu_brodcast_whatsapp_send'])->name('menu_brodcast_whatsapp_send');
    Route::post('menu-brodcast/brodcast-whatsapp/upload-file', [BrodcastController::class, 'menu_brodcast_whatsapp_upload_file'])->name('menu_brodcast_whatsapp_upload_file');
    Route::post('menu-brodcast/brodcast-whatsapp/remove-file', [BrodcastController::class, 'menu_brodcast_whatsapp_remove_file'])->name('menu_brodcast_whatsapp_remove_file');
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
    Route::post('master-brodcast/master-contact/import', [BrodcastController::class, 'master_brodcast_contact_import'])->name('master_brodcast_contact_import');
    Route::post('master-brodcast/master-contact/import-save', [BrodcastController::class, 'master_brodcast_contact_import_save'])->name('master_brodcast_contact_import_save');
    Route::post('master-brodcast/configure-whatsapp/buy-kuota', [BrodcastController::class, 'master_brodcast_configure_whatsapp_buy_kuota'])->name('master_brodcast_configure_whatsapp_buy_kuota');
    Route::post('master-brodcast/configure-whatsapp/get-token-payment', [BrodcastController::class, 'master_brodcast_configure_whatsapp_token_payment'])->name('master_brodcast_configure_whatsapp_token_payment');
});
