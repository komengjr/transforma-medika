<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmMasterPajak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Master Status PTKP & Pemetaan Kategori TER (PP 58/2023)
        Schema::create('hrm_master_ptkp', function (Blueprint $table) {
            $table->id('id_hrm_master_ptkp');
            $table->string('hrm_ptkp_code', 20)->unique(); // Contoh: TK/0, K/0, K/1, K/2, K/3
            $table->string('hrm_ptkp_desc');
            $table->enum('hrm_ter_kategori', ['A', 'B', 'C']); // Penentu tabel TER
            $table->decimal('hrm_ptkp_tahunan', 15, 2)->default(54000000);
            $table->timestamps();
        });

        // 2. Master Tabel Lapisan Tarif Efektif Rata-Rata (TER) PPh 21
        Schema::create('hrm_master_ter_tarif', function (Blueprint $table) {
            $table->id('id_hrm_ter_tarif');
            $table->enum('hrm_ter_kategori', ['A', 'B', 'C']);
            $table->decimal('bruto_min', 15, 2);
            $table->decimal('bruto_max', 15, 2)->nullable(); // Null = lapisan teratas (> max)
            $table->decimal('tarif_persen', 6, 4); // Contoh: 0.2500 untuk 0.25%, 1.5000 untuk 1.5%
            $table->year('tahun_berlaku')->default(2026);
            $table->timestamps();

            $table->index(['hrm_ter_kategori', 'bruto_min', 'bruto_max'], 'idx_ter_lookup');
        });

        // 3. Master Konfigurasi Global BPJS & Risiko Departemen
        Schema::create('hrm_master_bpjs_config', function (Blueprint $table) {
            $table->id('id_hrm_bpjs_config');
            $table->string('hrm_bpjs_config_code', 50)->unique();
            $table->string('nama_konfigurasi');
            // BPJS Kesehatan
            $table->decimal('bpjs_kes_karyawan_persen', 5, 2)->default(1.00);
            $table->decimal('bpjs_kes_perusahaan_persen', 5, 2)->default(4.00);
            $table->decimal('bpjs_kes_max_upah', 15, 2)->default(12000000);
            // BPJS Ketenagakerjaan
            $table->decimal('bpjs_jht_karyawan_persen', 5, 2)->default(2.00);
            $table->decimal('bpjs_jht_perusahaan_persen', 5, 2)->default(3.70);
            $table->decimal('bpjs_jp_karyawan_persen', 5, 2)->default(1.00);
            $table->decimal('bpjs_jp_perusahaan_persen', 5, 2)->default(2.00);
            $table->decimal('bpjs_jp_max_upah', 15, 2)->default(10547400);
            $table->decimal('bpjs_jkk_perusahaan_persen', 5, 2)->default(0.24); // Bisa beda per tingkat risiko departemen
            $table->decimal('bpjs_jkm_perusahaan_persen', 5, 2)->default(0.30);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Profil Pengaturan Pajak & BPJS Per Pegawai (Terintegrasi dengan hrm_master_pegawai)
        Schema::create('hrm_pegawai_pajak_bpjs', function (Blueprint $table) {
            $table->id('id_hrm_pegawai_pajak_bpjs');
            $table->string('hrm_m_pegawai_code')->unique(); // Relasi ke hrm_master_pegawai
            $table->string('hrm_departemen_code')->nullable(); // Relasi ke hrm_departemen (untuk filter/bulk)
            $table->string('hrm_jabatan_code')->nullable(); // Relasi ke hrm_jabatan (untuk filter/bulk)
            $table->string('hrm_bpjs_config_code', 50)->default('DEFAULT_2026');

            // Identitas Perpajakan & Kepesertaan
            $table->string('npwp_nomor', 30)->nullable();
            $table->boolean('is_npwp_valid')->default(true);
            $table->string('hrm_ptkp_code', 20)->default('TK/0'); // Relasi ke hrm_master_ptkp
            $table->enum('status_subjek_pajak', ['PEGAWAI_TETAP', 'PEGAWAI_TIDAK_TETAP', 'TENAGA_AHLI'])->default('PEGAWAI_TETAP');
            $table->enum('metode_pajak', ['GROSS', 'NET', 'GROSS_UP'])->default('GROSS');

            // Kepesertaan BPJS Kesehatan
            $table->string('no_bpjs_kesehatan', 30)->nullable();
            $table->boolean('is_bpjs_kes_aktif')->default(true);

            // Kepesertaan BPJS Ketenagakerjaan
            $table->string('no_bpjs_ketenagakerjaan', 30)->nullable();
            $table->enum('mode_bpjs_tk', ['FULL', 'JHT_ONLY', 'NONAKTIF'])->default('FULL');

            // Komponen Dasar Perhitungan (Gaji Pokok + Tunjangan Tetap)
            $table->decimal('dasar_upah_bpjs', 15, 2)->default(0);
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->decimal('tunjangan_tetap', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('hrm_m_pegawai_code')
                ->references('hrm_m_pegawai_code')
                ->on('hrm_master_pegawai')
                ->onDelete('cascade');
        });

        // 5. Log / Transaksi Potongan Bulanan (Arsip Payroll per Periode)
        Schema::create('hrm_transaksi_potongan_bulanan', function (Blueprint $table) {
            $table->id('id_hrm_potongan_bulanan');
            $table->string('kode_transaksi_potongan', 50)->unique();
            $table->string('periode_payroll', 7); // Format: YYYY-MM (Contoh: 2026-11)
            $table->string('hrm_m_pegawai_code');
            $table->string('hrm_departemen_code')->nullable();
            $table->string('hrm_jabatan_code')->nullable();

            // Snapshot Parameter Saat Hitung
            $table->string('hrm_ptkp_code', 20);
            $table->enum('hrm_ter_kategori', ['A', 'B', 'C']);
            $table->enum('metode_pajak', ['GROSS', 'NET', 'GROSS_UP']);
            $table->decimal('dasar_upah_bpjs', 15, 2);
            $table->decimal('penghasilan_bruto_pajak', 15, 2);

            // Rincian Potongan Karyawan (Mengurangi Take Home Pay)
            $table->decimal('pot_bpjs_kes_karyawan', 15, 2)->default(0);
            $table->decimal('pot_bpjs_jht_karyawan', 15, 2)->default(0);
            $table->decimal('pot_bpjs_jp_karyawan', 15, 2)->default(0);
            $table->decimal('tarif_ter_persen', 6, 4)->default(0);
            $table->decimal('nilai_pph21', 15, 2)->default(0);
            $table->decimal('pot_pph21_karyawan', 15, 2)->default(0); // 0 jika NET / GROSS_UP
            $table->decimal('total_potongan_karyawan', 15, 2)->default(0);

            // Rincian Tanggungan Perusahaan (Untuk Jurnal Akuntansi / Beban Perusahaan)
            $table->decimal('tanggungan_bpjs_kes_pt', 15, 2)->default(0);
            $table->decimal('tanggungan_bpjs_jht_pt', 15, 2)->default(0);
            $table->decimal('tanggungan_bpjs_jp_pt', 15, 2)->default(0);
            $table->decimal('tanggungan_bpjs_jkk_pt', 15, 2)->default(0);
            $table->decimal('tanggungan_bpjs_jkm_pt', 15, 2)->default(0);

            $table->enum('status_posting', ['DRAFT', 'FINAL'])->default('DRAFT');
            $table->timestamps();

            $table->unique(['periode_payroll', 'hrm_m_pegawai_code'], 'uniq_periode_pegawai');
        });
        Schema::create('hrm_payroll_coa_mapping', function (Blueprint $table) {
            $table->id();
            $table->string('kode_item', 50)->unique()->comment('Kode komponen gaji atau item sistem (GAPOK, LEMBUR, POT_BPJS_KES, POT_BPJS_TK, POT_PPH21, THP_TRANSFER_BANK, dll)');
            $table->string('nama_item', 150);
            $table->enum('kategori', ['pendapatan', 'potongan', 'bpjs_pajak', 'pembayaran'])->index();
            $table->enum('posisi_jurnal', ['D', 'K'])->comment('D = Debit, K = Kredit');
            $table->string('coa_code', 30)->nullable()->index()->comment('Relasi ke kode akun master COA');
            $table->boolean('is_active')->default(true);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_transaksi_potongan_bulanan');
        Schema::dropIfExists('hrm_pegawai_pajak_bpjs');
        Schema::dropIfExists('hrm_master_bpjs_config');
        Schema::dropIfExists('hrm_master_ter_tarif');
        Schema::dropIfExists('hrm_master_ptkp');
        Schema::dropIfExists('hrm_payroll_coa_mapping');
    }
}
