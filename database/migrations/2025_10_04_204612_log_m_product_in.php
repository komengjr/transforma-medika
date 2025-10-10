<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogMProductIn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_m_product_in', function (Blueprint $table) {
            $table->id('id_log_m_product_in');
            $table->string('log_m_product_in_code')->unique();
            $table->string('schedule_product_code');
            $table->string('pem_pr_order_datas_code');
            $table->date('log_m_product_in_date');
            $table->string('log_m_product_in_status');
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
        Schema::dropIfExists('log_m_product_in');
    }
}
