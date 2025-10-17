<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiagPoliGigiOdon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_poli_gigi_odon', function (Blueprint $table) {
            $table->id('id_diag_poli_gigi_odon');
            $table->string('diag_poli_gigi_odon_code')->unique();
            $table->string('d_reg_order_poli_code');
            $table->string('diag_poli_gigi_odon_no');
            $table->string('diag_poli_gigi_odon_val');
            $table->string('diag_poli_gigi_odon_note');
            $table->string('diag_poli_gigi_odon_status');
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
        Schema::dropIfExists('diag_poli_gigi_odon');
    }
}
