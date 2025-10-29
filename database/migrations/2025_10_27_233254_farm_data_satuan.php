<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmDataSatuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_data_satuan', function (Blueprint $table) {
            $table->id('id_farm_data_satuan');
            $table->string('farm_data_satuan_code')->unique();
            $table->string('farm_data_satuan_name');
            $table->string('farm_data_satuan_jenis');
            $table->text('farm_data_satuan_desc');
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
        Schema::dropIfExists('farm_data_satuan');
    }
}
