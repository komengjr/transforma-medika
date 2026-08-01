<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalMasterAlat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_master_alat', function (Blueprint $table) {
            $table->id('instrument_id');
            $table->string('kode_alat', 50)->unique();    // Kode Unik Alat / Instrument ID
            $table->string('nama_alat', 100);             // Nama Alat Lab (misal: Cobas c311, Sysmex XN-550)
            $table->string('tipe_koneksi', 50)->nullable(); // Misal: TCP/IP, RS232, File Watcher
            $table->string('ip_address', 45)->nullable();   // IP Address jika koneksi jaringan
            $table->string('port', 10)->nullable();         // Port koneksi
            $table->string('lokasi_ruangan', 100)->nullable(); // Lokasi lab (misal: Lab Hematologi, Lab Kimia)
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('medical_master_alat');
    }
}
