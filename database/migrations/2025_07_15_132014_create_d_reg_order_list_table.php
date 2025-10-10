<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_list', function (Blueprint $table) {
            $table->id('id_d_reg_order_list');
            $table->string('d_reg_order_list_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('t_layanan_cat_code');
            $table->string('d_reg_order_list_date');
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
        Schema::dropIfExists('d_reg_order_list');
    }
}
