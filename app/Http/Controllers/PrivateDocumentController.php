<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class PrivateDocumentController extends Controller
{
    public function index()
    {
        // Ambil daftar dokumen milik user yang login
        $documents = DB::table('documents')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('private_docs.index', compact('documents'));
    }

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

            if (strtolower($extension) !== 'pdf') {
                return response()->json(['error' => 'Format file harus PDF'], 422);
            }

            $code = $request->input('code', 'DOC-' . time());
            $fileName = $code . '.' . $extension;
            $folderPath = 'dokumen_private/' . Auth::id();

            Storage::disk('local')->putFileAs($folderPath, $file, $fileName);

            $relativePath = $folderPath . '/' . $fileName;
            $now = now()->toDateTimeString();

            DB::table('documents')->updateOrInsert(
                ['code' => $code],
                [
                    'user_id' => Auth::id(),
                    'code' => $code,
                    'file_path' => $relativePath,
                    'file_name' => $fileName,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            // KEMBALIKAN DATA DATA TAMBAHAN KE JAVASCRIPT
            return response()->json([
                'status' => 'success',
                'code' => $code,
                'created_at' => $now,
                'preview_url' => route('private.docs.preview', $code),
                'filename' => $fileName
            ]);
        }

        $handler = $fileReceived->handler();
        return response()->json([
            'done' => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    public function preview($code)
    {
        $document = DB::table('documents')
            ->where('code', $code)
            ->first();

        if (!$document) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        // Proteksi Otorisasi User
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses dokumen ini.');
        }

        // Cek fisik file di disk local (private)
        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'File PDF tidak ditemukan di storage server.');
        }

        // Streaming file PDF ke browser
        return Storage::disk('local')->response($document->file_path, null, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"'
        ]);
    }
}
