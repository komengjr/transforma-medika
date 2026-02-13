<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmPegawaiDesc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_pegawai_desc', function (Blueprint $table) {
            $table->id('id_hrm_pegawai_desc');
            $table->string('hrm_pegawai_desc_code')->unique();
            $table->string('hrm_m_pegawai_code');
            $table->longText('hrm_pegawai_desc_text');
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
        Schema::dropIfExists('hrm_pegawai_desc');
    }
}
