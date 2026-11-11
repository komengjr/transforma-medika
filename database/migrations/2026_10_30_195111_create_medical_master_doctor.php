<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalMasterDoctor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_master_doctor', function (Blueprint $table) {
            $table->id();
            $table->string('kode_dokter', 20)->unique()->comment('Contoh: DR-001');
            $table->string('nama_lengkap')->comment('Nama lengkap beserta gelar, contoh: Dr. Andi Wijaya, Sp.PD');
            $table->enum('jenis_kelamin', ['L', 'P'])->comment('L: Laki-laki, P: Perempuan');
            $table->string('nik', 20)->nullable()->unique()->comment('Nomor Induk Kependudukan');
            $table->string('sip', 50)->nullable()->comment('Nomor Surat Izin Praktik');

            // --- PEMBARUAN: Relasi ke tabel Master Spesialis ---
            $table->string('kode_spesialis', 20)->nullable()->comment('Merujuk ke kode_spesialis di medical_master_spesialis');

            // Kontak Pribadi & Profesional
            $table->string('email')->nullable()->unique();
            $table->string('no_telp', 20)->nullable();
            $table->text('alamat')->nullable();

            // Kolom Foto Dokter
            $table->string('foto')->nullable()->comment('Menyimpan nama file/path foto di storage local/cloud');

            // Status Keaktifan
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('medical_master_spesialis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_spesialis', 20)->unique()->comment('Contoh: SP-001, SP-002');
            $table->string('nama_spesialis')->comment('Contoh: Penyakit Dalam, Anak, Bedah');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('medical_poli_dokter', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Tabel Master Poli
            $table->foreignId('poli_id')
                ->constrained('medical_master_poli')
                ->onDelete('cascade');

            // Foreign Key ke Tabel Master Dokter
            $table->foreignId('doctor_id')
                ->constrained('medical_master_doctor')
                ->onDelete('cascade');

            // Informasi Jadwal & Kapasitas (Opsional tapi sangat berguna untuk sistem rumah sakit/klinik)
            $table->string('hari_praktek', 50)->nullable()->comment('Contoh: Senin, Rabu, Jumat atau Setiap Hari');
            $table->string('jam_praktek', 50)->nullable()->comment('Contoh: 08:00 - 12:00');
            $table->integer('kuota_pasien')->default(50)->comment('Batas maksimal kuota antrean pasien');

            // Status Keaktifan Jadwal/Relasi
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Mencegah duplikasi data mapping yang persis sama
            $table->unique(['poli_id', 'doctor_id']);
        });
        Schema::create('medical_jadwal_igd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('medical_master_doctor')->onDelete('cascade');
            $table->date('tanggal'); // Tanggal bertugas
            $table->enum('shift', ['PAGI', 'SORE', 'MALAM']); // Shift jaga
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('medical_jadwal_dokter', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel Master Poli
            $table->foreignId('poli_id')
                ->constrained('medical_master_poli')
                ->onDelete('cascade');

            // Relasi ke tabel Master Dokter
            $table->foreignId('doctor_id')
                ->constrained('medical_master_doctor')
                ->onDelete('cascade');

            // Detail Jadwal
            $table->string('day_name', 20)->comment('Contoh: Senin, Selasa');
            $table->time('time_start')->comment('Jam mulai praktek');
            $table->time('time_end')->comment('Jam selesai praktek');
            $table->integer('quota')->default(1)->comment('Kuota maksimal pasien');
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
        Schema::dropIfExists('medical_master_doctor');
        Schema::dropIfExists('medical_master_spesialis');
        Schema::dropIfExists('medical_poli_dokter');
        Schema::dropIfExists('medical_jadwal_igd');
        Schema::dropIfExists('medical_jadwal_dokter');
    }
}
