<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopMasterProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('kode_produk', 50)->unique();
            $table->string('nama_produk', 255);
            $table->string('gambar_produk', 255)->nullable();
            $table->string('kategori', 100)->nullable();
            $table->decimal('harga_beli_default', 15, 2)->default(0);
            $table->decimal('harga_jual_default', 15, 2)->default(0);
            $table->integer('stok_aktual')->default(0); // Stok otomatis bertambah saat restock
            $table->string('satuan', 50)->default('Pcs');
            $table->timestamps();
        });

        // Tabel riwayat masuknya stok (pembelian barang oleh koperasi)
        Schema::create('kop_trx_produk_stok_masuk', function (Blueprint $table) {
            $table->id('id_stok_masuk');
            $table->foreign('produk_id')->references('id_produk')->on('kop_master_produk');
            $table->integer('jumlah_masuk');
            $table->decimal('harga_beli_satuan', 15, 2);
            $table->date('tanggal_masuk');
            $table->string('keterangan', 255)->nullable();
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
        Schema::dropIfExists('kop_trx_produk_stok_masuk');
        Schema::dropIfExists('kop_master_produk');
    }
}
