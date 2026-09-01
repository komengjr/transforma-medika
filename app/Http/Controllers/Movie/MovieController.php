<?php

namespace App\Http\Controllers\Movie;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
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
            'description'  => 'nullable|string',
            'poster'       => 'nullable|string',
            'triler'       => 'nullable|string',
            'video'        => 'nullable|string',
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

        // 2. Insert Direct ke Database menggunakan DB Facade
        try {
            DB::table('movies')->insert([
                'title'        => $request->title,
                'description'  => $request->description,
                'poster'       => $request->poster,
                'triler'       => $request->triler,
                'video'        => $request->video,
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
                'message' => 'Data movie berhasil disimpan!'
            ], 200);
        } catch (\Throwable $e) {
            // Log error jika terjadi kesalahan query
            Log::error('Error insert movie DB: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
}
