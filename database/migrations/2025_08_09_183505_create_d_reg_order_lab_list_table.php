<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderLabListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_lab_list', function (Blueprint $table) {
            $table->id('id_d_reg_order_lab_list');
            $table->string('order_lab_list_code')->unique();
            $table->string('d_reg_order_lab_code');
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
        Schema::dropIfExists('d_reg_order_lab_list');
    }
}
