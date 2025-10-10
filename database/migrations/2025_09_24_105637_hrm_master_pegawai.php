<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmMasterPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_master_pegawai', function (Blueprint $table) {
            $table->id('id_hrm_m_pegawai');
            $table->string('hrm_m_pegawai_code')->unique();
            $table->string('hrm_m_pegawai_nip')->unique();
            $table->string('hrm_m_pegawai_nik')->unique();
            $table->string('hrm_m_pegawai_name');
            $table->date('hrm_master_pegawai_dob');
            $table->string('hrm_master_pegawai_dop');
            $table->string('hrm_m_pegawai_agama');
            $table->string('hrm_m_pegawai_sex');
            $table->string('hrm_m_pegawai_hp');
            $table->string('hrm_m_pegawai_email');
            $table->string('hrm_m_position_code');
            $table->string('hrm_m_position_loc');
            $table->text('hrm_m_pegawai_address');
            $table->text('hrm_m_pegawai_img')->nullable();
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
        Schema::dropIfExists('hrm_master_pegawai');
    }
}
