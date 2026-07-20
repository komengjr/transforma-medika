<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopPembelianBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_pembelian_barang', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->string('pembelian_code')->unique(); // Contoh: PO-20260719-0001
            $table->date('tgl_beli');
            $table->string('supplier');
            $table->enum('kategori', ['ASET', 'NON_ASET']);
            $table->string('nama_barang');
            $table->string('satuan')->default('Unit');
            $table->integer('qty')->default(1);
            $table->integer('harga_satuan')->default(0);
            $table->integer('total_harga')->default(0);

            // Konfigurasi Akuntansi & Jurnal terkait
            $table->string('coa_pembayaran'); // Kode COA Kas/Bank
            $table->string('coa_debit_target'); // Kode COA Aset atau COA Beban yang dipilih
            $table->integer('umur_ekonomis_tahun')->nullable(); // Terisi khusus jika kategori ASET
            $table->text('keterangan')->nullable();

            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('kop_pembelian_barang');
    }
}
