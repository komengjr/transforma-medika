<?php

use App\Http\Controllers\Movie\MovieController;
use Illuminate\Support\Facades\Route;
// MOVIE
Route::prefix('movie/')->group(function (): void {
    Route::post('master-data/data-movie/add', [MovieController::class, 'master_data_movie_add'])->name('master_data_movie_add');
    Route::post('master-data/data-movie/save', [MovieController::class, 'master_data_movie_save'])->name('master_data_movie_save');
    Route::post('master-data/data-movie/add-episode', [MovieController::class, 'master_data_movie_add_episode'])->name('master_data_movie_add_episode');
    Route::post('master-data/data-movie/save-episode', [MovieController::class, 'master_data_movie_save_episode'])->name('master_data_movie_save_episode');
});
Route::get('/watch/stream/{slug}', [MovieController::class, 'stream']);

// Route untuk menampilkan list episode jika yang diklik berupa Series utama
Route::get('/watch/series/{slug}', [MovieController::class, 'seriesDetail']);

Route::get('/stream-file/{filename}', [MovieController::class, 'stream_film'])->name('stream.file');
