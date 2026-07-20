<?php

use App\Http\Controllers\ApiCntroller;
use App\Http\Controllers\Koperasi\KoperasiController;
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

});
Route::get('/peminjaman-uang', [KoperasiController::class, 'akutansi_koperasi_get_peminjaman']);
Route::post('/peminjaman-uang/{id}/cairkan', [KoperasiController::class, 'akutansi_koperasi_get_peminjaman_cairkan']);
