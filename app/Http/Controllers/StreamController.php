<?php

namespace App\Http\Controllers;

use App\Models\NewsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StreamController extends Controller
{
    public function pixeldrain($id, Request $request)
    {
        $url = "https://pixeldra.in/api/file/" . $id;

        // Ambil HEAD untuk mendapatkan ukuran & tipe
        $headers = get_headers($url, 1);

        if (strpos($headers[0], "403") !== false) {
            return response("File not accessible", 403);
        }

        $contentType  = $headers["Content-Type"] ?? "video/mp4";
        $fileSize     = $headers["Content-Length"] ?? null;

        // Mendukung range request (status 206)
        $range = $request->header('Range');

        if ($range && $fileSize) {
            list($unit, $rangeValue) = explode('=', $range, 2);
            list($start, $end) = explode('-', $rangeValue);

            $start = intval($start);
            $end = $end === "" ? $fileSize - 1 : intval($end);

            $length = $end - $start + 1;

            header("Content-Type: $contentType");
            header("Accept-Ranges: bytes");
            header("Content-Length: $length");
            header("Content-Range: bytes $start-$end/$fileSize");
            http_response_code(206);

            $context = stream_context_create([
                "http" => [
                    "header" => "Range: bytes=$start-$end"
                ]
            ]);

            $stream = fopen($url, "rb", false, $context);

            while (!feof($stream)) {
                echo fread($stream, 8192);
                flush();
            }
            fclose($stream);
            exit;
        }

        // Tidak ada Range → kirim full file
        header("Content-Type: $contentType");
        header("Content-Length: $fileSize");
        header("Accept-Ranges: bytes");

        $stream = fopen($url, "rb");

        while (!feof($stream)) {
            echo fread($stream, 8192);
            flush();
        }

        fclose($stream);
        exit;
    }
    public function tidore_stream()
    {
        $data = NewsData::inRandomOrder()->first();
        return response()->json([
            'data' => Cache::get('/news/detail/', $data->news_data_slug)
        ]);
    }
}
