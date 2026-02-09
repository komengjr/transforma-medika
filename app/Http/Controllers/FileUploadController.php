<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileUploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        // 1. Validasi file yang masuk
        $request->validate([
            'document' => 'required|file|max:5120', // Max 5MB
        ]);

        try {
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // 2. Proses upload ke disk 'sftp'
            // putFileAs(folder_tujuan, file_objek, nama_file_baru)
            $path = Storage::disk('sftp')->putFileAs(
                'documents',
                $file,
                $fileName
            );

            if ($path) {
                return response()->json([
                    'success' => true,
                    'message' => 'File berhasil dikirim via SFTP!',
                    'path' => $path
                ], 200);
            }

            throw new Exception("Gagal menyimpan file ke server SFTP.");
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadFile($fileName)
    {
        // Contoh cara mendownload file dari SFTP
        if (Storage::disk('sftp')->exists('documents/' . $fileName)) {
            return Storage::disk('sftp')->download('documents/' . $fileName);
        }
        return "File tidak ditemukan.";
    }
    public function uploadFileftp(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        Storage::disk('ftp')->put(
            'uploads/' . $filename,
            fopen($file, 'r+')
        );

        return response()->json([
            'status' => 'success',
            'file' => $filename
        ]);
    }
}
