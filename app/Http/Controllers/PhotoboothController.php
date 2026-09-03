<?php

namespace App\Http\Controllers;

use App\Models\PhotoboothResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PhotoboothController extends Controller
{
    public function index()
    {
        $frames = [
            ['name' => 'Frame 1', 'image' => asset('frames/frame1.png')],
            ['name' => 'Frame 2', 'image' => asset('frames/frame2.png')],
        ];

        return view('photobooth', compact('frames'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'email'      => 'required|email|max:255',
            'image_data' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            // Generate Kode Unik
            do {
                $uniqueCode = Str::upper(Str::random(10));
            } while (PhotoboothResult::where('code', $uniqueCode)->exists());

            // Process Base64 Image
            $imageData = $request->input('image_data');
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageDecoded = base64_decode($image);

            $fileName = 'photobooth_' . time() . '_' . $uniqueCode . '.png';
            $filePath = 'photobooth/' . $fileName;

            // Simpan ke storage/app/photobooth/ (Disk Local)
            Storage::disk('local')->put($filePath, $imageDecoded);

            // Simpan ke DB
            $result = PhotoboothResult::create([
                'code'       => $uniqueCode,
                'name'       => $request->name,
                'phone'      => $request->phone,
                'email'      => $request->email,
                'image_path' => $filePath,
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Foto berhasil disimpan!',
                'data'      => $result,
                'share_url' => route('photobooth.show', $result->code)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Menampilkan halaman viewer berdasarkan 'code'
    public function show($code)
    {
        $result = PhotoboothResult::where('code', $code)->firstOrFail();

        return view('photobooth_show', compact('result'));
    }

    // Mengambil file gambar asli berdasarkan 'code'
    public function getImage($code)
    {
        $result = PhotoboothResult::where('code', $code)->firstOrFail();

        if (!Storage::disk('local')->exists($result->image_path)) {
            abort(404);
        }

        return response()->file(storage_path('app/' . $result->image_path));
    }
}
