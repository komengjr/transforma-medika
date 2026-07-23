<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopTrxTagihanLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_trx_tagihan_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 50)->unique();
            $table->unsignedBigInteger('anggota_id');
            $table->enum('jenis_layanan', ['LISTRIK', 'PDAM', 'INTERNET', 'PULSA', 'LAINNYA']);
            $table->string('nomor_tujuan', 100)->comment('No. Meter / No. Pelanggan / No. HP');
            $table->string('nama_pelanggan', 150)->nullable();

            $table->decimal('nominal', 15, 2)->default(0);
            $table->decimal('admin_fee', 15, 2)->default(0);
            $table->decimal('total_tagihan', 15, 2)->default(0);

            // Kolom Tambahan COA Sesuai Pilihan Akun Jurnal Form
            $table->string('piutang_coa', 50)->nullable()->comment('COA Piutang Anggota (Debet)');
            $table->string('sumber_dana_coa', 50)->nullable()->comment('COA Kas/Bank Netto (Kredit)');
            $table->string('pendapatan_admin_coa', 50)->nullable()->comment('COA Pendapatan Biaya Admin (Kredit)');

            $table->enum('status_tagihan', ['PENDING', 'DITAGIHKAN', 'LUNAS', 'BATAL'])->default('PENDING');

            $table->string('created_by', 100)->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('anggota_id')
                ->references('id_kop_master_peserta')
                ->on('kop_master_peserta')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_trx_tagihan_layanan');
    }
}
