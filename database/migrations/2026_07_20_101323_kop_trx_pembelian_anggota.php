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
            $table->id('id_pembelian');
            $table->string('nota_nomor', 50)->unique();

            // Relasi ke tabel kop_master_peserta
            $table->unsignedBigInteger('anggota_id');

            $table->string('barang_nama', 255);
            $table->decimal('harga_beli', 15, 2);      // Harga modal dari toko/supplier
            $table->decimal('margin_koperasi', 15, 2)->default(0); // Margin keuntungan flat
            $table->decimal('total_piutang', 15, 2);   // Harga Beli + Margin
            $table->integer('tenor_bulan');            // Jangka waktu cicilan
            $table->decimal('cicilan_per_bulan', 15, 2);
            $table->date('tanggal_transaksi');
            $table->enum('status_tagihan', ['BELUM_LUNAS', 'LUNAS'])->default('BELUM_LUNAS');
            // NEW: Kolom validasi persetujuan Ketua Koperasi
            $table->enum('status_persetujuan', ['PENDING', 'DISETUJUI', 'DITOLAK'])->default('PENDING');
            $table->text('alasan_penolakan')->nullable();
            $table->string('disetujui_oleh', 100)->nullable();
            $table->datetime('tanggal_persetujuan')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->timestamps();

            // Set Foreign Key Constraint ke tabel peserta Anda
            $table->foreign('anggota_id')
                ->references('id_kop_master_peserta')
                ->on('kop_master_peserta')
                ->onDelete('restrict'); // Mencegah data peserta dihapus jika memiliki transaksi
        });

        // 2. Tabel Jadwal Angsuran / Tenor Detail
        Schema::create('kop_trx_pembelian_tenor', function (Blueprint $table) {
            $table->id('id_tenor');
            $table->unsignedBigInteger('id_pembelian');
            $table->integer('angsuran_ke');
            $table->date('jatuh_tempo');
            $table->decimal('jumlah_tagihan', 15, 2);
            $table->enum('status_bayar', ['BELUM', 'LUNAS'])->default('BELUM');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();

            // Set Foreign Key Constraint ke tabel induk pembelian
            $table->foreign('id_pembelian')
                ->references('id_pembelian')
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
