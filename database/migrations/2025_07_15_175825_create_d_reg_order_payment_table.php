<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_payment', function (Blueprint $table) {
            $table->id('id_d_reg_order_payment');
            $table->string('d_reg_order_payment_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('d_reg_order_list_code');
            $table->string('d_reg_order_payment_date');
            $table->string('d_reg_order_payment_user');
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
        Schema::dropIfExists('d_reg_order_payment');
    }
}
