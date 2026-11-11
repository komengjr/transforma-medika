<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalLaporanKeuangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('no_laporan')->unique(); // Contoh: LAP-KSR-20261031-0001
            $table->string('user_id'); // Petugas front office / kasir yang melaporkan
            $table->decimal('total_setoran', 15, 2);
            $table->integer('jumlah_transaksi');
            $table->enum('status_verifikasi', ['PENDING', 'DISETUJUI', 'DITOLAK'])->default('PENDING');
            $table->timestamps();
        });

        // 2. Table: medical_laporan_keuangan_detail (Pivot transaksi ke laporan)
        Schema::create('medical_laporan_keuangan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('medical_laporan_keuangan')->onDelete('cascade');
            $table->foreignId('transaksi_id')->constrained('medical_transaksi')->onDelete('cascade');
        });

        // 3. Table: medical_laporan_keuangan_log (Riwayat / Audit Trail)
        Schema::create('medical_laporan_keuangan_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('medical_laporan_keuangan')->onDelete('cascade');

            // Petugas yang melakukan aksi (Bisa Kasir yang membuat, atau Keuangan yang memverifikasi)
            $table->string('user_id');

            // Jenis Aksi: DIBUAT, DISETUJUI, DITOLAK, DIBATALKAN
            $table->string('aksi');

            // Catatan opsional (Alasan penolakan / Catatan persetujuan)
            $table->text('catatan')->nullable();
            $table->timestamps(); // created_at akan merekam kapan persisnya aksi dilakukan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_laporan_keuangan_log');
        Schema::dropIfExists('medical_laporan_keuangan_detail');
        Schema::dropIfExists('medical_laporan_keuangan');
    }
}
