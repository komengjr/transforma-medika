<?php

use App\Http\Controllers\Event\CertificateController;
use App\Http\Controllers\Event\EventAddonController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\EventSessionExecutionController;
use App\Http\Controllers\Event\EventSurveyController;
use Illuminate\Support\Facades\Route;
// EVENT
Route::prefix('event/')->group(function (): void {
    Route::post('menu-event/create-event/save', [EventController::class, 'menu_event_create_save'])->name('menu_event_create_save');
    Route::post('menu-event/create-event/upload-template', [EventController::class, 'menu_event_data_upload_template'])->name('menu_event_data_upload_template');
    Route::post('menu-event/create-event/upload-cover', [EventController::class, 'menu_event_data_upload_cover'])->name('menu_event_data_upload_cover');
    Route::post('menu-event/data-event/add-sub-event', [EventController::class, 'menu_event_data_add_sub_event'])->name('menu_event_data_add_sub_event');
    Route::post('menu-event/data-event/save-sub-event', [EventController::class, 'menu_event_data_save_sub_event'])->name('menu_event_data_save_sub_event');
    Route::post('menu-event/data-event/detail-event', [EventController::class, 'menu_event_data_detail_event'])->name('menu_event_data_detail_event');
    Route::post('menu-event/data-event/detail-event/add-type', [EventController::class, 'menu_event_data_detail_event_add_type'])->name('menu_event_data_detail_event_add_type');
    Route::post('menu-event/data-event/detail-event/save-class', [EventController::class, 'menu_event_data_detail_event_save_class'])->name('menu_event_data_detail_event_save_class');
    // Route::post('menu-event/data-event/detail-event/save-session', [EventController::class, 'menu_event_data_detail_event_save_session'])->name('menu_event_data_detail_event_save_session');
    Route::post('menu-event/data-event/form-registrasi-event', [EventController::class, 'menu_event_data_form_registrasi_event'])->name('menu_event_data_form_registrasi_event');
    Route::post('menu-event/data-event/form-registrasi-event/detail-sub-event', [EventController::class, 'menu_event_data_form_registrasi_event_detail_sub_event'])->name('menu_event_data_form_registrasi_event_detail_sub_event');
    Route::post('menu-event/data-event/form-registrasi-event/detail-sub-event/add-peserta', [EventController::class, 'menu_event_data_form_registrasi_event_detail_sub_event_add_peserta'])->name('menu_event_data_form_registrasi_event_detail_sub_event_add_peserta');
    Route::get('menu-event/data-event/form-registrasi-event/detail-sub-event/data-peserta', [EventController::class, 'menu_event_data_form_registrasi_event_detail_sub_event_data_peserta'])->name('menu_event_data_form_registrasi_event_detail_sub_event_data_peserta');
    Route::post('menu-event/data-event/form-registrasi-event/detail-sub-event/data-peserta/send-email/{id}', [EventController::class, 'menu_event_data_form_registrasi_sub_event_data_peserta_send_email'])->name('menu_event_data_form_registrasi_sub_event_data_peserta_send_email');
    Route::delete('menu-event/data-event/form-registrasi-event/detail-sub-event/data-peserta/remove/{id}', [EventController::class, 'menu_event_data_form_registrasi_sub_event_data_peserta_remove'])->name('menu_event_data_form_registrasi_sub_event_data_peserta_remove');
    Route::post('menu-event/data-event/form-registrasi-event/detail-sub-event/data-peserta/verif/{id}', [EventController::class, 'menu_event_data_form_registrasi_sub_event_data_peserta_verify_payment'])->name('menu_event_data_form_registrasi_sub_event_data_peserta_verify_payment');
    Route::post('menu-event/data-event/cek-booking', [EventController::class, 'menu_event_data_form_registrasi_event_cek_booking'])->name('menu_event_data_form_registrasi_event_cek_booking');
    Route::post('menu-event/data-event/test-print', [EventController::class, 'menu_event_data_form_registrasi_event_test_print'])->name('menu_event_data_form_registrasi_event_test_print');

    Route::get('menu-event/daftar-event/get-detail/{code}', [EventController::class, 'menu_event_daftar_get_detail'])->name('menu_event_daftar_get_detail');
    Route::get('menu-event/daftar-event/get-session/{code}', [EventController::class, 'menu_event_daftar_get_session'])->name('menu_event_get_session');
    Route::get('menu-event/daftar-event/get-peserta/{code}', [EventController::class, 'menu_event_daftar_get_peserta'])->name('menu_event_daftar_get_peserta');
    Route::get('menu-event/daftar-event/get-survay/{code}', [EventController::class, 'menu_event_daftar_get_survay'])->name('menu_event_daftar_get_survay');
    Route::post('menu-event/daftar-event/verifikasi-pelunasan-survay/{code}', [EventController::class, 'menu_event_daftar_verifikasi_pelunasan'])->name('menu_event_daftar_verifikasi_pelunasan');

    Route::get('menu-event/data-event/self-registrasi-event/{kode}', [EventController::class, 'menu_event_data_form_self_registrasi'])->name('menu_event_data_form_self_registrasi');

    Route::post('master-event/event-access', [EventController::class, 'storeaccess'])->name('event.access.store');
    Route::delete('master-event/event-access/{id}', [EventController::class, 'destroyaccess'])->name('event.access.destroy');
});
Route::get('/event/rekening/{event_code}', [EventAddonController::class, 'getRekening']);
Route::post('/event/rekening/store', [EventAddonController::class, 'storeRekening']);
Route::delete('/event/rekening/delete/{id}', [EventAddonController::class, 'destroyRekening']);

