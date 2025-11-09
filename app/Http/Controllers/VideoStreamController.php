<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VideoStreamController extends Controller
{
    public function stream($id, Request $request)
    {
        $nama = DB::table('movies')->where('id', $id)->first();
        if ($nama) {
            $path = storage_path('app/private/videos/' . $nama->video);

            if (!file_exists($path)) {
                abort(404, 'Video not found');
            }

            $size = filesize($path);
            $file = fopen($path, 'rb');
            $start = 0;
            $length = $size;
            $headers = [
                'Content-Type' => 'video/mp4',
                'Accept-Ranges' => 'bytes',
            ];

            if ($request->hasHeader('Range')) {
                // Contoh: Range: bytes=1000-
                $range = $request->header('Range');
                [$unit, $range] = explode('=', $range, 2);
                [$rangeStart, $rangeEnd] = explode('-', $range, 2);

                $start = intval($rangeStart);
                $end = $rangeEnd ? intval($rangeEnd) : ($size - 1);
                $length = $end - $start + 1;

                fseek($file, $start);

                $headers['Content-Range'] = "bytes $start-$end/$size";
                $headers['Content-Length'] = $length;

                return response()->stream(function () use ($file, $length) {
                    $buffer = 1024 * 8; // 8KB buffer
                    $bytesLeft = $length;

                    while (!feof($file) && $bytesLeft > 0) {
                        $chunk = fread($file, min($buffer, $bytesLeft));
                        echo $chunk;
                        flush();
                        $bytesLeft -= strlen($chunk);
                    }

                    fclose($file);
                }, 206, $headers);
            } else {
                // No Range header — kirim seluruh file
                $headers['Content-Length'] = $size;

                return response()->stream(function () use ($file) {
                    fpassthru($file);
                    fclose($file);
                }, 200, $headers);
            }
        }else{
            return redirect()->back();
        }
    }
}
