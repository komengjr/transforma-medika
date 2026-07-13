<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopLogPeminjamanBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_log_peminjaman_barang', function (Blueprint $table) {
            $table->id('id_kop_log_peminjaman_brg');
            $table->string('kop_log_peminjaman_barang_code')->unique();
            $table->string('kop_proses_brg_code');
            $table->integer('kop_log_peminjaman_brg_tenor');
            $table->integer('kop_log_peminjaman_brg_pokok');
            $table->integer('kop_log_peminjaman_brg_bunga');
            $table->integer('kop_log_peminjaman_brg_nominal');
            $table->date('kop_log_peminjaman_brg_date');
            $table->string('kop_log_peminjaman_brg_cat');
            $table->string('kop_log_peminjaman_brg_token');
            $table->string('kop_log_peminjaman_brg_status');
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
        Schema::dropIfExists('kop_log_peminjaman_barang');
    }
}
