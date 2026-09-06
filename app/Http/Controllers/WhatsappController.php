<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
    private $waServerUrl = 'http://localhost:3000';

    // Halaman Menu Device WA
    public function index()
    {
        try {
            $response = Http::get("{$this->waServerUrl}/status")->json();
        } catch (\Exception $e) {
            $response = ['status' => 'OFFLINE', 'qr' => ''];
        }

        return view('whatsapp.index', compact('response'));
    }

    // Endpoint AJAX untuk auto-refresh QR Code / Status
    public function getStatus()
    {
        $userId = Auth::user()->userid; // Mengambil ID user yang sedang login

        try {
            $response = Http::get("{$this->waServerUrl}/status/{$userId}")->json();
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['status' => 'OFFLINE', 'qr' => '']);
        }
    }

    // Fungsi Kirim Pesan
    public function sendMessage(Request $request)
    {
        $request->validate([
            'number'     => 'required',
            'message'    => 'nullable|string',
            'attachment' => 'nullable|file|max:10240' // Maksimal ukuran 10 MB
        ]);

        $userId = Auth::user()->userid;
        $payload = [
            'userId'  => $userId,
            'number'  => $request->number,
            'message' => $request->message ?? '',
        ];

        // Proses File Attachment jika diunggah
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $payload['attachment'] = [
                'filename' => $file->getClientOriginalName(),
                'mimetype' => $file->getMimeType(),
                'base64'   => base64_encode(file_get_contents($file->getRealPath()))
            ];
        }

        try {
            $response = Http::timeout(30)->post("{$this->waServerUrl}/send-message", $payload);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                return back()->with('status', $result['message'] ?? 'Pesan berhasil terkirim!');
            }

            return back()->with('status', 'Gagal: ' . ($result['message'] ?? 'Terjadi kesalahan pada server WhatsApp.'));
        } catch (\Exception $e) {
            return back()->with('status', 'Gagal: ' . $e->getMessage());
        }
    }
}
