<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiLogPeminjamanUang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_log_peminjaman_uang', function (Blueprint $table) {
            $table->id('id_kop_log_peminjaman_uang');
            $table->string('kop_log_peminjaman_uang_code')->unique();
            $table->string('kop_proses_uang_code');
            $table->integer('kop_log_peminjaman_uang_tenor');
            $table->integer('kop_log_peminjaman_uang_pokok');
            $table->integer('kop_log_peminjaman_uang_bunga');
            $table->integer('kop_log_peminjaman_uang_nominal');
            $table->date('kop_log_peminjaman_uang_date');
            $table->string('kop_log_peminjaman_uang_cat');
            $table->string('kop_log_peminjaman_uang_token');
            $table->string('kop_log_peminjaman_uang_status');
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
        Schema::dropIfExists('kop_log_peminjaman_uang');
    }
}
