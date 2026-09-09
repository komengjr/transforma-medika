<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalAntrianLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_antrian_log', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel medical_loket
            $table->foreignId('loket_id')->constrained('medical_loket')->onDelete('cascade');

            $table->string('nomor_antrian', 15); // Contoh: A001, B005
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai', 'batal'])->default('menunggu');
            $table->integer('nomor_loket_pemanggil')->nullable(); // Misal: Loket 1, Loket 2 (jika 1 jenis loket punya beberapa meja)
            $table->timestamp('waktu_panggil')->nullable(); // Waktu saat dipanggil oleh petugas
            $table->timestamp('waktu_selesai')->nullable(); // Waktu saat pelayanan selesai
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
        Schema::dropIfExists('medical_antrian_log');
    }
}
