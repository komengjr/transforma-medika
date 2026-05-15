<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiTagihanBulan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_tagihan_bulan', function (Blueprint $table) {
            $table->id('id_kop_tagihan_bulan');
            $table->string('kop_tagihan_bulan_code')->unique();
            $table->date('kop_tagihan_bulan_date');
            $table->integer('kop_tagihan_bulan_pokok');
            $table->integer('kop_tagihan_bulan_bunga');
            $table->integer('kop_tagihan_bulan_nominal');
            $table->integer('kop_tagihan_bulan_peserta');
            $table->string('kop_tagihan_bulan_cabang');
            $table->integer('kop_tagihan_bulan_status');
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
        Schema::dropIfExists('kop_tagihan_bulan');
    }
}
