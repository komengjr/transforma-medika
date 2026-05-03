<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiSetupCabangKoperasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_setup_cabang_koperasi', function (Blueprint $table) {
            $table->id('id_kop_setup_cabang_koperasi');
            $table->string('kop_setup_cabang_koperasi_code')->unique();
            $table->integer('kop_setup_cabang_koperasi_jp_brg');
            $table->integer('kop_setup_cabang_koperasi_jp_uang');
            $table->integer('kop_setup_cabang_koperasi_tenor_brg');
            $table->integer('kop_setup_cabang_koperasi_tenor_uang');
            $table->integer('kop_setup_cabang_koperasi_bunga');
            $table->integer('kop_setup_cabang_koperasi_admin');
            $table->integer('kop_setup_cabang_koperasi_wa');
            $table->integer('kop_setup_cabang_koperasi_email');
            $table->integer('kop_setup_cabang_koperasi_status');
            $table->string('kop_setup_cabang_koperasi_cabang');
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
        Schema::dropIfExists('kop_setup_cabang_koperasi');
    }
}
