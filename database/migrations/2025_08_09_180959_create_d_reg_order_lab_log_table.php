<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderLabLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_lab_log', function (Blueprint $table) {
            $table->id('id_order_lab_log');
            $table->string('order_lab_log_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('p_sales_data_code');
            $table->integer('order_lab_log_price');
            $table->integer('order_lab_log_discount');
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
        Schema::dropIfExists('d_reg_order_lab_log');
    }
}
