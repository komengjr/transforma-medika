<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalRawatInap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('medical_master_poli', function (Blueprint $table) {
            $table->id();
            $table->string('kode_poli', 10)->unique()->comment('Contoh: POL-ANA, POL-GIG');
            $table->string('nama_poli')->comment('Contoh: Poli Anak, Poli Gigi');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('medical_master_ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan'); // Contoh: Melati, Anggrek, ICU
            $table->string('kelas'); // Contoh: Kelas 1, Kelas 2, Kelas 3, VIP, VVIP
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('medical_master_bed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruangan_id')->constrained('medical_master_ruangan')->onDelete('cascade');
            $table->string('nomor_bed'); // Contoh: Bed 01, Bed 02
            $table->enum('status', ['TERSEDIA', 'TERISI', 'RUSAK'])->default('TERSEDIA');
            $table->timestamps();
        });
        Schema::create('medical_tarif_poli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poli_id')->constrained('medical_master_poli')->onDelete('cascade');
            $table->foreignId('sub_penjamin_id')->nullable()->constrained('medical_sub_penjamin')->onDelete('cascade');

            // Kategori Biaya: 'ADMINISTRASI', 'JASA_DOKTER'
            $table->string('kategori_biaya', 50);
            $table->string('nama_tarif'); // Contoh: "Biaya Administrasi", "Jasa Konsultasi"
            $table->decimal('tarif', 15, 2)->default(0);

            // --- NEW: SKEMA TANGGUNGAN KHUSUS PER TARIF ---
            $table->string('pola_tanggungan')->default('IKUT_ATURAN_INDUK')
                ->comment('IKUT_ATURAN_INDUK, FULL_PASIEN, FULL_PERUSAHAAN, SPLIT_PERSENTASE, SPLIT_PLAFON');
            $table->decimal('tanggungan_perusahaan_persen', 5, 2)->default(0.00);
            $table->decimal('tanggungan_perusahaan_maksimal_rp', 15, 2)->default(0.00);
            // ----------------------------------------------

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('medical_tarif_rawatinap', function (Blueprint $table) {
            $table->id();
            $table->string('kelas'); // Contoh: Kelas 1, Kelas 2, VIP, VVIP
            $table->foreignId('sub_penjamin_id')->constrained('medical_sub_penjamin')->onDelete('cascade');

            $table->decimal('tarif_kamar_per_hari', 15, 2)->default(0);
            $table->decimal('tarif_visite_dokter_per_hari', 15, 2)->default(0);
            $table->decimal('tarif_asuhan_keperawatan_per_hari', 15, 2)->default(0);

            // --- NEW: SKEMA TANGGUNGAN KHUSUS PER TARIF ---
            $table->string('pola_tanggungan')->default('IKUT_ATURAN_INDUK')
                ->comment('IKUT_ATURAN_INDUK, FULL_PASIEN, FULL_PERUSAHAAN, SPLIT_PERSENTASE, SPLIT_PLAFON');
            $table->decimal('tanggungan_perusahaan_persen', 5, 2)->default(0.00);
            $table->decimal('tanggungan_perusahaan_maksimal_rp', 15, 2)->default(0.00);
            // ----------------------------------------------

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('medical_tarif_igd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_penjamin_id')->constrained('medical_sub_penjamin')->onDelete('cascade');

            $table->string('kategori_biaya', 50); // ADMINISTRASI, JASA_DOKTER_IGD, SARANA_IGD
            $table->string('nama_tarif');
            $table->decimal('tarif', 15, 2)->default(0);

            // --- NEW: SKEMA TANGGUNGAN KHUSUS PER TARIF ---
            $table->string('pola_tanggungan')->default('IKUT_ATURAN_INDUK')
                ->comment('IKUT_ATURAN_INDUK, FULL_PASIEN, FULL_PERUSAHAAN, SPLIT_PERSENTASE, SPLIT_PLAFON');
            $table->decimal('tanggungan_perusahaan_persen', 5, 2)->default(0.00);
            $table->decimal('tanggungan_perusahaan_maksimal_rp', 15, 2)->default(0.00);
            // ----------------------------------------------

            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('medical_master_poli');
        Schema::dropIfExists('medical_tarif_poli');
        Schema::dropIfExists('medical_master_ruangan');
        Schema::dropIfExists('medical_master_bed');
        Schema::dropIfExists('medical_tarif_rawatinap');
    }
}
