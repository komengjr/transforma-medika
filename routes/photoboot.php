<?php

use App\Http\Controllers\PhotoboothController;
use Illuminate\Support\Facades\Route;

Route::get('/setup-photo', [PhotoboothController::class, 'index'])->name('photobooth.index');
Route::post('/photobooth/store', [PhotoboothController::class, 'store'])->name('photobooth.store');
Route::get('/photobooth/result/{code}', [PhotoboothController::class, 'show'])->name('photobooth.show');
// Route::get('/photobooth/{id}', [PhotoboothController::class, 'show'])->name('photobooth.show');
Route::get('/photobooth/{code}/image', [PhotoboothController::class, 'getImage'])->name('photobooth.image');
