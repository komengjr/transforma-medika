<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePPemeriksaanDataSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_pemeriksaan_data_sub', function (Blueprint $table) {
            $table->id('id_p_pemeriksaan_data_sub');
            $table->string('p_pemeriksaan_data_sub_code')->unique();
            $table->string('p_pemeriksaan_data_code');
            $table->string('p_pemeriksaan_data_name');
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
        Schema::dropIfExists('p_pemeriksaan_data_sub');
    }
}
