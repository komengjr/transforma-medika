<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmPegawaiKomponen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_pegawai_komponen', function (Blueprint $table) {
            $table->id();
            $table->string('hrm_m_pegawai_code');
            $table->unsignedBigInteger('id_komponen');
            $table->decimal('nominal', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('hrm_m_pegawai_code')
                ->references('hrm_m_pegawai_code')
                ->on('hrm_master_pegawai')
                ->onDelete('cascade');

            $table->foreign('id_komponen')
                ->references('id_komponen')
                ->on('hrm_komponen_gaji')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_pegawai_komponen');
    }
}
