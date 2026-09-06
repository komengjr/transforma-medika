<?php

namespace App\Http\Controllers\Photobooth;

use App\Http\Controllers\Controller;
use App\Models\PhotoboothResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ViewPhotoboothController extends Controller
{
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
