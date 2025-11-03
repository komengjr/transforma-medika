<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DRegOrderReject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_reject', function (Blueprint $table) {
            $table->id('id_d_reg_order_reject');
            $table->string('d_reg_order_reject_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('d_reg_order_reject_user');
            $table->date('d_reg_order_reject_date');
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
        Schema::dropIfExists('d_reg_order_reject');
    }
}
