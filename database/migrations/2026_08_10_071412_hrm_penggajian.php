<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmPenggajian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_penggajian', function (Blueprint $table) {
            $table->id();
            $table->string('hrm_m_pegawai_code');
            $table->integer('bulan'); // Contoh: 1 - 12
            $table->integer('tahun'); // Contoh: 2026
            $table->decimal('total_pendapatan', 15, 2);
            $table->decimal('total_potongan', 15, 2);
            $table->decimal('take_home_pay', 15, 2);
            $table->enum('status', ['PENDING', 'PAID', 'CANCELLED'])->default('PAID');
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();

            // Mencegah double pembayaran di bulan & tahun yang sama untuk 1 pegawai
            $table->unique(['hrm_m_pegawai_code', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_penggajian');
    }
}
