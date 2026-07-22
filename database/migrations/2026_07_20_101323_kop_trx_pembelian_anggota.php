<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopTrxPembelianAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tabel Utama Pembelian Barang
        Schema::create('kop_trx_pembelian_anggota', function (Blueprint $table) {
            $table->id();

            // Identitas Transaksi & Anggota
            $table->string('nota_nomor', 50)->unique();
            $table->unsignedBigInteger('anggota_id')->comment('Relasi ke kop_master_peserta.id_kop_master_peserta');
            $table->string('barang_nama', 255);
            $table->date('tanggal_transaksi');

            // Nominal & Kalkulasi Finansial
            $table->decimal('harga_beli', 15, 2)->default(0)->comment('Harga modal riil ke supplier');
            $table->decimal('biaya_admin', 15, 2)->default(0)->comment('Biaya admin dipotong di awal dari kas pencairan');
            $table->decimal('bunga_koperasi', 15, 2)->default(0)->comment('Total bunga flat yang dibebankan ke anggota & dicicil');
            $table->decimal('total_piutang', 15, 2)->default(0)->comment('Total kewajiban anggota (Harga Beli + Bunga)');
            $table->integer('tenor_bulan')->comment('Durasi angsuran (3, 6, 12, dst)');
            $table->decimal('cicilan_per_bulan', 15, 2)->default(0)->comment('Besar angsuran per bulan (Total Piutang / Tenor)');

            // Alur Approval & Tagihan
            $table->enum('status_pembelian', ['PENDING_APPROVAL', 'APPROVED', 'REJECTED'])
                ->default('PENDING_APPROVAL')
                ->comment('Status verifikasi persetujuan');

            $table->enum('status_tagihan', ['DRAFT', 'BELUM_LUNAS', 'LUNAS', 'BATAL'])
                ->default('DRAFT')
                ->comment('Status keaktifan piutang/tagihan');

            // Referensi Akun COA Jurnal Akuntansi (Double Entry)
            $table->string('coa_piutang', 50)->nullable()->comment('Kode COA untuk Piutang Anggota (Debet)');
            $table->string('sumber_dana_coa', 50)->nullable()->comment('Kode COA Kas/Bank Koperasi (Kredit Netto)');
            $table->string('coa_pendapatan_admin', 50)->nullable()->comment('Kode COA Pendapatan Biaya Admin (Kredit)');
            $table->string('coa_pendapatan_bunga', 50)->nullable()->comment('Kode COA Pendapatan Bunga (Kredit)');

            // Track Record User
            $table->string('created_by', 100)->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // Indexing & Foreign Key Constraints
            $table->index('anggota_id');
            $table->index('status_pembelian');
            $table->index('status_tagihan');

            $table->foreign('anggota_id')
                ->references('id_kop_master_peserta')
                ->on('kop_master_peserta')
                ->onDelete('restrict');
        });

        // 2. Tabel Jadwal Angsuran / Tenor Detail
        Schema::create('kop_trx_pembelian_tenor', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel utama kop_trx_pembelian_anggota
            $table->unsignedBigInteger('id_pembelian')->comment('Relasi ke kop_trx_pembelian_anggota.id');

            // Detail Angsuran & Rincian Komponen Tagihan
            $table->integer('angsuran_ke')->comment('Urutan bulan angsuran (1, 2, 3, dst)');
            $table->date('jatuh_tempo')->comment('Tanggal jatuh tempo pembayaran bulan tersebut');

            // Break down tagihan bulanan (Biaya admin sudah dipotong di awal, jadi tidak ada di tenor)
            $table->decimal('pokok_tagihan', 15, 2)->default(0)->comment('Komponen angsuran pokok per bulan');
            $table->decimal('bunga_tagihan', 15, 2)->default(0)->comment('Komponen angsuran bunga per bulan');
            $table->decimal('jumlah_tagihan', 15, 2)->default(0)->comment('Total angsuran bulanan (Pokok + Bunga)');

            // Status & Realisasi Pembayaran
            $table->enum('status_bayar', ['BELUM', 'LUNAS', 'PARTIAL'])
                ->default('BELUM')
                ->comment('Status pembayaran angsuran bulan ini');

            $table->decimal('jumlah_dibayar', 15, 2)->default(0)->comment('Total nominal yang sudah dibayarkan');
            $table->date('tanggal_bayar')->nullable()->comment('Tanggal terakhir pembayaran dilakukan');
            $table->string('ref_pembayaran_id', 100)->nullable()->comment('Nomor ref/bukti bayar/kasir jika ada');

            $table->timestamps();

            // Foreign Key & Indexing
            $table->index('id_pembelian');
            $table->index('status_bayar');
            $table->index('jatuh_tempo');

            // Set Foreign Key ke tabel utama
            $table->foreign('id_pembelian')
                ->references('id')
                ->on('kop_trx_pembelian_anggota')
                ->onDelete('cascade'); // Jika data induk dihapus, jadwal tenor otomatis terhapus
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_trx_pembelian_tenor');
        Schema::dropIfExists('kop_trx_pembelian_anggota');
    }
}
