<?php

namespace App\Services;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;

class ZebraPrinterService
{
    public function sendToPrinter(string $zplCode)
    {
        try {
            // Panggil nama printer yang sudah di-share tadi
            // Format: (Nama Komputer Anda)\(Nama Share Printer)
            // Jika dijalankan di PC yang sama, cukup masukkan nama share-nya saja
            $connector = new WindowsPrintConnector("Zebra_USB");

            // Kirim perintah mentah ZPL ke printer USB
            $connector->write($zplCode);
            $connector->finalize();

            return [
                'status'  => true,
                'message' => 'Dokumen berhasil dikirim ke printer Zebra USB.'
            ];
        } catch (\Exception $e) {
            return [
                'status'  => false,
                'message' => 'Gagal mencetak: ' . $e->getMessage()
            ];
        }
    }
}
