<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
class PrinterController extends Controller
{
    /**
     * Menampilkan halaman menu cetak label.
     */
    public function index(): View
    {
        return view('printer');
    }

    /**
     * Mengembalikan string kode ZPL dalam format JSON.
     */
    public function getZplData(): JsonResponse
    {
        try {
            // Contoh kode ZPL untuk label resi / barang
            $zplCode = "^XA" .
                "^FO50,50^A0N,40,40^FDRUMAH SAKIT MEDIKA^FS" .
                "^FO50,100^A0N,30,30^FDLabel Pasien / Obat^FS" .
                "^FO50,150^BY2^BCN,80,Y,N,N^FD12345678^FS" .
                "^XZ";

            return response()->json([
                'status'  => true,
                'message' => 'ZPL berhasil di-generate.',
                'zpl'     => $zplCode
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal membuat data ZPL: ' . $e->getMessage()
            ], 500);
        }
    }
}
