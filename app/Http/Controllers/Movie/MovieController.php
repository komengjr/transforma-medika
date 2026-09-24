<?php

namespace App\Http\Controllers\Movie;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function url_akses($akses, $id)
    {
        $data = DB::table('z_menu_user')
            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
            ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
            ->where('z_menu.menu_super_code', $id)
            ->where('z_menu_user.menu_sub_code', $akses)
            ->where('z_menu_user.access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    public function url_akses_sub($akses, $id)
    {
        $data = DB::table('z_menu_user_sub')
            ->join('z_menu_sub_main', 'z_menu_sub_main.menu_main_sub_code', '=', 'z_menu_user_sub.menu_main_sub_code')
            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_sub_main.menu_sub_code')
            ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
            ->where('z_menu.menu_super_code', $id)
            ->where('z_menu_user_sub.menu_main_sub_code', $akses)
            ->where('z_menu_user_sub.access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    public function master_data_movie($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = Movie::latest()->get();
            return view('app-movie.master-data.data-movie', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_data_movie_add(Request $request)
    {
        return view('app-movie.master-data.form.form-add-movie');
    }
    public function master_data_movie_save(Request $request)
    {
        // 1. Validasi Input Data
        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'type'         => 'required|string|in:movie,series',
            'description'  => 'nullable|string',
            'poster'       => 'nullable|string',
            'backdrop'     => 'nullable|string',
            'triler'       => 'nullable|string',
            'type_link'    => 'nullable|string|in:online,local',
            'genre'        => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'rating'       => 'nullable|string|max:50',
            'subtitle'     => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $videoFilename = null;

            // 2. Jika tipe konten adalah 'movie', tangani sumber videonya (bisa online link atau upload file lokal)
            if ($request->type === 'movie') {
                if ($request->type_link === 'local' && $request->hasFile('video')) {
                    $videoFile = $request->file('video');
                    // Buat nama file unik
                    $videoFilename = Str::slug($request->title) . '-' . time() . '.' . $videoFile->getClientOriginalExtension();
                    // Simpan ke storage/app/video/
                    $videoFile->storeAs('video', $videoFilename, 'local');
                } else {
                    // Jika berupa link string (online) atau path teks
                    $videoFilename = $request->video;
                }
            }

            // 3. Buat Slug unik berdasarkan judul film/series
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;

            // Cek apakah slug sudah ada di database, jika ya tambahkan angka di belakangnya
            while (DB::table('movies')->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            // 4. Insert ke Database menggunakan DB Facade (termasuk kolom slug dan type)
            DB::table('movies')->insert([
                'title'        => $request->title,
                'slug'         => $slug,
                'type'         => $request->type, // 'movie' atau 'series'
                'description'  => $request->description,
                'poster'       => $request->poster,
                'backdrop'     => $request->backdrop,
                'triler'       => $request->triler,
                'video'        => $videoFilename,
                'type_link'    => $request->type_link,
                'genre'        => $request->genre,
                'release_date' => $request->release_date,
                'rating'       => $request->rating,
                'subtitle'     => $request->subtitle,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Data master berhasil disimpan!'
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error insert movie/series DB: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function master_data_movie_add_episode(Request $request)
    {
        $movieId = $request->movie_id;
        $series = DB::table('movies')->where('id', $movieId)->first();

        if (!$series) {
            return '<div class="alert alert-danger fs--1 text-center m-3">Series tidak ditemukan.</div>';
        }

        return view('app-movie.master-data.form.form-add-episode', compact('series'));
    }
    public function master_data_movie_save_episode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'movie_id'       => 'required|exists:movies,id',
            'season_number'  => 'nullable|integer|min:1',
            'episode_number' => 'required|integer|min:1',
            'title'          => 'required|string|max:255',
            'type_link'      => 'required|string|in:online,local',
            'description'    => 'nullable|string',
            'upload_id'      => 'nullable|string', // Tangkap upload_id dari JS
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $videoFilename = null;

            if ($request->type_link === 'local') {
                if ($request->hasFile('video')) {
                    $file = $request->file('video');
                    $extension = $file->getClientOriginalExtension() ?: 'mp4';

                    // Gunakan upload_id yang dikirim dari JS agar konsisten di setiap chunk
                    $uploadId = $request->input('upload_id', time());
                    $videoFilename = Str::slug($request->title) . '-ep-' . $request->episode_number . '-' . $uploadId . '.' . $extension;

                    $chunkIndex = (int) $request->input('dzchunkindex', 0);
                    $totalChunks = (int) $request->input('dztotalchunkcount', 1);

                    if ($totalChunks > 1) {
                        $tempDir = storage_path('app/video/temp');
                        if (!file_exists($tempDir)) {
                            mkdir($tempDir, 0777, true);
                        }

                        $chunkFilename = $videoFilename . '.part_' . $chunkIndex;
                        $file->move($tempDir, $chunkFilename);

                        // Cek apakah seluruh chunk sudah terkirim lengkap
                        $allChunksUploaded = true;
                        for ($i = 0; $i < $totalChunks; $i++) {
                            if (!file_exists($tempDir . '/' . $videoFilename . '.part_' . $i)) {
                                $allChunksUploaded = false;
                                break;
                            }
                        }

                        if (!$allChunksUploaded) {
                            // Jika belum lengkap, berikan respons khusus agar JS lanjut kirim chunk berikutnya
                            return response()->json([
                                'status'         => true,
                                'chunk_uploaded' => true,
                                'message'        => 'Chunk ' . ($chunkIndex + 1) . ' dari ' . $totalChunks . ' berhasil diunggah.'
                            ]);
                        }

                        // Jika sudah lengkap (chunk terakhir), gabungkan filenya ke folder utama
                        $finalPath = storage_path('app/video/' . $videoFilename);
                        $videoDir = storage_path('app/video');
                        if (!file_exists($videoDir)) {
                            mkdir($videoDir, 0777, true);
                        }

                        $finalFile = fopen($finalPath, 'wb');
                        for ($i = 0; $i < $totalChunks; $i++) {
                            $chunkPath = $tempDir . '/' . $videoFilename . '.part_' . $i;
                            if (file_exists($chunkPath)) {
                                $chunkFile = fopen($chunkPath, 'rb');
                                stream_copy_to_stream($chunkFile, $finalFile);
                                fclose($chunkFile);
                                unlink($chunkPath); // Hapus part file setelah digabung
                            }
                        }
                        fclose($finalFile);
                    } else {
                        // File lokal ukuran kecil (tanpa chunk)
                        $file->storeAs('video', $videoFilename);
                    }
                }
            } else {
                // Tipe online
                $videoFilename = $request->input('video_url');
            }

            // Cek duplikasi episode pada series & season yang sama
            $exists = DB::table('episodes')
                ->where('movie_id', $request->movie_id)
                ->where('season_number', $request->season_number ?? 1)
                ->where('episode_number', $request->episode_number)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status'  => false,
                    'message' => "Episode {$request->episode_number} pada Season {$request->season_number} sudah ada di series ini!"
                ], 422);
            }

            // Generate Slug Unik
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;

            while (DB::table('episodes')->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            // Simpan data ke tabel episodes
            DB::table('episodes')->insert([
                'movie_id'       => $request->movie_id,
                'season_number'  => $request->season_number ?? 1,
                'episode_number' => $request->episode_number,
                'title'          => $request->title,
                'slug'           => $slug,
                'description'    => $request->description,
                'video'          => $request->type_link === 'local' ? 'video/' . $videoFilename : $videoFilename,
                'duration'       => $request->duration ?? null,
                'views_count'    => 0,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Episode berhasil disimpan ke database!'
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error insert episode DB: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function stream($slug)
    {
        $movie = null;
        $episodes = collect(); // Inisialisasi collection kosong

        // 1. Cek terlebih dahulu apakah slug/id yang diminta adalah sebuah Episode di tabel 'episodes'
        $episode = DB::table('episodes')
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->first();

        if ($episode) {
            // Jika yang diakses adalah episode, ambil data master series-nya dari tabel 'movies'
            $seriesMaster = DB::table('movies')->where('id', $episode->movie_id)->first();

            if ($seriesMaster) {
                // Gabungkan atribut master series ke objek episode agar view tetap membaca $movie->title, dll.
                // Data episode akan menimpa data master yang spesifik seperti judul episode, video, dan durasi.
                $movie = (object) array_merge((array) $seriesMaster, (array) $episode);

                // Simpan ID asli episode untuk penanda active di sidebar
                $movie->id = $episode->id;
                $movie->title = $episode->title; // Judul spesifik episode
                $movie->description = $episode->description ?? $seriesMaster->description;
                $movie->video = $episode->video;
                $movie->duration = $episode->duration;
                $movie->views_count = $episode->views_count;

                // Increment views count untuk episode tersebut
                DB::table('episodes')->where('id', $episode->id)->increment('views_count');

                // Ambil seluruh daftar episode dari series ini untuk ditampilkan di sidebar
                $episodes = DB::table('episodes')
                    ->where('movie_id', $seriesMaster->id)
                    ->orderBy('season_number', 'asc')
                    ->orderBy('episode_number', 'asc')
                    ->get();
            }
        }

        // 2. Jika tidak ditemukan di tabel episodes, cari sebagai Film Tunggal (Movie) di tabel 'movies'
        if (!$movie) {
            $movie = DB::table('movies')
                ->where('type', 'movie')
                ->where(function ($query) use ($slug) {
                    $query->where('slug', $slug)
                        ->orWhere('id', $slug);
                })
                ->first();

            // Jika tetap tidak ditemukan, lempar error 404
            if (!$movie) {
                abort(404);
            }

            // Increment views count untuk film tunggal
            DB::table('movies')->where('id', $movie->id)->increment('views_count');
        }

        // 3. Ambil daftar rekomendasi film/series lain dengan genre yang sama dari tabel 'movies'
        $related = DB::table('movies')
            ->where('genre', $movie->genre ?? '')
            ->where('id', '!=', $movie->movie_id ?? $movie->id)
            ->take(6)
            ->get();

        return view('frontend.stream', compact('movie', 'episodes', 'related'));
    }

    /**
     * Tampilkan halaman daftar episode jika yang diklik adalah tipe Series (Induk).
     */
    public function seriesDetail($slug)
    {
        // 1. Ambil data induk series dari tabel 'movies' berdasarkan slug atau id, pastikan tipenya 'series'
        $series = DB::table('movies')
            ->where('type', 'series')
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->first();

        // Jika series tidak ditemukan, kembalikan error 404
        if (!$series) {
            abort(404);
        }

        // 2. Increment views_count pada tabel 'movies'
        DB::table('movies')
            ->where('id', $series->id)
            ->increment('views_count');

        // 3. Ambil daftar episode dari tabel 'episodes' berdasarkan foreign key 'movie_id'
        $episodes = DB::table('episodes')
            ->where('movie_id', $series->id)
            ->orderBy('season_number', 'asc')
            ->orderBy('episode_number', 'asc')
            ->get();

        return view('frontend.series_detail', compact('series', 'episodes'));
    }
    public function stream_film($filename)
    {
        // Path menuju storage/app/video/{filename}
        $path = storage_path('app/video/' . basename($filename));

        if (!file_exists($path)) {
            abort(404, 'File video tidak ditemukan.');
        }

        $size = filesize($path);
        $stream = fopen($path, 'rb');
        $range = request()->header('Range');

        $begin = 0;
        $end = $size - 1;

        if ($range) {
            $c_start = $begin;
            $c_end = $end;

            list(, $range) = explode('=', $range, 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $begin-$end/$size");
                exit;
            }
            if ($range == '-') {
                $c_start = $size - substr($range, 1);
            } else {
                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
            }
            $c_end = ($c_end > $size - 1) ? $size - 1 : $c_end;
            if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $begin-$end/$size");
                exit;
            }
            $start = $c_start;
            $end = $c_end;
            $length = $end - $start + 1;
            fseek($stream, $start);

            return response()->stream(function () use ($stream) {
                $buffer = 1024 * 8;
                while (!feof($stream)) {
                    echo fread($stream, $buffer);
                    flush();
                }
                fclose($stream);
            }, 206, [
                "Content-Type" => mime_content_type($path),
                "Content-Length" => $length,
                "Content-Range" => "bytes $start-$end/$size",
                "Accept-Ranges" => "bytes",
            ]);
        }

        return response()->stream(function () use ($stream) {
            $buffer = 1024 * 8;
            while (!feof($stream)) {
                echo fread($stream, $buffer);
                flush();
            }
            fclose($stream);
        }, 200, [
            "Content-Type" => mime_content_type($path),
            "Content-Length" => $size,
            "Accept-Ranges" => "bytes",
        ]);
    }
}
