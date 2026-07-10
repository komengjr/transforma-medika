<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiVocherData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_vocher_data', function (Blueprint $table) {
            $table->id('id_vocher_data');
            $table->string('kop_vocher_data_code')->unique();
            $table->string('kop_vocher_data_token')->unique();
            $table->string('kop_master_peserta_code');
            $table->string('kop_vocher_cat_code');
            $table->integer('kop_vocher_data_nominal');
            $table->integer('kop_vocher_data_admin');
            $table->string('kop_vocher_data_number_id');
            $table->string('kop_vocher_data_ketua');
            $table->date('kop_vocher_data_date_start');
            $table->date('kop_vocher_data_date_end');
            $table->string('kop_vocher_data_cabang');
            $table->string('kop_vocher_data_status');
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
        Schema::dropIfExists('kop_vocher_data');
    }
}
