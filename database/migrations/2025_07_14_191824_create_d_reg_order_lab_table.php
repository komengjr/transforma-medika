<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_lab', function (Blueprint $table) {
            $table->id('id_d_reg_order_lab');
            $table->string('d_reg_order_lab_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('d_reg_order_lab_date');
            $table->string('d_reg_order_lab_number');
            $table->string('d_reg_order_lab_rujukan');
            $table->string('d_reg_order_lab_status');
            $table->string('d_reg_order_lab_user');
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
        Schema::dropIfExists('d_reg_order_lab');
    }
}
