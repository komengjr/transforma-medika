<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_absensi', function (Blueprint $table) {
            $table->id('id_hrm_absensi');
            $table->string('hrm_absensi_code', 50)->unique();
            $table->string('hrm_m_pegawai_code', 50);
            $table->date('hrm_absensi_date');

            // Waktu Masuk & Keluar
            $table->dateTime('hrm_absensi_in')->nullable();
            $table->dateTime('hrm_absensi_out')->nullable();
            $table->string('hrm_absensi_shift_code', 50)->nullable();

            // Tracking Lokasi (GPS) & Bukti Foto
            $table->string('hrm_absensi_lat_in', 50)->nullable();
            $table->string('hrm_absensi_long_in', 50)->nullable();
            $table->string('hrm_absensi_photo_in')->nullable();
            $table->string('hrm_absensi_lat_out', 50)->nullable();
            $table->string('hrm_absensi_long_out', 50)->nullable();
            $table->string('hrm_absensi_photo_out')->nullable();

            // Kalkulasi Keterlambatan & Jam Kerja
            $table->unsignedInteger('hrm_absensi_late_minutes')->default(0);
            $table->unsignedInteger('hrm_absensi_early_leave_minutes')->default(0);
            $table->decimal('hrm_absensi_overtime_hours', 4, 2)->default(0.00);
            $table->decimal('hrm_absensi_work_hours', 4, 2)->default(0.00);

            // Status Kehadiran
            $table->enum('hrm_absensi_status', [
                'hadir',
                'terlambat',
                'dinas_luar',
                'izin',
                'sakit',
                'cuti',
                'alpa'
            ])->default('hadir');

            $table->text('hrm_absensi_notes')->nullable();

            $table->timestamps();

            // Indexing agar query cepat
            $table->index(['hrm_m_pegawai_code', 'hrm_absensi_date']);
            $table->index(['hrm_absensi_status', 'hrm_absensi_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_absensi');
    }
}
