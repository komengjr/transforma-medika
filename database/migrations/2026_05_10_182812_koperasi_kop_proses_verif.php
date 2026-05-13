<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiKopProsesVerif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_proses_verif', function (Blueprint $table) {
            $table->id('id_kop_proses_verif');
            $table->string('kop_proses_verif_code')->unique();
            $table->string('kop_proses_uang_code');
            $table->string('kop_proses_verif_user');
            $table->string('kop_proses_verif_status');
            $table->longText('kop_proses_verif_sign')->nullable();
            $table->dateTime('kop_proses_verif_date')->nullable();
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
        Schema::dropIfExists('kop_proses_verif');
    }
}
