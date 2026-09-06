<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
    private $waServerUrl = 'http://127.0.0.1:3000';

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
        $userId = Auth::user()->userid ?? Auth::id();

        // Mengarahkan ke IP loopback 127.0.0.1
        $serverUrl = str_replace('localhost', '127.0.0.1', $this->waServerUrl ?? 'http://127.0.0.1:80');

        try {
            $response = Http::timeout(5)
                ->acceptJson()
                ->withHeaders([
                    // Gunakan User-Agent browser standar untuk keamanan ekstra dari blokir Nginx/WAF
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ])
                ->get("{$serverUrl}/status/{$userId}");

            if ($response->successful()) {
                return response()->json($response->json());
            }

            // Respon jika Node.js merespon selain status HTTP 200 (misal 500 / 404)
            return response()->json([
                'status' => 'DISCONNECTED',
                'qr'     => '',
                'error'  => 'HTTP Error: ' . $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            // Respon jika service Node.js mati / Port 3000 tidak merespon (Connection Refused)
            return response()->json([
                'status' => 'OFFLINE',
                'qr'     => '',
                'error'  => 'Node.js Server Offline: ' . $e->getMessage()
            ], 503);
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
