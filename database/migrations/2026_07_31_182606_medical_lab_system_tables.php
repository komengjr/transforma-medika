<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Master Pemeriksaan Lab Table (Paket / Induk)
        Schema::create('medical_pemeriksaan_labs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemeriksaan')->unique(); // Contoh: LAB-HEMATO
            $table->string('nama_pemeriksaan');           // Contoh: Hematologi Rutin
            $table->decimal('harga', 15, 2)->default(0);  // Contoh: 150000
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Master Pemeriksaan Lab Sub Table (Sub Parameter / Nilai Hasil)
        Schema::create('medical_pemeriksaan_lab_subs', function (Blueprint $table) {
            $table->id();

            // Relasi ke Master Induk / Paket
            $table->foreignId('medical_pemeriksaan_lab_id')
                ->constrained('medical_pemeriksaan_labs')
                ->onDelete('cascade');

            $table->string('kode_sub');                       // Contoh: SUB-WBC
            $table->string('nama_sub');                       // Contoh: Leukosit (WBC)
            $table->string('code_alat')->nullable()->index(); // Contoh: WBC (dari Sysmex)
            $table->string('satuan')->nullable();             // Contoh: 10^3/uL
            $table->string('nilai_rujukan')->nullable();      // Contoh: 4.00 - 10.00
            $table->integer('urutan')->default(0);            // Urutan susunan tampilan
            $table->timestamps();
        });

        // 3. Header Pendaftaran Lab Table
        Schema::create('medical_pendaftaran_labs', function (Blueprint $table) {
            $table->id('id_medical_pendaftaran_lab');
            $table->string('nolab')->unique();

            $table->unsignedBigInteger('id_master_patient');
            $table->foreign('id_master_patient', 'fk_pendaftaran_patient')
                ->references('id_master_patient')
                ->on('master_patient')
                ->onDelete('cascade');

            $table->dateTime('tanggal_daftar');
            $table->enum('status', ['PENDING', 'PROSES', 'SELESAI', 'BATAL'])->default('PENDING');
            $table->decimal('total_biaya', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // 4. Detail Pendaftaran Lab Table
        // 4. Detail Pendaftaran Lab Table
        Schema::create('medical_pendaftaran_lab_details', function (Blueprint $table) {
            $table->id('id_medical_pendaftaran_lab_detail');

            // Foreign Key ke Header Pendaftaran Lab
            $table->unsignedBigInteger('medical_pendaftaran_lab_id');
            $table->foreign('medical_pendaftaran_lab_id', 'fk_detail_pendaftaran')
                ->references('id_medical_pendaftaran_lab')
                ->on('medical_pendaftaran_labs')
                ->onDelete('cascade');

            // Foreign Key ke Master Paket (Induk)
            $table->unsignedBigInteger('medical_pemeriksaan_lab_id');
            $table->foreign('medical_pemeriksaan_lab_id', 'fk_detail_pemeriksaan')
                ->references('id')
                ->on('medical_pemeriksaan_labs')
                ->onDelete('cascade');

            // Foreign Key ke Sub Parameter (NAMA CONSTRAINT DIPENDEKKAN DENGAN PARM KE-2)
            $table->unsignedBigInteger('medical_pemeriksaan_lab_sub_id')->nullable();
            $table->foreign('medical_pemeriksaan_lab_sub_id', 'fk_detail_pemeriksaan_sub') // Nama 'fk_detail_pemeriksaan_sub' hanya 27 karakter
                ->references('id')
                ->on('medical_pemeriksaan_lab_subs')
                ->onDelete('cascade');

            $table->decimal('harga_pemeriksaan', 12, 2)->default(0);
            $table->string('hasil_pemeriksaan')->nullable();
            $table->string('satuan')->nullable();
            $table->string('nilai_rujukan_terpakai')->nullable();
            $table->string('flag_hasil')->nullable(); // 'N', 'H', 'L'

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
        Schema::dropIfExists('medical_pendaftaran_lab_details');
        Schema::dropIfExists('medical_pendaftaran_labs');
        Schema::dropIfExists('medical_pemeriksaan_lab_subs');
        Schema::dropIfExists('medical_pemeriksaan_labs');
    }
};
