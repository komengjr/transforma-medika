<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopSimpananWajibHistori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_simpanan_wajib_histori', function (Blueprint $table) {
            $table->bigIncrements('id_simpanan_wajib_histori');

            // Relasi ke tabel peserta (sesuaikan tipe datanya dengan primary key di kop_master_peserta, misal integer/bigInteger)
            $table->integer('id_kop_master_peserta')->index();

            // Relasi ke tabel jurnal finansial
            $table->unsignedBigInteger('id_jurnal');

            // Kolom pelacak periode & waktu (Format: YYYY-MM, contoh: 2026-07)
            $table->string('periode_bulan', 7)->index();
            $table->date('tgl_bayar');

            // Nominal pembayaran
            $table->decimal('nominal', 15, 2);

            $table->timestamps();

            // Setup Foreign Key Constraints ke tabel jurnal jika diperlukan audit ketat
            // Pastikan tabel kop_fin_jurnal sudah ada terlebih dahulu sebelum menjalankan ini
            $table->foreign('id_jurnal')
                ->references('id_jurnal')
                ->on('kop_fin_jurnal')
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
        Schema::dropIfExists('kop_simpanan_wajib_histori');
    }
}
