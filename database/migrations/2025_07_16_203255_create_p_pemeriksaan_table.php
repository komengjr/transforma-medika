<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePPemeriksaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_pemeriksaan', function (Blueprint $table) {
            $table->id('id_p_pemeriksaan');
            $table->string('p_pemeriksaan_code')->unique();
            $table->string('p_m_pemeriksaan_code');
            $table->string('p_pemeriksaan_name');
            $table->string('p_pemeriksaan_type');
            $table->string('p_pemeriksaan_status');
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
        Schema::dropIfExists('p_pemeriksaan');
    }
}
