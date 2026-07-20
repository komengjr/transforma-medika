<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopAsetReestimasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_aset_reestimasi', function (Blueprint $table) {
            $table->id('id_reestimasi');
            $table->foreignId('pembelian_id')->constrained('kop_pembelian_barang', 'id_pembelian')->onDelete('cascade');
            $table->date('tgl_reestimasi');
            $table->integer('harga_perolehan_awal')->default(0);
            $table->integer('total_akumulasi_penyusutan')->default(0);
            $table->integer('nilai_buku_saat_ini')->default(0);
            $table->integer('umur_ekonomis_awal');
            $table->integer('sisa_umur_ekonomis_reguler');
            $table->integer('umur_ekonomis_baru');
            $table->integer('beban_penyusutan_baru_tahunan')->default(0);
            $table->integer('beban_penyusutan_baru_bulanan')->default(0);
            $table->text('alasan_reestimasi')->nullable();
            $table->string('jurnal_ref_no_bukti')->nullable();
            $table->string('approved_by')->nullable();
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
        Schema::dropIfExists('kop_aset_reestimasi');
    }
}
