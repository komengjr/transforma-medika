<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmOrderData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_order_data', function (Blueprint $table) {
            $table->id('id_farm_order_data');
            $table->string('farm_order_data_code')->unique();
            $table->string('farm_order_data_date');
            $table->string('farm_order_data_type');
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
        Schema::dropIfExists('farm_order_data');
    }
}
