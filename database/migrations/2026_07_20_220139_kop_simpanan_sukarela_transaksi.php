<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopSimpananSukarelaTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_simpanan_sukarela_transaksi', function (Blueprint $table) {
            $table->bigIncrements('id_sukarela_transaksi');
            $table->integer('id_kop_master_peserta')->index();
            $table->unsignedBigInteger('id_jurnal')->nullable(); // Terhubung ke accounting
            $table->date('tgl_transaksi');

            // jenis: 'SETORAN', 'PENARIKAN', 'POTONG_VOUCHER'
            $table->string('jenis_transaksi', 20);

            $table->decimal('nominal', 15, 2);
            $table->string('keterangan')->nullable();
            $table->string('operator')->nullable(); // Nama admin yang input
            $table->timestamps();

            $table->foreign('id_jurnal')->references('id_jurnal')->on('kop_fin_jurnal')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_simpanan_sukarela_transaksi');
    }
}
