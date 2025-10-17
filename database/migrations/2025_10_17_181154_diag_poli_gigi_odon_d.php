<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiagPoliGigiOdonD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_poli_gigi_odon_d', function (Blueprint $table) {
            $table->id('id_diag_poli_gigi_odon_d');
            $table->string('diag_poli_gigi_odon_code');
            $table->string('diag_poli_gigi_odon_desc');
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
        Schema::dropIfExists('diag_poli_gigi_odon_d');
    }
}
