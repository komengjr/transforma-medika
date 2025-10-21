<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DRegOrderPoliLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_poli_log', function (Blueprint $table) {
            $table->id('id_order_poli_log');
            $table->string('order_poli_log_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('p_sales_data_code');
            $table->string('order_poli_log_price');
            $table->string('order_poli_log_discount');
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
        Schema::dropIfExists('d_reg_order_poli_log');
    }
}
