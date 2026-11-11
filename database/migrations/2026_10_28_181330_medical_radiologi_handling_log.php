<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalRadiologiHandlingLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_radiologi_handling_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_detail_id')->constrained('medical_transaksi_detail')->onDelete('cascade');
            $table->string('order_rad_list_code')->index();

            // Petugas / Radiografer
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_petugas')->nullable();

            // Tracking Waktu
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->integer('durasi_pengerjaan_menit')->default(0);

            // Status & Catatan Petugas
            $table->enum('status_handling', ['PENDING', 'DIPROSES', 'SELESAI', 'REVISI'])->default('PENDING');
            $table->text('catatan_petugas')->nullable();

            // Field Opsional Tambahan untuk PACS
            $table->string('orthanc_study_id')->nullable()->comment('ID Study dari Orthanc jika citra DICOM sudah dikirim');

            $table->timestamps();
        });
        Schema::create('medical_radiologi_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_detail_id')->constrained('medical_transaksi_detail')->onDelete('cascade');
            $table->string('order_rad_list_code')->index();

            // Integrasi Orthanc / PACS DICOM Viewer
            $table->string('pacs_study_uid')->nullable()->comment('UID / ID Study DICOM Orthanc');

            // Metadata Dokter & Verifikasi
            $table->unsignedBigInteger('dokter_id')->nullable()->comment('ID Dokter dari tabel users/master_doctor');
            $table->string('dokter_radiolog')->nullable();
            $table->dateTime('tanggal_pemeriksaan')->nullable();
            $table->dateTime('tanggal_verifikasi')->nullable();
            $table->enum('status_verifikasi', ['DRAFT', 'VERIFIED', 'REVISI'])->default('DRAFT');

            // Struktur Utama Laporan Radiologi
            $table->text('klinis_indikasi')->nullable()->comment('Indikasi / Keluhan Klinis Pasien');
            $table->text('teknik_pemeriksaan')->nullable()->comment('Proyeksi / Potongan Foto Radiologi');
            $table->longText('kesan_kesimpulan')->nullable()->comment('Kesan / Kesimpulan Utama Dokter (Sangat Krusial)');
            $table->text('saran')->nullable()->comment('Saran Pemeriksaan Lanjutan jika ada');

            // Critical Value Alert
            $table->boolean('is_critical_value')->default(false)->comment('Flag jika ada hasil kritis yang butuh penanganan cepat');

            $table->timestamps();
        });
        Schema::create('medical_radiologi_hasil_detail', function (Blueprint $table) {
            $table->id();
            // Berelasi ke Header Ekspertise Radiologi
            $table->foreignId('radiologi_hasil_id')->constrained('medical_radiologi_hasil')->onDelete('cascade');

            $table->string('parameter_code')->default('DEFAULT');
            $table->string('nama_parameter')->comment('Contoh: Cor, Pulmo, Sinus, Abdomen, dll');
            $table->longText('nilai_hasil')->nullable()->comment('Deskripsi deskriptif parameter');
            $table->string('satuan')->nullable();
            $table->string('nilai_rujukan')->nullable();

            $table->timestamps();
        });
        Schema::create('medical_master_pemeriksaan_parameter', function (Blueprint $table) {
            $table->id();

            // 1. Buat kolomnya terlebih dahulu
            $table->unsignedBigInteger('master_pemeriksaan_id');

            // 2. Relasi ke tabel Master Layanan/Pemeriksaan dengan nama constraint custom yang lebih pendek
            $table->foreign('master_pemeriksaan_id', 'fk_master_pem_param')
                ->references('id')
                ->on('medical_master_pemeriksaan')
                ->onDelete('cascade');

            // Kode unik parameter (Misal: PARAM-COR-01, PARAM-PULMO-01)
            $table->string('kode_parameter')->index();

            // Nama organ / parameter yang diperiksa (Misal: Cor, Pulmo, Sinus, Ginjal Kanan)
            $table->string('nama_parameter');

            // Pengaturan UI Form (text, textarea, select, dsb)
            $table->enum('tipe_input', ['text', 'textarea', 'select', 'number'])->default('textarea');

            // Jika tipe_input = 'select', simpan opsi dipisah koma (Misal: "Normal, Kardiomegali, Efusi Pleura")
            $table->text('opsi_input')->nullable();

            // Pengaturan tinggi kotak teks di UI (bila textarea)
            $table->integer('baris_textarea')->default(3)->comment('Jumlah baris textarea di layar');

            // Satuan dan Nilai Normal (Opsional, lebih sering dipakai di Lab, tapi kadang Radiologi butuh untuk ukuran organ)
            $table->string('satuan')->nullable()->comment('Misal: cm, mm');
            $table->string('nilai_rujukan')->nullable()->comment('Misal: < 2 cm');

            // Urutan tampil di form
            $table->integer('urutan')->default(1)->comment('Urutan parameter di form ekspertise');

            // Status aktif
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('medical_radiologi_handling_log');
        Schema::dropIfExists('medical_radiologi_hasil');
        Schema::dropIfExists('medical_radiologi_hasil_detail');
        Schema::dropIfExists('medical_master_pemeriksaan_parameter');
    }
}
