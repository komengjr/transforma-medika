<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogMClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_m_class', function (Blueprint $table) {
            $table->id('id_log_m_class');
            $table->string('log_m_class_code')->unique();
            $table->string('log_m_class_name');
            $table->string('log_m_class_status');
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
        Schema::dropIfExists('log_m_class');
    }
}
