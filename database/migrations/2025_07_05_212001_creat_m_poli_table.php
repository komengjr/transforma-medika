<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatMPoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_poli', function (Blueprint $table) {
            $table->id('id_m_poli');
            $table->string('m_poli_code')->unique();
            $table->string('m_poli_name');
            $table->string('m_poli_type');
            $table->string('m_poli_status');
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
        Schema::dropIfExists('m_poli');
    }
}
