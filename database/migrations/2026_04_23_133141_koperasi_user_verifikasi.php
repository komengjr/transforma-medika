<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiUserVerifikasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_user_verifikasi', function (Blueprint $table) {
            $table->id('id_kop_user_verifikasi');
            $table->string('kop_user_verifikasi_code')->unique();
            $table->string('kop_user_verifikasi_name');
            $table->string('kop_user_verifikasi_email');
            $table->string('kop_user_verifikasi_whatsapp');
            $table->string('kop_user_verifikasi_job');
            $table->string('kop_user_verifikasi_cabang');
            $table->string('kop_user_verifikasi_status');
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
        Schema::dropIfExists('kop_user_verifikasi');
    }
}
