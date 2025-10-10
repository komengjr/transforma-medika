<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderRadListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_rad_list', function (Blueprint $table) {
            $table->id('id_d_reg_order_rad_list');
            $table->string('order_rad_list_code')->unique();
            $table->string('d_reg_order_rad_code');
            $table->string('p_sales_data_code');
            $table->integer('order_rad_log_price');
            $table->integer('order_rad_log_discount');
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
        Schema::dropIfExists('d_reg_order_rad_list');
    }
}
