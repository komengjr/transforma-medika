<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogScheduleProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_schedule_product', function (Blueprint $table) {
            $table->id('id_schedule_product');
            $table->string('schedule_product_code')->unique();
            $table->string('schedule_product_name');
            $table->string('schedule_product_date');
            $table->string('schedule_product_by');
            $table->integer('schedule_product_status');
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
        Schema::dropIfExists('log_schedule_product');
    }
}
