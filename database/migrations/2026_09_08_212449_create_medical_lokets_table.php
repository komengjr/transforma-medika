<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMedicalLoketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_loket', function (Blueprint $table) {
            $table->id();
            $table->string('nama_loket'); // Contoh: Pendaftaran, Kasir, Farmasi
            $table->string('kode_prefix', 10); // Contoh: A, B, C
            $table->string('deskripsi')->nullable(); // Deskripsi singkat pelayanan
            $table->string('icon')->default('fa-solid fa-headset'); // FontAwesome Icon
            $table->string('warna_tema')->default('card-loket-1'); // Class CSS Tema Warna
            $table->integer('nomor_terakhir')->default(0); // Tracking nomor antrian hari ini
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->timestamps();
        });

        // Seed data awal agar loket langsung terisi saat disembur migration
        DB::table('medical_loket')->insert([
            [
                'nama_loket'     => 'Customer Service',
                'kode_prefix'    => 'A',
                'deskripsi'      => 'Pendaftaran & Pelayanan Informasi Pasien',
                'icon'           => 'fa-solid fa-user-doctor',
                'warna_tema'     => 'card-loket-1',
                'nomor_terakhir' => 0,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nama_loket'     => 'Pembayaran & Kasir',
                'kode_prefix'    => 'B',
                'deskripsi'      => 'Pembayaran Rawat Jalan & Rawat Inap',
                'icon'           => 'fa-solid fa-receipt',
                'warna_tema'     => 'card-loket-2',
                'nomor_terakhir' => 0,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nama_loket'     => 'Farmasi & Apotek',
                'kode_prefix'    => 'C',
                'deskripsi'      => 'Pengambilan Obat & Konsultasi Resep',
                'icon'           => 'fa-solid fa-pills',
                'warna_tema'     => 'card-loket-3',
                'nomor_terakhir' => 0,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_loket');
    }
}
