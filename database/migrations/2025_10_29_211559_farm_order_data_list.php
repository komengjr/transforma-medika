<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmOrderDataList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_order_data_list', function (Blueprint $table) {
            $table->id('id_farm_order_data_list');
            $table->string('farm_order_data_list_code')->unique();
            $table->string('farm_order_data_code');
            $table->string('farm_data_obat_code');
            $table->string('farm_order_data_list_price');
            $table->string('farm_order_data_list_qty');
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
        Schema::dropIfExists('farm_order_data_list');
    }
}
