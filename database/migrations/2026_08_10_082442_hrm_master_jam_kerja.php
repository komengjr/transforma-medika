<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmMasterJamKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_master_jam_kerja', function (Blueprint $table) {
            $table->id('id_hrm_m_jam_kerja');
            $table->string('hrm_m_jam_kerja_code', 50)->unique();
            $table->string('hrm_m_jam_kerja_name', 100); // Misal: "Shift Regular", "Shift Malam"
            $table->time('hrm_m_jam_kerja_in');          // Misal: "08:00:00"
            $table->time('hrm_m_jam_kerja_out');         // Misal: "17:00:00"
            $table->json('hrm_m_jam_kerja_days_off')->nullable(); // Misal simpan hari libur: ["Minggu", "Sabtu"]
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
        Schema::dropIfExists('hrm_master_jam_kerja');
    }
}
