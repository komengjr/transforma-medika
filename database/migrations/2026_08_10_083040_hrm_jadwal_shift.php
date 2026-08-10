<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmJadwalShift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_jadwal_shift', function (Blueprint $table) {
            $table->id('id_hrm_jadwal_shift');
            $table->string('hrm_m_pegawai_code', 50);
            $table->date('hrm_jadwal_date');
            $table->string('hrm_m_jam_kerja_code', 50); // Menunjuk ke shift mana pada tanggal tersebut
            $table->text('hrm_jadwal_keterangan')->nullable(); // Contoh: "Tukar Shift dengan Budi"
            $table->timestamps();

            $table->unique(['hrm_m_pegawai_code', 'hrm_jadwal_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_jadwal_shift');
    }
}
