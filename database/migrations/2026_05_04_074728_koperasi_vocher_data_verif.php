<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiVocherDataVerif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_vocher_data_verif', function (Blueprint $table) {
             $table->id('id_kop_vocher_data_verif');
            $table->string('kop_vocher_data_verif_code');
            $table->string('kop_vocher_data_code');
            $table->longText('kop_vocher_data_verif_sign');
            $table->dateTime('kop_vocher_data_verif_date');
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
        Schema::dropIfExists('kop_vocher_data_verif');
    }
}
