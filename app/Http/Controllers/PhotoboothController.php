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
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'email'         => 'required|email|max:255',
            'image_data'    => 'required|string', // Foto Gabungan
            'single_images' => 'required|array|min:1', // Array Foto Satuan
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        try {
            do {
                $uniqueCode = Str::upper(Str::random(10));
            } while (PhotoboothResult::where('code', $uniqueCode)->exists());

            // 1. Simpan Foto Gabungan
            $mergedImage = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->input('image_data'));
            $mergedFileName = 'photobooth_merged_' . time() . '_' . $uniqueCode . '.png';
            $mergedPath = 'photobooth/' . $mergedFileName;
            Storage::disk('local')->put($mergedPath, base64_decode($mergedImage));

            // 2. Simpan Setiap Foto Satuan
            $savedSinglePaths = [];
            foreach ($request->input('single_images') as $index => $singleBase64) {
                $singleImage = str_replace(['data:image/png;base64,', ' '], ['', '+'], $singleBase64);
                $singleFileName = 'photobooth_single_' . ($index + 1) . '_' . time() . '_' . $uniqueCode . '.png';
                $singlePath = 'photobooth/' . $singleFileName;

                Storage::disk('local')->put($singlePath, base64_decode($singleImage));
                $savedSinglePaths[] = $singlePath;
            }

            // 3. Simpan ke DB
            $result = PhotoboothResult::create([
                'code'          => $uniqueCode,
                'name'          => $request->name,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'image_path'    => $mergedPath,
                'single_images' => $savedSinglePaths,
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Foto berhasil disimpan!',
                'data'      => $result,
                'share_url' => route('photobooth.show', $result->code)
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function show($code)
    {
        $result = PhotoboothResult::where('code', $code)->firstOrFail();
        return view('photobooth_show', compact('result'));
    }

    // Method akses file gambar (gabungan maupun satuan)
    public function getImage(Request $request, $code)
    {
        $result = PhotoboothResult::where('code', $code)->firstOrFail();
        $type = $request->query('type', 'merged');
        $index = (int) $request->query('index', 0);

        $path = $result->image_path;

        if ($type === 'single' && isset($result->single_images[$index])) {
            $path = $result->single_images[$index];
        }

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return response()->file(storage_path('app/' . $path));
    }
}
