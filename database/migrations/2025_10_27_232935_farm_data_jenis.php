<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmDataJenis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_data_jenis', function (Blueprint $table) {
            $table->id('id_farm_data_jenis');
            $table->string('farm_data_jenis_code')->unique();
            $table->string('farm_data_jenis_name');
            $table->text('farm_data_jenis_cat');
            $table->text('farm_data_jenis_desc');
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
        Schema::dropIfExists('farm_data_jenis');
    }
}
