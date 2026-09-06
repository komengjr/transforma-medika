<?php

use App\Http\Controllers\Brodcast\BrodcastController;
use App\Http\Controllers\Brodcast\WhatsappBroadcastController;
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
    Route::post('master-brodcast/configure-whatsapp/confrim-token-payment', [BrodcastController::class, 'master_brodcast_configure_whatsapp_confrim_payment'])->name('master_brodcast_configure_whatsapp_confrim_payment');

    Route::post('menu-brodcast/brodcast-email/send', [BrodcastController::class, 'menu_brodcast_email_send'])->name('menu_brodcast_email_send');
    // Endpoint AJAX Tambahan untuk Peforma
    Route::get('menu-brodcast/brodcast-email/contacts-ajax', [BrodcastController::class, 'get_contacts_ajax'])->name('menu_brodcast_email.contacts_ajax');
    Route::get('menu-brodcast/brodcast-email/history-ajax', [BrodcastController::class, 'get_history_datatables'])->name('menu_brodcast_email.history_ajax');
    Route::get('menu-brodcast/brodcast-email/progress/{batch_id}', [BrodcastController::class, 'check_progress'])->name('menu_brodcast_email.progress');
});



Route::prefix('brodcast/menu-brodcast/brodcast-whatsapp')->group(function () {
    // Route Tampilan Utama Blade
    Route::get('/', [WhatsappBroadcastController::class, 'index'])->name('menu_brodcast_whatsapp');

    // Route Ajax DataTables History
    Route::get('/history-ajax', [WhatsappBroadcastController::class, 'historyAjax'])->name('menu_brodcast_whatsapp.history_ajax');

    // Route Ajax Select2 Contact Search
    Route::get('/contacts-ajax', [WhatsappBroadcastController::class, 'contactsAjax'])->name('menu_brodcast_whatsapp.contacts_ajax');

    // Route Send Broadcast
    Route::post('/send', [WhatsappBroadcastController::class, 'send'])->name('menu_brodcast_whatsapp_send');

    // Route Polling Progress Bar
    Route::get('/progress/{batchId}', [WhatsappBroadcastController::class, 'progress'])->name('menu_brodcast_whatsapp.progress');
});
