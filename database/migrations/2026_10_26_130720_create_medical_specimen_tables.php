<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalSpecimenTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_specimen_data', function (Blueprint $table) {
            $table->id();
            $table->string('s_specimen_data_code')->unique()->comment('Kode unik spesimen, misal: SPK-001');
            $table->string('s_specimen_data_name')->comment('Nama spesimen, misal: Darah Vena (Venous Blood)');
            $table->string('wadah_tabung')->nullable()->comment('Jenis tabung/wadah, misal: Vacuum Tube EDTA, Pot Urine');
            $table->string('volume_minimal')->nullable()->comment('Volume minimal, misal: 3 ml');
            $table->string('suhu_penyimpanan')->nullable()->comment('Suhu penyimpanan, misal: 2-8°C');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Tabel Relasi Master Pemeriksaan ke Spesimen (Pivot)
        Schema::create('medical_pem_specimen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_pemeriksaan_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');
            $table->foreignId('specimen_data_id')->constrained('medical_specimen_data')->onDelete('cascade');
            $table->text('catatan_khusus')->nullable()->comment('Instruksi khusus, misal: Harus puasa 10 jam');
            $table->timestamps();
        });

        // 3. Tabel Transaksi / Koleksi Spesimen Pasien
        Schema::create('medical_specimen_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_detail_id')->constrained('medical_transaksi_detail')->onDelete('cascade')->comment('Merujuk ke item di medical_transaksi_detail');
            $table->foreignId('specimen_data_id')->constrained('medical_specimen_data')->onDelete('cascade');

            $table->string('no_barcodespesimen')->unique()->comment('Nomor unik barcode sampel, misal: SPL2610260001');
            $table->enum('status_koleksi', ['BELUM', 'DITERIMA', 'DITOLAK', 'DIPROSES'])->default('BELUM');
            $table->dateTime('waktu_koleksi')->nullable()->comment('Waktu saat spesimen berhasil diambil');
            $table->string('petugas_koleksi_id')->nullable()->comment('User ID petugas lab pengambil sampel');

            $table->string('kondisi_sampel')->default('Baik')->comment('Contoh: Baik, Hemolisis, Lipemik, Volume Kurang');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });

        // 4. Tabel Log Perjalanan / Riwayat Spesimen
        Schema::create('medical_specimen_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specimen_collection_id')->constrained('medical_specimen_collection')->onDelete('cascade');
            $table->string('status_log')->comment('Contoh: DIKOLEKSI, DIKIRIM_KE_LAB, DIANALISIS, SELESAI');
            $table->text('keterangan')->nullable();
            $table->string('user_pencatat')->nullable();
            $table->dateTime('waktu_log')->nullable();
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
        Schema::dropIfExists('medical_specimen_log');
        Schema::dropIfExists('medical_specimen_collection');
        Schema::dropIfExists('medical_pem_specimen');
        Schema::dropIfExists('medical_specimen_data');
    }
}
