<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderPoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_poli', function (Blueprint $table) {
            $table->id('id_d_reg_order_poli');
            $table->string('d_reg_order_poli_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('m_doctor_poli_code');
            $table->date('d_reg_order_poli_date');
            $table->string('d_reg_order_poli_number');
            $table->string('d_reg_order_poli_status');
            $table->string('d_reg_order_poli_user');
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
        Schema::dropIfExists('d_reg_order_poli');
    }
}
