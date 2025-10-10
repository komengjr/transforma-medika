<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogMProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_m_product', function (Blueprint $table) {
            $table->id('id_log_m_product');
            $table->string('log_m_product_code')->unique();
            $table->string('log_m_product_name');
            $table->string('log_m_class_code');
            $table->string('log_m_type_code');
            $table->string('log_m_product_status');
            $table->string('log_m_product_qr');
            $table->text('log_m_product_file')->nullable();
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
        Schema::dropIfExists('log_m_product');
    }
}
