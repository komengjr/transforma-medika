<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalPenagihanPerusahaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabel Header Penagihan Perusahaan
        Schema::create('medical_penagihan_perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('no_tagihan')->unique(); // Contoh: TGH-20261116-0001
            $table->date('tanggal_tagihan');
            $table->unsignedBigInteger('sub_penjamin_id'); // Perusahaan / Asuransi
            $table->decimal('total_tagihan', 15, 2)->default(0);
            $table->string('status_tagihan')->default('DRAFT'); // DRAFT, TERKIRIM, LUNAS
            $table->string('dibuat_oleh')->nullable();
            $table->timestamps();
        });

        // Tabel Relasi Transaksi ke Tagihan Perusahaan
        Schema::create('medical_penagihan_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penagihan_id');
            $table->unsignedBigInteger('transaksi_id'); // Menghubungkan ke medical_transaksi
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
        Schema::dropIfExists('medical_penagihan_perusahaan');
        Schema::dropIfExists('medical_penagihan_detail');
    }
}
