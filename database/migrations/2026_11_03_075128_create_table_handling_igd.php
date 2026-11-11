<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHandlingIgd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_igd_triase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');
            $table->integer('skala_triage')->comment('1: Resusitasi, 2: Emergent, 3: Urgent, 4: Non-Urgent');
            $table->text('keluhan_utama')->nullable();
            $table->string('tekanan_darah', 20)->nullable();
            $table->string('nadi', 20)->nullable();
            $table->string('suhu', 20)->nullable();
            $table->string('saturasi_oksigen', 20)->nullable();
            $table->string('pernapasan', 20)->nullable();
            $table->string('kesadaran', 50)->nullable()->comment('Compos Mentis, GCS, dll');
            $table->timestamps();
        });
        Schema::create('medical_igd_soap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');
            $table->text('subjektif')->nullable();
            $table->text('objektif')->nullable();
            $table->text('asesmen')->nullable();
            $table->text('planning')->nullable();
            $table->timestamps();
        });
        Schema::create('medical_igd_tindakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');
            $table->foreignId('master_pemeriksaan_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->decimal('tarif', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->foreignId('dokter_id')->nullable()->constrained('medical_master_doctor')->onDelete('set null');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
        Schema::create('medical_igd_disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');
            $table->enum('tindak_lanjut', ['PULANG', 'RAWAT_INAP', 'RUJUK', 'MENINGGAL'])->default('PULANG');
            $table->foreignId('ruangan_tujuan_id')->nullable()->constrained('medical_master_ruangan')->onDelete('set null');
            $table->string('rs_rujukan')->nullable();
            $table->text('alasan_rujuk')->nullable();
            $table->text('catatan_pulang')->nullable();
            $table->timestamps();
        });
        Schema::create('medical_igd_resep', function (Blueprint $table) {
            $table->id();

            // Relasi ke Data Registrasi (Kunjungan IGD)
            $table->foreignId('registrasi_id')
                ->constrained('medical_registrasi')
                ->onDelete('cascade');

            // Relasi ke Nota/Transaksi Kasir Utama
            $table->foreignId('transaksi_id')->nullable()
                ->constrained('medical_transaksi')
                ->onDelete('set null')
                ->comment('ID Nota/Transaksi saat resep ini dilunasi');

            // Data Obat
            $table->string('farm_data_obat_code');
            $table->integer('qty')->default(1);
            $table->string('signa')->nullable();
            $table->decimal('harga', 12, 2)->default(0);

            // Log Input
            $table->string('input_by')->nullable();

            // Verifikasi Dokter
            $table->string('dokter_verifikasi_kode')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');

            // Tracking Pembayaran Farmasi
            $table->enum('status_pembayaran', ['BELUM LUNAS', 'LUNAS', 'REFUND'])
                ->default('BELUM LUNAS')
                ->comment('Melacak apakah obat ini sudah dibayar di kasir');
            $table->dateTime('waktu_bayar')->nullable();

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
        Schema::dropIfExists('medical_igd_disposisi');
        Schema::dropIfExists('medical_igd_tindakan');
        Schema::dropIfExists('medical_igd_soap');
        Schema::dropIfExists('medical_igd_triase');
        Schema::dropIfExists('medical_igd_resep');
    }
}
