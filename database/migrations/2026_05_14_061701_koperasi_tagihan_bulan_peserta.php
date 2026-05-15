<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiTagihanBulanPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_tagihan_bulan_peserta', function (Blueprint $table) {
            $table->id('id_kop_tagihan_bulan_peserta');
            $table->string('kop_tagihan_bulan_peserta_code')->unique();
            $table->string('kop_tagihan_bulan_code');
            $table->string('kop_master_peserta_code');
            $table->integer('kop_tagihan_bulan_peserta_pokok');
            $table->integer('kop_tagihan_bulan_peserta_bunga');
            $table->integer('kop_tagihan_bulan_peserta_nominal');
            $table->date('kop_tagihan_bulan_peserta_date');
            $table->string('kop_tagihan_bulan_peserta_status');
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
        Schema::dropIfExists('kop_tagihan_bulan_peserta');
    }
}
