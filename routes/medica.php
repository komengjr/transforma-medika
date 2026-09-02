<?php

use App\Http\Controllers\TatController;
use Illuminate\Support\Facades\Route;


Route::prefix('tat')->name('master_tat.')->group(function () {
    Route::get('/get-lab', [TatController::class, 'getDataLab'])->name('get_lab');
    Route::get('/get-nonlab', [TatController::class, 'getDataNonLab'])->name('get_nonlab');
    Route::post('/update-lab', [TatController::class, 'updateLab'])->name('update_lab');
    Route::post('/update-nonlab', [TatController::class, 'updateNonLab'])->name('update_nonlab');
});
