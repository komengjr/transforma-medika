<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiLogSimpananSukarela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_log_simpanan_sukarela', function (Blueprint $table) {
            $table->id('id_kop_log_simpanan_sukarela');
            $table->string('kop_log_simpanan_sukarela_code')->unique();
            $table->string('kop_simpanan_sukarela_code');
            $table->integer('kop_log_simpanan_sukarela_pokok');
            $table->integer('kop_log_simpanan_sukarela_bunga');
            $table->integer('kop_log_simpanan_sukarela_nominal');
            $table->date('kop_log_simpanan_sukarela_date');
            $table->string('kop_log_simpanan_sukarela_status');
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
        Schema::dropIfExists('kop_log_simpanan_sukarela');
    }
}
