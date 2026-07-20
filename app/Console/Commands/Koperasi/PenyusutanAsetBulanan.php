<?php

namespace App\Console\Commands\Koperasi;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PenyusutanAsetBulanan extends Command
{
    /**
     * Nama perintah yang dipanggil via terminal/artisan
     * @var string
     */
    protected $signature = 'koperasi:susutkan-aset';

    /**
     * Deskripsi perintah saat melihat php artisan list
     * @var string
     */
    protected $description = 'Memproses penyusutan bulanan otomatis untuk aktiva tetap koperasi dan mencatat jurnal akuntansi.';

    /**
     * Eksekusi logika utama command
     */
    public function handle()
    {
        $this->info('=== Memulai Proses Penyusutan Aset Bulanan ===');
        $tglProses = date('Y-m-d');
        $periodeYm = date('Ym'); // Format: 202607

        // 1. Ambil data aset yang aktif (kategori ASET dan harga > 0)
        $asets = DB::table('kop_pembelian_barang')
            ->where('kategori', 'ASET')
            ->where('total_harga', '>', 0)
            ->get();

        if ($asets->isEmpty()) {
            $this->warn('Tidak ada data barang dengan kategori ASET untuk disusutkan.');
            return Command::SUCCESS;
        }

        $counterSukses = 0;

        foreach ($asets as $aset) {
            try {
                // Hitung biaya penyusutan reguler standar garis lurus (Straight Line)
                // Rumus: Total Harga / (Umur Ekonomis * 12 Bulan)
                $umurTahun = $aset->umur_ekonomis_tahun ?? 4;
                $totalBulanEkonomis = $umurTahun * 12;
                $penyusutanPerBulan = (int) ceil($aset->total_harga / $totalBulanEkonomis);

                // 2. Cek apakah aset ini sudah pernah disusutkan sebelumnya
                $totalTersusut = DB::table('kop_fin_jurnal_detail as jd')
                    ->join('kop_fin_jurnal as j', 'jd.jurnal_id', '=', 'j.id_jurnal')
                    ->where('j.jurnal_ref_table', 'kop_pembelian_barang')
                    ->where('j.jurnal_ref_code', $aset->pembelian_code)
                    ->where('jd.coa_code', 'like', '5%') // Ambil nilai debit di akun beban
                    ->sum('jd.jurnal_debit');

                // Cek Nilai Buku Saat Ini
                $nilaiBukuSisa = $aset->total_harga - $totalTersusut;

                // Jika nilai buku sudah 0 atau habis, lewati aset ini
                if ($nilaiBukuSisa <= 0) {
                    $this->line("Barang [{$aset->nama_barang}] sudah habis masa penyusutannya (Nilai Buku = 0). Skip.");
                    continue;
                }

                // Jika sisa nilai buku lebih kecil dari penyusutan bulanan, habiskan sisanya saja
                if ($nilaiBukuSisa < $penyusutanPerBulan) {
                    $penyusutanPerBulan = $nilaiBukuSisa;
                }

                // 3. Proteksi double-input: Pastikan aset ini belum disusutkan pada bulan yang sama
                $sudahPernahBulanIni = DB::table('kop_fin_jurnal')
                    ->where('jurnal_ref_table', 'kop_pembelian_barang')
                    ->where('jurnal_ref_code', $aset->pembelian_code)
                    ->where('jurnal_no_bukti', 'like', "DEP-{$periodeYm}-%")
                    ->exists();

                if ($sudahPernahBulanIni) {
                    $this->line("Aset [{$aset->nama_barang}] sudah pernah disusutkan untuk periode {$periodeYm}. Skip.");
                    continue;
                }

                // 4. Generate Nomor Bukti Jurnal Depresiasi
                // Skema COA Asumsi:
                // - Debit: 5xxxx (Beban Penyusutan Aset)
                // - Kredit: 125xx (Akumulasi Penyusutan Aset)
                $coaBebanPenyusutan = '5.1.1'; // Sesuaikan dengan master COA Beban Penyusutan Anda
                $coaAkumulasiAset   = '1.2.1'; // Sesuaikan dengan master COA Akumulasi Penyusutan Anda

                DB::beginTransaction();

                $prefixJurnal = "DEP-{$periodeYm}-";
                $lastJournal = DB::table('kop_fin_jurnal')
                    ->where('jurnal_no_bukti', 'like', $prefixJurnal . '%')
                    ->orderBy('jurnal_no_bukti', 'desc')->first();
                $nextNum = $lastJournal ? sprintf('%04d', ((int) substr($lastJournal->jurnal_no_bukti, -4)) + 1) : '0001';
                $noBuktiJurnal = 'JV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

                // Insert Header Jurnal Penyusutan
                $idJurnal = DB::table('kop_fin_jurnal')->insertGetId([
                    'jurnal_no_bukti'   => $noBuktiJurnal,
                    'jurnal_tgl'        => $tglProses,
                    'jurnal_keterangan' => "Penyusutan Otomatis Bulanan [{$aset->nama_barang}] - Periode " . date('F Y'),
                    'jurnal_ref_table'  => 'kop_pembelian_barang',
                    'jurnal_ref_code'   => $aset->pembelian_code,
                    'jurnal_user'       => 'System Scheduler',
                    'jurnal_cabang'     => 'HO',
                    'jurnal_created'    => 'System',
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);

                // Detail Jurnal - (DEBIT) Beban Penyusutan
                DB::table('kop_fin_jurnal_detail')->insert([
                    'jurnal_id'     => $idJurnal,
                    'coa_code'      => $coaBebanPenyusutan,
                    'jurnal_debit'  => $penyusutanPerBulan,
                    'jurnal_kredit' => 0,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                // Detail Jurnal - (KREDIT) Akumulasi Penyusutan Aset
                DB::table('kop_fin_jurnal_detail')->insert([
                    'jurnal_id'     => $idJurnal,
                    'coa_code'      => $coaAkumulasiAset,
                    'jurnal_debit'  => 0,
                    'jurnal_kredit' => $penyusutanPerBulan,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                DB::commit();

                $counterSukses++;
                $this->info("✓ Sukses menyusutkan [{$aset->nama_barang}] senilai Rp " . number_format($penyusutanPerBulan, 0, ',', '.'));
            } catch (Exception $e) {
                DB::rollBack();
                $this->error("❌ Gagal memproses aset ID {$aset->id_pembelian}: " . $e->getMessage());
                Log::error("Gagal Penyusutan Aset Bulanan ID {$aset->id_pembelian}: " . $e->getMessage());
            }
        }

        $this->info("=== Proses Selesai. {$counterSukses} Aset Berhasil Disusutkan ===");
        return Command::SUCCESS;
    }

    /**
     * Helper pintar untuk menentukan COA Akumulasi secara otomatis
     * Contoh: Jika COA Aset 1210 (Inventaris), pasangannya adalah 1211 (Akumulasi Inventaris)
     */
    public function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void
    {
        // Menjalankan command ini secara otomatis setiap akhir bulan jam 23:50 malam
        $schedule->command($this->signature)->lastDayOfMonth('23:50');
    }
}
