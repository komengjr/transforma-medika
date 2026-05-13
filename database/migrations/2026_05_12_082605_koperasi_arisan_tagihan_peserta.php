<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiArisanTagihanPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_arisan_tagihan_peserta', function (Blueprint $table) {
            $table->id('id_kop_arisan_tagihan_peserta');
            $table->string('id_kop_tagihan_peserta_code')->unique();
            $table->string('kop_arisan_tagihan_code');
            $table->string('kop_arisan_group_user_code');
            $table->string('kop_tagihan_peserta_nominal');
            $table->string('kop_tagihan_peserta_status');
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
        Schema::dropIfExists('kop_arisan_tagihan_peserta');
    }
}
