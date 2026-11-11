<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRanap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_rawat_inap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');
            $table->foreignId('ruangan_bed_id')->constrained('medical_master_bed')->onDelete('cascade'); // Relasi ke kasur
            $table->unsignedBigInteger('kode_dokter')->nullable(); // Menyesuaikan dengan relasi master dokter (atau ID dokter)
            $table->string('status_inap')->default('DIRAWAT'); // DIRAWAT, PULANG, PINDAH
            $table->dateTime('tgl_masuk');
            $table->dateTime('tgl_keluar')->nullable();
            $table->string('status_pulang')->nullable(); // Sembuh, Pulang Paksa, Rujuk, Meninggal
            $table->text('catatan_pulang')->nullable();
            $table->timestamps();
        });
        // 1. Tabel SOAP Ranap
        Schema::create('medical_ranap_soap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');
            $table->text('subjektif')->nullable();
            $table->text('objektif')->nullable();
            $table->text('asesmen')->nullable();
            $table->text('planning')->nullable();
            $table->string('input_by')->nullable(); // User/Perawat yang menginput
            $table->string('dokter_verifikasi_kode')->nullable(); // Kode dokter yang memverifikasi
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
        Schema::create('medical_ranap_tindakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');
            $table->unsignedBigInteger('master_pemeriksaan_id');
            $table->decimal('tarif', 15, 2)->default(0);
            $table->integer('jumlah')->default(1);
            $table->string('input_by')->nullable();
            $table->string('dokter_verifikasi_kode')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
        Schema::create('medical_ranap_resep', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registrasi_id');

            // --- UPDATE BARU DI SINI ---
            $table->foreignId('transaksi_id')->nullable()
                ->constrained('medical_transaksi')
                ->onDelete('set null')
                ->comment('ID Nota/Transaksi saat resep ini dilunasi');
            // ---------------------------

            $table->string('farm_data_obat_code');
            $table->integer('qty')->default(1);
            $table->string('signa')->nullable();
            $table->decimal('harga', 12, 2)->default(0);
            $table->string('input_by')->nullable();

            $table->string('dokter_verifikasi_kode')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');

            // --- UPDATE BARU DI SINI ---
            $table->enum('status_pembayaran', ['BELUM LUNAS', 'LUNAS', 'REFUND'])
                ->default('BELUM LUNAS')
                ->comment('Melacak apakah obat ini sudah dibayar di kasir');

            $table->dateTime('waktu_bayar')->nullable();
            // ---------------------------

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
        Schema::dropIfExists('medical_rawat_inap');
        Schema::dropIfExists('medical_ranap_soap');
        Schema::dropIfExists('medical_ranap_tindakan');
        Schema::dropIfExists('medical_ranap_resep');
    }
}
