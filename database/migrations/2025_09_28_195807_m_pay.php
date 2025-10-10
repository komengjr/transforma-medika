<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MPay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_pay', function (Blueprint $table) {
            $table->id('id_m_pay');
            $table->string('m_pay_code')->unique();
            $table->string('m_pay_name');
            $table->string('m_pay_type');
            $table->string('m_pay_status');
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
        Schema::dropIfExists('m_pay');
    }
}
