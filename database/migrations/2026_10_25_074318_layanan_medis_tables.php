<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LayananMedisTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Table Penjamin Utama
        Schema::create('medical_penjamin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penjamin');
            $table->timestamps();
        });
        // 2. Table Sub Penjamin
        Schema::create('medical_sub_penjamin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjamin_id')->constrained('medical_penjamin')->onDelete('cascade');
            $table->string('nama_sub_penjamin');
            $table->timestamps();
        });
        // 3. Table Master Tipe Layanan
        Schema::create('medical_tipe_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tipe'); // Contoh: Laboratorium, Radiologi, Fisioterapi
            $table->string('prefix', 5)->comment('Contoh: LAB, RAD, FIS');
            $table->boolean('is_active')->default(true)->comment('Status aktif/nonaktif');
            $table->timestamps();
        });
        // 4. Table Master Pemeriksaan (PERUBAHAN DARI medical_pemeriksaan)
        Schema::create('medical_master_pemeriksaan', function (Blueprint $table) {
            $table->id();
            // Relasi ke tipe layanan (sub_penjamin_id dihilangkan dari master)
            $table->foreignId('tipe_layanan_id')->constrained('medical_tipe_layanan')->onDelete('cascade');

            // Mencegah duplikasi kode layanan
            $table->string('kode_layanan')->unique();
            $table->string('nama_layanan');
            $table->text('deskripsi')->nullable()->comment('Opsional: Penjelasan persiapan pasien, misal: Puasa 10 Jam');

            // --- [REKOMENDASI TAMBAHAN] ---
            // 1. Integrasi & Operasional Radiologi/Lab
            $table->string('modality_code', 10)->nullable()->comment('Kode DICOM Modality (CR, DX, CT, US, MR, dll)');
            $table->string('jenis_sampel')->nullable()->comment('Khusus Lab: Darah EDTA, Urine, Serum, dll');

            // 2. Manajemen Antrean & Medikolegal
            $table->integer('estimasi_waktu_menit')->default(15)->comment('Estimasi lama tindakan/pemeriksaan');
            $table->boolean('is_consent_required')->default(false)->comment('Butuh TTD Informed Consent? (Misal: CT Kontras)');
            // ------------------------------

            // Pricing
            $table->decimal('harga', 15, 2); // Harga dasar (Master Price)

            $table->boolean('is_paket')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('medical_paket_detail', function (Blueprint $table) {
            $table->id();
            // ID Paket (Mengambil dari tabel master pemeriksaan yang is_paket = true)
            $table->foreignId('paket_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');

            // ID Pemeriksaan di dalam paket (Mengambil dari tabel master pemeriksaan)
            $table->foreignId('pemeriksaan_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');

            $table->timestamps();
        });
        // 5. Table Penjamin Pemeriksaan / Mapping Tarif & Diskon (BARU)
        Schema::create('medical_penjamin_pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_penjamin_id')->constrained('medical_sub_penjamin')->onDelete('cascade');
            $table->foreignId('master_pemeriksaan_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');

            // Field Diskon (Nominal potongan harga spesifik untuk sub penjamin ini)
            $table->decimal('diskon', 15, 2)->default(0);

            // Opsional: Jika diskon berupa persen, Anda bisa menggunakan ini juga:
            // $table->decimal('persentase_diskon', 5, 2)->default(0);

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
        Schema::dropIfExists('medical_penjamin_pemeriksaan');
        Schema::dropIfExists('medical_master_pemeriksaan');
        Schema::dropIfExists('medical_tipe_layanan');
        Schema::dropIfExists('medical_sub_penjamin');
        Schema::dropIfExists('medical_penjamin');
        Schema::dropIfExists('medical_paket_detail');
    }
}
