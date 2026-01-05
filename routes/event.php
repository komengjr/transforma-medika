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
    Route::post('menu-event/data-event/form-registrasi-event', [EventController::class, 'menu_event_data_form_registrasi_event'])->name('menu_event_data_form_registrasi_event');
});
