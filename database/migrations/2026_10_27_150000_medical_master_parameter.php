<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalMasterParameter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_master_parameter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_pemeriksaan_id'); // Relasi ke master pemeriksaan utama (Hematologi Rutin)
            $table->unsignedBigInteger('parent_id')->nullable(); // Jika diisi ID parameter induk, berarti ini adalah sub-parameter
            $table->string('nama_parameter'); // Contoh: Hemoglobin, Hitung Jenis, Eosinofil
            $table->boolean('is_group')->default(false); // Penanda apakah ini judul kelompok (seperti "Hitung Jenis") atau parameter input
            $table->string('nilai_normal')->nullable();
            $table->string('satuan')->nullable();
            $table->string('metode')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('master_pemeriksaan_id')
                ->references('id')
                ->on('medical_master_pemeriksaan')
                ->onDelete('cascade');
        });
        Schema::create('medical_transaksi_hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_id'); // Relasi ke medical_transaksi_detail
            $table->unsignedBigInteger('parameter_id'); // Relasi ke medical_master_parameter
            $table->string('hasil')->nullable(); // Nilai inputan hasil (Contoh: 12.6, 8970)
            $table->string('flag')->nullable(); // Penanda status (Contoh: H = High, L = Low, Normal kosong)
            $table->text('catatan')->nullable(); // Catatan khusus per parameter jika ada
            $table->timestamps();

            $table->foreign('detail_id')
                ->references('id')
                ->on('medical_transaksi_detail')
                ->onDelete('cascade');

            $table->foreign('parameter_id')
                ->references('id')
                ->on('medical_master_parameter')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_master_parameter');
        Schema::dropIfExists('medical_transaksi_hasil');
    }
}
