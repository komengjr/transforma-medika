<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MPayCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_pay_card', function (Blueprint $table) {
            $table->id('id_m_pay_card');
            $table->string('m_pay_card_code')->unique();
            $table->string('m_pay_detail_code');
            $table->string('m_pay_card_name');
            $table->string('m_pay_card_number');
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
        Schema::dropIfExists('m_pay_card');
    }
}
