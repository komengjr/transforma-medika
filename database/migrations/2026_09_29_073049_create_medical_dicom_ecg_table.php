<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalDicomEcgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_dicom_ecg', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel registrasi elektromedis (sesuaikan tipe datanya jika ID utama berupa unsignedBigInteger/string)
            $table->unsignedBigInteger('registration_id')->nullable();

            // Identitas Pasien
            $table->string('medical_record_number')->index(); // No. Rekam Medis untuk pencarian cepat
            $table->string('patient_name')->nullable();

            // Atribut / Metadata DICOM & Orthanc PACS
            $table->string('study_instance_uid')->unique(); // UID unik studi DICOM dari Orthanc
            $table->string('sop_instance_uid')->nullable(); // UID instance spesifik jika diperlukan
            $table->string('accession_number')->nullable(); // Nomor accession/order dari HIS/RIS

            // URL atau jalur akses ke file/preview
            $table->text('preview_url')->nullable(); // URL gambar preview statis (jika dikonversi ke PNG/JPG)
            $table->text('orthanc_study_uuid')->nullable(); // UUID internal milik Orthanc REST API

            // Keterangan tambahan
            $table->string('modality')->default('ECG'); // Default modalitas ECG
            $table->text('description')->nullable(); // Keterangan studi dari mesin
            $table->timestamp('study_date_time')->nullable(); // Waktu pemeriksaan DICOM diambil

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
        Schema::dropIfExists('medical_dicom_ecg');
    }
}
