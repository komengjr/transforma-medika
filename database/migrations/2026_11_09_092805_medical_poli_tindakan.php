<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalPoliTindakan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_poli_soap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');

            // SOAP Standar
            $table->text('subjektif')->nullable();
            $table->text('objektif')->nullable();
            $table->text('asesmen')->nullable(); // Bisa berisi diagnosa teks atau ringkasan
            $table->text('planning')->nullable();

            // KOLOM DINAMIS TAMBAHAN (Menyimpan data spesifik poli dalam bentuk JSON)
            // Contoh: Data odontogram gigi, visus mata, atau data kehamilan (HPHT/HPL)
            $table->json('data_spesifik_poli')->nullable();

            $table->string('input_by')->nullable();
            $table->string('dokter_verifikasi_kode')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
        Schema::create('medical_poli_tindakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');
            $table->unsignedBigInteger('master_pemeriksaan_id');
            $table->decimal('tarif', 15, 2)->default(0);
            $table->integer('jumlah')->default(1);
            $table->string('input_by')->nullable();
            $table->string('dokter_verifikasi_kode')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->timestamps();

            // Opsional foreign key jika master pemeriksaan sudah ada
            // $table->foreign('master_pemeriksaan_id')->references('id')->on('medical_master_pemeriksaan')->onDelete('cascade');
        });
        Schema::create('medical_poli_resep', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');

            // Relasi ke Nota/Transaksi Kasir
            $table->foreignId('transaksi_id')->nullable()
                ->constrained('medical_transaksi')
                ->onDelete('set null')
                ->comment('ID Nota/Transaksi saat resep ini dilunasi');

            $table->string('farm_data_obat_code');
            $table->integer('qty')->default(1);
            $table->string('signa')->nullable();
            $table->decimal('harga', 12, 2)->default(0);
            $table->string('input_by')->nullable();

            $table->string('dokter_verifikasi_kode')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');

            // Tracking Pembayaran Farmasi
            $table->enum('status_pembayaran', ['BELUM LUNAS', 'LUNAS', 'REFUND'])
                ->default('BELUM LUNAS')
                ->comment('Melacak apakah obat ini sudah dibayar di kasir');

            $table->dateTime('waktu_bayar')->nullable();
            $table->timestamps();
        });
        Schema::create('medical_poli_vital_sign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');

            // Parameter Vital Sign & Fisik Umum
            $table->string('kesadaran', 50)->default('Compos Mentis');
            $table->string('tekanan_darah', 20)->nullable()->comment('Contoh: 120/80 mmHg');
            $table->integer('nadi')->nullable()->comment('x/menit');
            $table->decimal('suhu', 4, 1)->nullable()->comment('Celsius');
            $table->integer('pernapasan')->nullable()->comment('Respiration Rate x/menit');
            $table->integer('saturasi_o2')->nullable()->comment('SpO2 %');
            $table->decimal('berat_badan', 5, 2)->nullable()->comment('kg');
            $table->decimal('tinggi_badan', 5, 2)->nullable()->comment('cm');
            $table->text('pemeriksaan_fisik_lain')->nullable()->comment('Catatan fisik kepala, thorax, abdomen, ekstremitas');

            $table->string('input_by')->nullable();
            $table->timestamps();
        });
        Schema::create('medical_poli_anamnesa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');

            // Detail Anamnesa yang Lebih Lengkap
            $table->text('keluhan_utama')->nullable();
            $table->text('riwayat_penyakit_sekarang')->nullable();
            $table->text('riwayat_penyakit_dahulu')->nullable()->comment('Contoh: Hipertensi, Diabetes, Asma');
            $table->text('riwayat_penyakit_keluarga')->nullable();
            $table->text('riwayat_alergi')->nullable()->comment('Alergi obat, makanan, dll');
            $table->text('riwayat_penggunaan_obat')->nullable()->comment('Obat yang sedang dikonsumsi');

            $table->string('input_by')->nullable();
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
        Schema::dropIfExists('medical_poli_soap');
        Schema::dropIfExists('medical_poli_tindakan');
        Schema::dropIfExists('medical_poli_resep');
        Schema::dropIfExists('medical_poli_vital_sign');
        Schema::dropIfExists('medical_poli_anamnesa');
    }
}
