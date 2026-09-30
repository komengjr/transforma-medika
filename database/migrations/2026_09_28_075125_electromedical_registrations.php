<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ElectromedicalRegistrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tabel Pendaftaran Elektromedis
        if (!Schema::hasTable('medical_electromedical_reg')) {
            Schema::create('medical_electromedical_reg', function (Blueprint $table) {
                $table->id();
                $table->string('registration_number')->unique();
                $table->string('medical_record_number');
                $table->string('patient_name');
                $table->string('origin_unit');
                $table->string('examination_type'); // Contoh: ECG, EEG, Treadmill, dll
                $table->dateTime('scheduled_at');
                $table->string('status', 50)->default('Terdaftar'); // Diperbesar ke VARCHAR(50)
                $table->timestamps();
            });
        } else {
            // Pastikan kolom status cukup panjang jika tabel sudah terlanjur ada
            DB::statement("ALTER TABLE medical_electromedical_reg MODIFY COLUMN status VARCHAR(50) DEFAULT 'Terdaftar';");
        }

        // 2. Tabel Hasil Detail Pemeriksaan ECG
        if (!Schema::hasTable('medical_ecg_results')) {
            Schema::create('medical_ecg_results', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('registration_id');
                $table->string('heart_rate')->nullable();
                $table->string('rhythm')->nullable();
                $table->string('axis')->nullable();
                $table->string('pr_interval')->nullable();
                $table->string('qrs_complex')->nullable();
                $table->string('st_segment')->nullable();
                $table->string('t_wave')->nullable();
                $table->text('clinical_impression')->nullable();
                $table->text('doctor_notes')->nullable();
                $table->timestamps();

                // Foreign key opsional (bisa diaktifkan jika relasi ketat)
                // $table->foreign('registration_id')->references('id')->on('medical_electromedical_reg')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_ecg_results');
        Schema::dropIfExists('medical_electromedical_reg');
    }
}
