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
        Schema::create('brain_test_klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_klasifikasi'); // Contoh: Tes CPNS, Tes BUMN, Tes IQ Umum
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
        Schema::create('brain_test_kategori', function (Blueprint $table) {
            $table->id();
            // Relasi ke Klasifikasi (Contoh: BUMN -> Kategori Matematika / Core Values)
            $table->foreignId('klasifikasi_id')->constrained('brain_test_klasifikasi')->onDelete('cascade');
            $table->string('nama_kategori'); // Contoh: Matematika, TWK, Logika Penalaran
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
        Schema::create('brain_test_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('brain_test_kategori')->onDelete('cascade');
            $table->text('pertanyaan'); // Bisa teks biasa atau format HTML/gambar
            $table->string('gambar')->nullable(); // Jika soal menggunakan gambar pendukung

            // Mendukung pilihan ganda dan isian
            $table->enum('tipe_soal', ['pilihan_ganda', 'isian']);

            // Khusus untuk soal isian (kunci jawaban berupa teks/angka)
            $table->text('kunci_jawaban_isian')->nullable();

            $table->integer('bobot_nilai')->default(1);
            $table->text('pembahasan')->nullable();
            $table->timestamps();
        });
        Schema::create('brain_test_opsi_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soal_id')->constrained('brain_test_soal')->onDelete('cascade');
            $table->text('teks_jawaban'); // Pilihan A, B, C, D, E
            $table->string('gambar')->nullable();
            $table->boolean('is_benar')->default(false); // Penanda apakah ini jawaban yang benar
            $table->integer('poin')->default(0); // Berguna untuk tes skala seperti TKP BUMN/CPNS
            $table->timestamps();
        });
        Schema::create('brain_test_sesi_responden', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke Klasifikasi atau Kategori tes yang sedang dikerjakan
            $table->foreignId('klasifikasi_id')->constrained('brain_test_klasifikasi')->onDelete('cascade');

            // Identitas responden tanpa login
            $table->string('nama_responden');
            $table->string('email_atau_hp')->nullable();
            $table->string('asal_instansi')->nullable(); // Contoh: Universitas X / Umum
            $table->string('token_sesi')->unique(); // Token unik untuk keamanan akses ujian

            // Status dan Hasil
            $table->enum('status', ['sedang_mengerjakan', 'selesai'])->default('sedang_mengerjakan');
            $table->integer('total_skor')->default(0);
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
        });
        Schema::create('brain_test_jawaban_responden', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke sesi responden yang sedang aktif
            $table->foreignId('sesi_responden_id')->constrained('brain_test_sesi_responden')->onDelete('cascade');
            // Menghubungkan ke soal yang dikerjakan
            $table->foreignId('soal_id')->constrained('brain_test_soal')->onDelete('cascade');

            // Menyimpan jawaban (bisa ID opsi pilihan ganda atau teks untuk soal isian)
            $table->foreignId('opsi_jawaban_id')->nullable()->constrained('brain_test_opsi_jawaban')->onDelete('set null');
            $table->text('jawaban_isian_teks')->nullable(); // Jika tipe soal adalah isian

            // Status ragu-ragu (sangat berguna untuk tampilan CAT / Ujian)
            $table->boolean('is_ragu')->default(false);

            $table->timestamps();

            // Mencegah duplikasi baris jawaban untuk soal yang sama dalam satu sesi
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
        Schema::dropIfExists('brain_test_klasifikasi');
        Schema::dropIfExists('brain_test_kategori');
        Schema::dropIfExists('brain_test_soal');
        Schema::dropIfExists('brain_test_opsi_jawaban');
        Schema::dropIfExists('brain_test_sesi_responden');
        Schema::dropIfExists('brain_test_jawaban_responden');
    }
}
