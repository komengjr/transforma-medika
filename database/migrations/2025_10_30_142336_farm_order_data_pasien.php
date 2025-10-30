<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmOrderDataPasien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_order_data_pasien', function (Blueprint $table) {
            $table->id('id_farm_order_data_pasien');
            $table->string('farm_order_data_pasien_code')->unique();
            $table->string('farm_order_data_code');
            $table->string('farm_order_data_pasien_name');
            $table->date('farm_order_data_pasien_date');
            $table->string('farm_order_data_pasien_no');
            $table->string('farm_order_data_pasien_doctor');
            $table->text('farm_order_data_pasien_desc')->nullable();
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
        Schema::dropIfExists('farm_order_data_pasien');
    }
}
