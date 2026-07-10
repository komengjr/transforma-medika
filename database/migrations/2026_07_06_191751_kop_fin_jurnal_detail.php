<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopFinJurnalDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_fin_jurnal_detail', function (Blueprint $table) {
            $table->id('id_jurnal_detail');
            $table->foreignId('jurnal_id')->constrained('kop_fin_jurnal', 'id_jurnal')->onDelete('cascade');
            $table->string('coa_code'); // Menghubungkan ke kode COA Anda (misal: '1111', '4101')
            $table->integer('jurnal_debit')->default(0);
            $table->integer('jurnal_kredit')->default(0);
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
        Schema::dropIfExists('kop_fin_jurnal_detail');
    }
}
