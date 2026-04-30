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
        Schema::create('kop_proses_penyimpanan_uang', function (Blueprint $table) {
            $table->id('id_kop_proses_penyimpanan_uang');
            $table->string('kop_proses_penyimpanan_uang_code')->unique();
            $table->string('kop_master_peserta_code');
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
