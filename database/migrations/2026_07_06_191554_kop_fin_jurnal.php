<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopFinJurnal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_fin_jurnal', function (Blueprint $table) {
            $table->id('id_jurnal');
            $table->string('jurnal_no_bukti')->unique(); // Contoh: JV-202607-0001
            $table->date('jurnal_tgl');
            $table->text('jurnal_keterangan')->nullable();

            // Polimorfisme / Referensi Transaksi Asal
            $table->string('jurnal_ref_table'); // Isi: 'kop_proses_peminjaman_uang', 'kop_proses_peminjaman_brg', atau 'kop_vocher_data'
            $table->string('jurnal_ref_code');   // Isi: kop_proses_uang_code / kop_proses_brg_code / kop_vocher_data_code

            $table->string('jurnal_user');
            $table->string('jurnal_cabang');
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
        Schema::dropIfExists('kop_fin_jurnal');
    }
}
