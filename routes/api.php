<?php

use App\Http\Controllers\Api\Xn500Controller;
use App\Http\Controllers\ApiCntroller;
use App\Http\Controllers\Koperasi\KoperasiController;
use App\Http\Controllers\Medic\LabRegistrationController;
use App\Http\Controllers\Medic\MedicalPemeriksaanLabController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('v1/')->group(function (): void {
    Route::get('data-product', [ApiCntroller::class, 'data_product'])->name('data_product');
    Route::get('data-antrian', [ApiCntroller::class, 'data_antrian'])->name('data_antrian');
    Route::get('stream', [ApiCntroller::class, 'data_stream_api'])->name('data_stream_api');
    Route::get('stream/{id}', [ApiCntroller::class, 'data_stream_id'])->name('data_stream_id');
});
Route::prefix('v2/')->group(function (): void {
    Route::get('getway/whatsapp', [ApiCntroller::class, 'getway_whatsapp'])->name('getway_whatsapp');
    Route::get('getway/whatsapp-update/{code}', [ApiCntroller::class, 'getway_whatsapp_status'])->name('getway_whatsapp_status');
    Route::post('getway/whatsapp-update', [ApiCntroller::class, 'getway_whatsapp_update'])->name('getway_whatsapp_update');
    Route::get('getway/whatsapp-koperasi', [ApiCntroller::class, 'getway_whatsapp_koperasi'])->name('getway_whatsapp_koperasi');
    Route::get('getway/whatsapp-koperasi-update/{code}', [ApiCntroller::class, 'getway_whatsapp_koperasi_update'])->name('getway_whatsapp_koperasi_update');
});
Route::prefix('interface/')->group(function (): void {
    Route::get('alat', [ApiCntroller::class, 'interface_alat'])->name('interface_alat');
    // Route::post('xn-500', [ApiCntroller::class, 'interface_alat_xn_500'])->name('interface_alat_xn_500');

});
Route::post('/interface/xn-500', [Xn500Controller::class, 'receiveData']);
Route::post('/interface/cobas-411', [Xn500Controller::class, 'receiveDataCobas']);
Route::post('/interface/architect-ci4100', [Xn500Controller::class, 'receiveDataArchitec']);
Route::post('/interface/all', [Xn500Controller::class, 'receiveDataAll']);


Route::get('/peminjaman-uang', [KoperasiController::class, 'akutansi_koperasi_get_peminjaman']);
Route::post('/peminjaman-uang/{id}/cairkan', [KoperasiController::class, 'akutansi_koperasi_get_peminjaman_cairkan']);

// Master Pemeriksaan Lab
// Route::get('/lab/pasien/search', [LabRegistrationController::class, 'searchPatient']);
Route::get('/lab/pemeriksaan', [MedicalPemeriksaanLabController::class, 'index']);
Route::post('/lab/pemeriksaan', [MedicalPemeriksaanLabController::class, 'store']);
Route::get('/lab/pendaftaran/{nolab}', [LabRegistrationController::class, 'getDetailOrder']);

Route::prefix('lab')->group(function () {
    Route::get('/', [LabRegistrationController::class, 'index']);
    Route::get('/master-pemeriksaan', [LabRegistrationController::class, 'getMasterPemeriksaan']);
    Route::get('/pasien/search', [LabRegistrationController::class, 'searchPasien']);
    Route::get('/pendaftaran', [LabRegistrationController::class, 'getDaftarPendaftaran']);
    Route::post('/pendaftaran', [LabRegistrationController::class, 'storePendaftaran']);
    Route::get('/pendaftaran/{nolab}', [LabRegistrationController::class, 'showDetail']);
    Route::post('/sync-sysmex', [LabRegistrationController::class, 'syncSysmex']);
    Route::put('/pendaftaran/{id}/hasil', [LabRegistrationController::class, 'updateHasil']);
});
