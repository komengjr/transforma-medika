<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopJadwalArisan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_jadwal_arisan', function (Blueprint $table) {
            $table->id('id_kop_jadwal_arisan');

            // Relasi ke Master Arisan
            $table->unsignedBigInteger('id_kop_master_arisan');
            $table->foreign('id_kop_master_arisan')
                ->references('id_kop_master_arisan')
                ->on('kop_master_arisan')
                ->onDelete('cascade');

            // Relasi ke Master Peserta (mengambil data dari table Anda)
            $table->unsignedBigInteger('id_kop_master_peserta');
            $table->foreign('id_kop_master_peserta')
                ->references('id_kop_master_peserta')
                ->on('kop_master_peserta')
                ->onDelete('cascade');

            // Setting Waktu & Poin dalam 1 Dekade
            $table->integer('kop_jadwal_arisan_bulan'); // Disimpan sebagai angka (1 = Januari, ..., 12 = Desember)
            $table->year('kop_jadwal_arisan_tahun');    // Tahun penempatan (misal: 2026 s/d 2035)
            $table->integer('kop_jadwal_arisan_point')->default(1); // Jumlah poin yang diikuti peserta di bulan tersebut

            // Catatan Tambahan (opsional)
            $table->text('kop_jadwal_arisan_keterangan')->nullable();

            $table->timestamps();

            // Mencegah peserta yang sama didaftarkan ganda pada bulan & tahun yang sama di 1 jenis arisan
            $table->unique([
                'id_kop_master_arisan',
                'id_kop_master_peserta',
                'kop_jadwal_arisan_bulan',
                'kop_jadwal_arisan_tahun'
            ], 'unique_peserta_jadwal_arisan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_jadwal_arisan');
    }
}
