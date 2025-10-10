<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePPemeriksaanDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_pemeriksaan_data', function (Blueprint $table) {
            $table->id('id_p_pemeriksaan_data');
            $table->string('p_pemeriksaan_data_code')->unique();
            $table->string('t_pemeriksaan_cat_code');
            $table->string('p_pemeriksaan_code');
            $table->string('p_pemeriksaan_data_name');
            $table->string('p_pemeriksaan_data_type');
            $table->integer('p_pemeriksaan_data_price');
            $table->text('p_pemeriksaan_data_desc');
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
        Schema::dropIfExists('p_pemeriksaan_data');
    }
}
