<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmPengajuanLembur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_pengajuan_lembur', function (Blueprint $table) {
            $table->id('id_hrm_lembur');
            $table->string('hrm_m_pegawai_code', 50);
            $table->date('hrm_lembur_date');
            $table->time('hrm_lembur_start');          // Jam mulai lembur (misal: 17:00)
            $table->time('hrm_lembur_end');            // Jam selesai lembur (misal: 20:00)
            $table->decimal('hrm_lembur_total_hours', 4, 1); // Total jam (misal: 3.0)
            $table->text('hrm_lembur_keterangan');     // Pekerjaan yang dilemburkan
            $table->enum('hrm_lembur_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('approved_by', 50)->nullable();
            $table->timestamps();

            $table->index(['hrm_m_pegawai_code', 'hrm_lembur_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_pengajuan_lembur');
    }
}