Route::get('/event/contact/{event_code}', [EventAddonController::class, 'getContact']);
Route::post('/event/contact/store', [EventAddonController::class, 'storeContact']);
Route::delete('/event/contact/delete/{id}', [EventAddonController::class, 'destroyContact']);

Route::prefix('event-email')->name('event.email.')->group(function () {
    // 2. Route Endpoint AJAX Data Filter
    Route::get('/get-sub-events/{eventId}', [EventController::class, 'getSubEvents'])->name('get_sub');
    Route::get('/get-classes/{subCode}', [EventController::class, 'getClasses'])->name('get_classes');
    Route::get('/get-participants', [EventController::class, 'getParticipants'])->name('get_participants');

    // 3. Route Pengiriman Email
    Route::post('/send-single/{idRegistration}', [EventController::class, 'sendEmailSingle'])->name('send_single');
    Route::post('/send-bulk', [EventController::class, 'sendEmailBulk'])->name('send_bulk'); // <-- Tambahkan Route Ini
});
Route::prefix('event-wa')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('event.wa.index');
    Route::get('/get-sub-events/{eventId}', [EventController::class, 'getSubEvents']);
    Route::get('/get-classes/{subCode}', [EventController::class, 'getClasses']);
    Route::get('/get-participants', [EventController::class, 'getParticipants'])->name('event.wa.get_participants');
    Route::post('/send-single/{id}', [EventController::class, 'sendWaSingle']);
    Route::post('/send-bulk', [EventController::class, 'sendWaBulk'])->name('event.wa.send_bulk');
});

Route::get('/event/register/{id}/{code}', [App\Http\Controllers\Event\RegisterController::class, 'event_registrasi'])->name('event_registrasi');
Route::post('/event/{code}/register', [App\Http\Controllers\Event\RegisterController::class, 'store'])->name('event.register.store');

Route::get('/event/sub-events/{eventCode}', [EventController::class, 'getSubEventsData']);
Route::get('/event/sub-classes-by-sub/{subCode}', [EventController::class, 'getSubClassesBySub']);
Route::get('/peserta/search-json', [EventController::class, 'searchParticipantsJson'])->name('peserta.search-json');
// Route proses simpan peserta manual
Route::post('/peserta/store', [EventController::class, 'storeManualPeserta'])->name('admin.peserta.store-manual');
Route::post('/peserta/import-excel', [EventController::class, 'importExcelPeserta'])->name('admin.peserta.import-excel');
Route::get('/peserta/download-template', [EventController::class, 'downloadTemplateExcel'])->name('admin.peserta.download-template');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Page Eksekusi Session
    Route::get('/session/execute', [EventSessionExecutionController::class, 'index'])->name('admin.session.execute');

    // AJAX Process Scan / Check Session Peserta
    Route::post('/session/process-check', [EventSessionExecutionController::class, 'processCheck'])->name('admin.session.process-check');
});

