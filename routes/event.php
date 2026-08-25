<?php

use App\Http\Controllers\Event\EventController;
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
    Route::post('menu-event/data-event/detail-event/save-session', [EventController::class, 'menu_event_data_detail_event_save_session'])->name('menu_event_data_detail_event_save_session');
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

    Route::get('menu-event/data-event/self-registrasi-event/{kode}', [EventController::class, 'menu_event_data_form_self_registrasi'])->name('menu_event_data_form_self_registrasi');
});

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
