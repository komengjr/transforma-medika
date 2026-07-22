<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopTrxPeminjamanAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tabel Utama Transaksi Peminjaman Uang
        Schema::create('kop_trx_pinjaman_anggota', function (Blueprint $table) {
            $table->id();

            // Identitas Transaksi & Anggota
            $table->string('nota_nomor', 50)->unique()->comment('Nomor Akad/Kontrak Pinjaman');
            $table->unsignedBigInteger('anggota_id')->comment('Relasi ke kop_master_peserta.id_kop_master_peserta');
            $table->string('tujuan_pinjaman', 255)->nullable()->comment('Alasan/Keperluan peminjaman uang');
            $table->date('tanggal_pinjaman');

            // Nominal & Kalkulasi Finansial
            $table->decimal('jumlah_pinjaman', 15, 2)->default(0)->comment('Pokok pinjaman yang disetujui');
            $table->decimal('biaya_admin', 15, 2)->default(0)->comment('Biaya admin (dipotong dari dana pencairan)');
            $table->decimal('pencairan_netto', 15, 2)->default(0)->comment('Dana riil cair ke anggota (Jumlah Pinjaman - Biaya Admin)');
            $table->decimal('bunga_koperasi', 15, 2)->default(0)->comment('Total bunga/margin flat selama tenor');
            $table->decimal('total_piutang', 15, 2)->default(0)->comment('Total kewajiban pengembalian (Jumlah Pinjaman + Bunga)');
            $table->integer('tenor_bulan')->comment('Durasi angsuran dalam bulan');
            $table->decimal('cicilan_per_bulan', 15, 2)->default(0)->comment('Besar angsuran per bulan');

            // Alur Approval & Status Tagihan
            $table->enum('status_pinjaman', ['PENDING_APPROVAL', 'APPROVED', 'REJECTED'])
                ->default('PENDING_APPROVAL')
                ->comment('Status verifikasi pengajuan pinjaman');

            $table->enum('status_tagihan', ['DRAFT', 'BELUM_LUNAS', 'LUNAS', 'BATAL'])
                ->default('DRAFT')
                ->comment('Status keaktifan piutang pinjaman');

            // Referensi Akun COA Jurnal Akuntansi (Double Entry)
            $table->string('coa_piutang', 50)->nullable()->comment('Kode COA Piutang Pinjaman Anggota (Debet)');
            $table->string('sumber_dana_coa', 50)->nullable()->comment('Kode COA Kas/Bank Koperasi Pencairan (Kredit)');
            $table->string('coa_pendapatan_admin', 50)->nullable()->comment('Kode COA Pendapatan Admin Pinjaman (Kredit)');
            $table->string('coa_pendapatan_bunga', 50)->nullable()->comment('Kode COA Pendapatan Bunga Pinjaman (Kredit)');

            // Track Record User
            $table->string('created_by', 100)->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // Indexing & Foreign Key Constraints
            $table->index('anggota_id');
            $table->index('status_pinjaman');
            $table->index('status_tagihan');

            $table->foreign('anggota_id')
                ->references('id_kop_master_peserta')
                ->on('kop_master_peserta')
                ->onDelete('restrict');
        });

        // 2. Tabel Jadwal Angsuran / Tenor Pinjaman Uang
        Schema::create('kop_trx_pinjaman_tenor', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel utama kop_trx_pinjaman_anggota
            $table->unsignedBigInteger('id_pinjaman')->comment('Relasi ke kop_trx_pinjaman_anggota.id');

            // Detail Angsuran
            $table->integer('angsuran_ke')->comment('Urutan angsuran (1, 2, 3, dst)');
            $table->date('jatuh_tempo')->comment('Tanggal jatuh tempo angsuran');

            // Breakdown Tagihan Bulanan
            $table->decimal('pokok_tagihan', 15, 2)->default(0)->comment('Angsuran pokok per bulan');
            $table->decimal('bunga_tagihan', 15, 2)->default(0)->comment('Angsuran bunga per bulan');
            $table->decimal('jumlah_tagihan', 15, 2)->default(0)->comment('Total tagihan bulanan (Pokok + Bunga)');

            // Status & Realisasi Pembayaran
            $table->enum('status_bayar', ['BELUM', 'LUNAS', 'PARTIAL'])
                ->default('BELUM')
                ->comment('Status bayar angsuran');

            $table->decimal('jumlah_dibayar', 15, 2)->default(0)->comment('Total nominal terbayar');
            $table->date('tanggal_bayar')->nullable()->comment('Tanggal pembayaran terakhir');
            $table->string('ref_pembayaran_id', 100)->nullable()->comment('Ref bukti penerimaan kas/bank');

            $table->timestamps();

            // Foreign Key & Indexing
            $table->index('id_pinjaman');
            $table->index('status_bayar');
            $table->index('jatuh_tempo');

            $table->foreign('id_pinjaman')
                ->references('id')
                ->on('kop_trx_pinjaman_anggota')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_trx_pinjaman_tenor');
        Schema::dropIfExists('kop_trx_pinjaman_anggota');
    }
}
