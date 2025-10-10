<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MPayDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_pay_detail', function (Blueprint $table) {
            $table->id('id_m_pay_detail');
            $table->string('m_pay_detail_code')->unique();
            $table->string('m_pay_code');
            $table->string('m_pay_detail_name');
            $table->string('m_pay_detail_type');
            $table->string('m_pay_detail_status');
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
        Schema::dropIfExists('m_pay_detail');
    }
}
