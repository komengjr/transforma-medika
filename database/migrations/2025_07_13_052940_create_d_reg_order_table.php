<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order', function (Blueprint $table) {
            $table->id('id_d_reg_order');
            $table->string('d_reg_order_code')->unique();
            $table->string('d_reg_order_rm');
            $table->date('d_reg_order_date');
            $table->string('t_layanan_cat_code');
            $table->string('t_pasien_cat_code');
            $table->string('d_reg_order_status');
            $table->string('d_reg_order_user');
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
        Schema::dropIfExists('d_reg_order');
    }
}
