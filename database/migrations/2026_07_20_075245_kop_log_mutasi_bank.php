<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopLogMutasiBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_log_mutasi_bank', function (Blueprint $table) {
            $table->id('id_mutasi'); // Primary Key otomatis berkemampuan besar
            $table->string('mutasi_no_bukti', 50)->unique(); // Contoh: BKM-202607-0001
            $table->date('mutasi_tgl');
            $table->string('coa_code', 20); // Relasi ke kode COA Bank
            $table->string('mutasi_keterangan', 255)->nullable();

            // Menggunakan decimal agar perhitungan balance finansial akurat tanpa pembulatan error float
            $table->decimal('mutasi_debit', 15, 2)->default(0.00);
            $table->decimal('mutasi_kredit', 15, 2)->default(0.00);

            $table->string('mutasi_user', 100); // Pencatat transaksi
            $table->timestamps(); // Mengotomatiskan kolom created_at & updated_at

            // Menambahkan indexing untuk optimasi performa query laporan
            $table->index('coa_code');
            $table->index('mutasi_tgl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_log_mutasi_bank');
    }
}
