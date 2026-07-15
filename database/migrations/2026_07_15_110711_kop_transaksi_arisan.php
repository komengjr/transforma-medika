<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopTransaksiArisan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_transaksi_arisan', function (Blueprint $table) {
            $table->id('id_kop_transaksi_arisan');
            $table->unsignedBigInteger('id_kop_master_arisan');
            $table->unsignedBigInteger('id_kop_master_peserta');
            $table->integer('kop_transaksi_bulan');
            $table->integer('kop_transaksi_tahun');
            $table->integer('kop_transaksi_total_poin');
            $table->decimal('kop_transaksi_nominal', 15, 2);
            $table->string('kop_transaksi_metode')->default('Tunai'); // Tunai, Transfer, dll
            $table->string('kop_transaksi_status')->default('Lunas');
            $table->text('kop_transaksi_keterangan')->nullable();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('id_kop_master_arisan')->references('id_kop_master_arisan')->on('kop_master_arisan')->onDelete('cascade');
            $table->foreign('id_kop_master_peserta')->references('id_kop_master_peserta')->on('kop_master_peserta')->onDelete('cascade');

            // Mencegah double input/bayar untuk orang yang sama di bulan & tahun yang sama
            $table->unique(['id_kop_master_arisan', 'id_kop_master_peserta', 'kop_transaksi_bulan', 'kop_transaksi_tahun'], 'idx_unique_transaksi_arisan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_transaksi_arisan');
    }
}
