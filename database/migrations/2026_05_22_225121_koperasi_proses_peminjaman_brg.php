<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiProsesPeminjamanBrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_proses_peminjaman_brg', function (Blueprint $table) {
            $table->id('id_kop_proses_brg');
            $table->string('kop_proses_brg_code')->unique();
            $table->string('kop_master_peserta_code');
            $table->integer('kop_proses_brg_nominal');
            $table->date('kop_proses_brg_tgl');
            $table->integer('kop_proses_brg_tenor');
            $table->integer('kop_proses_brg_bunga');
            $table->integer('kop_proses_brg_admin');
            $table->string('kop_proses_brg_kacab');
            $table->string('kop_proses_brg_ketua');
            $table->text('kop_proses_brg_keperluan');
            $table->text('kop_proses_brg_file');
            $table->string('kop_proses_brg_user');
            $table->string('kop_proses_brg_status');
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
        Schema::dropIfExists('kop_proses_peminjaman_brg');
    }
}
