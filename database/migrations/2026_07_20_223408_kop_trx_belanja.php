<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopTrxBelanja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. TABEL UTAMA (HEADER TRANSAKSI)
        Schema::create('kop_trx_belanja', function (Blueprint $table) {
            $table->id('id_belanja');
            $table->string('no_nota', 50)->unique();
            $table->unsignedBigInteger('id_kop_master_peserta'); // Terhubung ke master anggota
            $table->decimal('total_harga', 12, 2);
            $table->enum('metode_bayar', ['CASH', 'MASUK_TAGIHAN', 'TRANSFER_BANK', 'VIRTUAL_ACCOUNT']);
            $table->enum('status_transaksi', ['PENDING', 'SUKSES', 'GAGAL'])->default('SUKSES');
            $table->timestamps();

            // Indexing untuk optimalisasi query data yang besar
            $table->index('id_kop_master_peserta');
            $table->index('no_nota');
        });

        // 2. TABEL DETAIL (RINCIAN KERANJANG)
        Schema::create('kop_trx_belanja_detail', function (Blueprint $table) {
            $table->id('id_belanja_detail');
            $table->unsignedBigInteger('id_belanja'); // FK ke kop_trx_belanja
            $table->unsignedBigInteger('id_produk'); // Terhubung ke master produk
            $table->integer('qty');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2); // qty * harga_satuan
            $table->timestamps();

            // Constraint Foreign Key Cascading
            $table->foreign('id_belanja')
                ->references('id_belanja')
                ->on('kop_trx_belanja')
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
        Schema::dropIfExists('kop_trx_belanja_detail');
        Schema::dropIfExists('kop_trx_belanja');
    }
}
