<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiPesertaSimpananPokok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_peserta_sim_pok', function (Blueprint $table) {
            $table->id('id_kop_peserta_sim_pok');
            $table->string('kop_peserta_sim_pok_code')->unique();
            $table->string('kop_master_peserta_code');
            $table->string('kop_simpanan_pokok_code');
            $table->date('kop_peserta_sim_pok_date');
            $table->string('kop_peserta_sim_pok_status');
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
        Schema::dropIfExists('kop_peserta_sim_pok');
    }
}
