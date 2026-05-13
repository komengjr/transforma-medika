<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiLogVocher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_log_vocher', function (Blueprint $table) {
            $table->id('id_kop_log_vocher');
            $table->string('kop_log_vocher_code')->unique();
            $table->string('kop_vocher_data_code');
            $table->string('kop_log_vocher_pokok');
            $table->string('kop_log_vocher_bunga');
            $table->string('kop_log_vocher_nominal');
            $table->string('kop_log_vocher_date');
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
        Schema::dropIfExists('kop_log_vocher');
    }
}
