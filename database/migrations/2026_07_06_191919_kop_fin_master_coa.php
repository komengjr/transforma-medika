<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopFinMasterCoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_fin_master_coa', function (Blueprint $table) {
            $table->string('coa_code')->primary(); // Contoh: '1111', '1121', '4101'
            $table->string('coa_name');           // Contoh: 'Kas Besar', 'Piutang Anggota'
            $table->enum('coa_type', ['aset', 'kewajiban', 'ekuitas', 'pendapatan', 'beban']);
            $table->enum('normal_balance', ['debit', 'kredit']); // Posisi saldo normal akun
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('kop_fin_master_coa');
    }
}
