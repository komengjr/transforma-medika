<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class DocumentController extends Controller
{
    /**
     * Tampilkan halaman utama (Menu Upload + Daftar PDF)
     */
    public function index()
    {
        // Ambil daftar dokumen milik user yang sedang login
        $documents = DB::table('monitoring_hasil_pasien')
            ->where('userid', Auth::user()->userid)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('documents.index', compact('documents'));
    }

    /**
     * Proses Upload Chunked & Simpan ke Storage Private
     */
    public function upload(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            return response()->json(['error' => 'File tidak ditemukan'], 400);
        }

        $fileReceived = $receiver->receive();

        if ($fileReceived->isFinished()) {
            $file = $fileReceived->getFile();
            $extension = $file->getClientOriginalExtension();

            // Validasi hanya menerima file PDF
            if (strtolower($extension) !== 'pdf') {
                return response()->json(['error' => 'Format file harus PDF'], 422);
            }

            $code = $request->input('code', 'DOC-' . time());
            $fileName = $code . '.' . $extension;

            // Folder penyimpanan private: storage/app/private/datahasil/new/{userid}/
            $relativePath = 'datahasil/new/' . Auth::user()->userid;

            // Simpan file ke disk 'local' (Private Storage)
            Storage::disk('local')->putFileAs($relativePath, $file, $fileName);

            $dbFilePath = $relativePath . '/' . $fileName;

            // Simpan / update record di database
            DB::table('monitoring_hasil_pasien')->updateOrInsert(
                ['monitoring_hasil_pasien_code' => $code],
                [
                    'userid' => Auth::user()->userid,
                    'monitoring_hasil_pasien_file' => $dbFilePath,
                    'monitoring_hasil_pasien_status' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            return response()->json([
                'status' => 'success',
                'preview_url' => route('documents.preview', $code),
                'filename' => $fileName
            ]);
        }

        // Response persentase proses chunk upload
        $handler = $fileReceived->handler();
        return response()->json([
            'done' => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Ambil File PDF dari Storage Private & Streaming ke Browser
     */
    public function preview($code)
    {
        $document = DB::table('monitoring_hasil_pasien')
            ->where('monitoring_hasil_pasien_code', $code)
            ->first();

        // 1. Cek Record DB
        if (!$document || !$document->monitoring_hasil_pasien_file) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        // 2. Proteksi Hak Akses (Otorisasi Pengguna)
        if ($document->userid != Auth::user()->userid) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $filePath = $document->monitoring_hasil_pasien_file;

        // 3. Cek Fisik File di Private Storage (disk 'local')
        if (!Storage::disk('local')->exists($filePath)) {
            abort(404, 'File PDF tidak ditemukan di storage server.');
        }

        // 4. Sajikan file secara Inline HTTP Response dengan Content-Type PDF
        return Storage::disk('local')->response($filePath, null, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }
}
