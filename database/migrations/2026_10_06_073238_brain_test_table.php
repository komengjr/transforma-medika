<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BrainTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // LEVEL 1: Klasifikasi Utama (Tes CPNS, Tes BUMN, Tes IQ)
        Schema::create('brain_test_klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_klasifikasi'); // Contoh: Tes CPNS, Tes BUMN
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        // LEVEL 2: Master Nama Tes / Paket Ujian (Soal CPNS 2025, Soal CPNS 2026)
        Schema::create('brain_test_paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klasifikasi_id')->constrained('brain_test_klasifikasi')->onDelete('cascade');
            $table->string('nama_test'); // Contoh: Soal CPNS 2025, Simulasi BUMN Batch 1
            $table->string('slug')->unique();
            $table->integer('durasi_menit')->default(60); // Durasi pengerjaan paket tes
            $table->integer('passing_grade')->default(0); // Ambang batas kelulusan keseluruhan (opsional)
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        // LEVEL 3: Kategori Soal di dalam Paket Tes (TIU, TWK, TKP)
        Schema::create('brain_test_kategori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('brain_test_paket')->onDelete('cascade');
            $table->string('nama_kategori'); // Contoh: TIU, TWK, TKP
            $table->string('slug')->unique();
            $table->integer('passing_grade')->default(0); // Passing grade khusus kategori (misal TIU: 80, TWK: 65)
            $table->integer('urutan')->default(1); // Urutan tampil kategori saat ujian
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // LEVEL 4: Bank Soal di dalam Kategori
        Schema::create('brain_test_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('brain_test_kategori')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->string('gambar')->nullable();
            $table->enum('tipe_soal', ['pilihan_ganda', 'isian'])->default('pilihan_ganda');
            $table->text('kunci_jawaban_isian')->nullable();
            $table->integer('bobot_nilai')->default(1);
            $table->text('pembahasan')->nullable();
            $table->timestamps();
        });

        // Opsi Jawaban per Soal
        Schema::create('brain_test_opsi_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soal_id')->constrained('brain_test_soal')->onDelete('cascade');
            $table->text('teks_jawaban');
            $table->string('gambar')->nullable();
            $table->boolean('is_benar')->default(false);
            $table->integer('poin')->default(0); // Sangat penting untuk TKP (skor 1-5)
            $table->timestamps();
        });

        // Sesi Responden (Mengerjakan per Paket Tes)
        Schema::create('brain_test_sesi_responden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('brain_test_paket')->onDelete('cascade');
            $table->string('nama_responden');
            $table->string('email_atau_hp')->nullable();
            $table->string('asal_instansi')->nullable();
            $table->string('token_sesi')->unique();
            $table->enum('status', ['sedang_mengerjakan', 'selesai'])->default('sedang_mengerjakan');
            $table->integer('total_skor')->default(0);
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
        });

        // Detail Jawaban Responden
        Schema::create('brain_test_jawaban_responden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_responden_id')->constrained('brain_test_sesi_responden')->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('brain_test_soal')->onDelete('cascade');
            $table->foreignId('opsi_jawaban_id')->nullable()->constrained('brain_test_opsi_jawaban')->onDelete('set null');
            $table->text('jawaban_isian_teks')->nullable();
            $table->boolean('is_ragu')->default(false);
            $table->timestamps();
            $table->unique(['sesi_responden_id', 'soal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brain_test_jawaban_responden');
        Schema::dropIfExists('brain_test_sesi_responden');
        Schema::dropIfExists('brain_test_opsi_jawaban');
        Schema::dropIfExists('brain_test_soal');
        Schema::dropIfExists('brain_test_kategori');
        Schema::dropIfExists('brain_test_paket');
        Schema::dropIfExists('brain_test_klasifikasi');
    }
}
