<?php

namespace App\Services;

use App\Models\FinJurnal;
use Illuminate\Support\Facades\DB;
use Exception;

class AccountingService
{
    public function createJournal($header, $details)
    {
        $totalDebit = 0;
        $totalKredit = 0;

        foreach ($details as $detail) {
            $totalDebit += (float) $detail['jurnal_debit'];
            $totalKredit += (float) $detail['jurnal_kredit'];
        }

        // 1. Validasi keseimbangan dengan toleransi pecahan desimal
        if (abs($totalDebit - $totalKredit) > 0.01) {
            throw new Exception("Jurnal tidak seimbang. Debit: " . $totalDebit . ", Kredit: " . $totalKredit);
        }

        // Generate nomor bukti otomatis jika tidak dikirim dari controller
        $noBukti = $header['jurnal_no_bukti'] ?? 'JV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

        // 2. Insert ke tabel Header (kop_fin_jurnal) dan ambil ID yang baru saja dibuat
        // Menggunakan insertGetId agar kita mendapatkan id_jurnal untuk dihubungkan ke detail
        $idJurnal = DB::table('kop_fin_jurnal')->insertGetId([
            'jurnal_no_bukti'   => $noBukti,
            'jurnal_tgl'        => $header['jurnal_tgl'],
            'jurnal_keterangan' => $header['jurnal_keterangan'],
            'jurnal_ref_table'  => $header['jurnal_ref_table'],
            'jurnal_ref_code'   => $header['jurnal_ref_code'],
            'jurnal_user'       => $header['jurnal_user'],
            'jurnal_cabang'     => $header['jurnal_cabang'],
            'created_at'        => now(),
            'updated_at'        => now()
        ]);

        // 3. Insert ke tabel Detail (kop_fin_jurnal_detail) menggunakan id_jurnal
        foreach ($details as $detail) {
            DB::table('kop_fin_jurnal_detail')->insert([
                'jurnal_id'       => $idJurnal, // Hubungkan dengan ID Header hasil insertGetId di atas
                'coa_code'        => $detail['coa_code'],
                'jurnal_debit'    => (float) $detail['jurnal_debit'],
                'jurnal_kredit'   => (float) $detail['jurnal_kredit'],
                'created_at'      => now(),
                'updated_at'      => now()
            ]);
        }

        return $noBukti;
    }

    private function generateNoBukti()
    {
        $prefix = 'JV-' . date('Ym') . '-';
        $lastJurnal = FinJurnal::where('jurnal_no_bukti', 'like', $prefix . '%')
            ->orderBy('jurnal_no_bukti', 'desc')
            ->first();

        $nextNum = $lastJurnal ? (int) substr($lastJurnal->jurnal_no_bukti, -4) + 1 : 1;
        return $prefix . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
    }
}
