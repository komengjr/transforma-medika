<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiProsesPeminjamanUang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_proses_peminjaman_uang', function (Blueprint $table) {
            $table->id('id_kop_proses_uang');
            $table->string('kop_proses_uang_code')->unique();
            $table->string('kop_master_peserta_code');
            $table->integer('kop_proses_uang_nominal');
            $table->date('kop_proses_uang_tgl');
            $table->integer('kop_proses_uang_tenor');
            $table->integer('kop_proses_uang_bunga');
            $table->integer('kop_proses_uang_admin');
            $table->string('kop_proses_uang_kacab');
            $table->string('kop_proses_uang_ketua');
            $table->string('kop_proses_uang_user');
            $table->string('kop_proses_uang_status');
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
        Schema::dropIfExists('kop_proses_penyimpanan_uang');
    }
}