use App\Http\Controllers\EventAttendanceReportController;

Route::prefix('admin/reports/attendance')->name('admin.reports.attendance.')->group(function () {
    Route::get('/get-sub-events/{event_code}', [EventController::class, 'getSubEventsattendance'])->name('get_sub_events');
    Route::get('/get-classes/{sub_code}', [EventController::class, 'getClassesattendance'])->name('get_classes');
    Route::get('/get-sessions/{sub_code}', [EventController::class, 'getSessionsattendance'])->name('get_sessions');
    Route::get('/get-participants', [EventController::class, 'getParticipantsattendance'])->name('get_participants');
});

Route::prefix('event/survey')->name('event.survey.')->group(function () {
    // ADMIN: Fetch & Simpan Pertanyaan Custom
    Route::get('/manage/{eventCode}', [EventSurveyController::class, 'getAdminSurveys'])->name('manage');
    Route::post('/store-question', [EventSurveyController::class, 'storeQuestion'])->name('store_question');
    Route::delete('/delete-question/{id}', [EventSurveyController::class, 'deleteQuestion'])->name('delete_question');

    // PESERTA: Halaman Publik Pengisian Survey
    Route::get('/form/{eventCode}/{registrationCode}', [EventSurveyController::class, 'publicSurveyForm'])->name('public_form');
    Route::post('/submit-answer', [EventSurveyController::class, 'submitPublicAnswer'])->name('submit_answer');
});

Route::middleware(['auth'])->group(function () {
    // Save Class & Session
    Route::post('/event/sub-class/save', [EventController::class, 'saveClass'])->name('menu_event_data_detail_event_saveClass');
    Route::post('/event/sub-session/save', [EventController::class, 'saveSession'])->name('menu_event_data_detail_event_save_session');

    // Delete Class & Session
    Route::delete('/event/sub-class/delete/{id}/{code}', [EventController::class, 'deleteClass'])->name('menu_event_data_detail_event_delete_class');
    Route::delete('/event/sub-session/delete/{id}/{code}', [EventController::class, 'deleteSession'])->name('menu_event_data_detail_event_delete_session');
});

use App\Http\Controllers\Event\EventCertificateController;

Route::prefix('admin/events/certificates')->name('admin.events.certificates.')->group(function () {
    // Route Tampilan Utama E-Sertifikat
    // Route::get('/', [EventCertificateController::class, 'index'])->name('index');

    // Route Cetak Single / Modal Preview PDF
    Route::get('/print/{regCode}', [EventCertificateController::class, 'printSingle'])->name('print_single');

    // Route Cetak Massal (Bulk Print)
    Route::get('/bulk-print', [EventCertificateController::class, 'bulkPrint'])->name('bulk_print');

    // Route AJAX Kirim Email Sertifikat
    Route::post('/send-email/{regCode}', [EventCertificateController::class, 'sendEmail'])->name('send_email');
});

// use App\Http\Controllers\Admin\EventCertificateController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Group Route Sertifikat
    Route::prefix('events/certificates')->name('events.certificates.')->group(function () {

        // 1. Tampilan Builder / Form Upload Template Sertifikat
        Route::get('/builder', [EventCertificateController::class, 'builder'])
            ->name('builder');

        // 2. Proses Upload File Background Template Sertifikat (POST)
        Route::post('/upload-template', [EventCertificateController::class, 'uploadTemplate'])
            ->name('upload_template');

        // 3. Print / Stream Sertifikat Tunggal berdasarkan Kode Registrasi (PDF)
        Route::get('/print/{regCode}', [EventCertificateController::class, 'printSingle'])
            ->name('print_single');
    });
});
Route::get('/verify-certificate/{code}', [CertificateController::class, 'verify'])
    ->name('certificate.verify');


use App\Http\Controllers\WhatsappController;

Route::get('/whatsapp', [WhatsappController::class, 'index'])->name('whatsapp.index');
Route::get('/whatsapp/status', [WhatsappController::class, 'getStatus'])->name('whatsapp.status');
Route::post('/whatsapp/send', [WhatsappController::class, 'sendMessage'])->name('whatsapp.send');
