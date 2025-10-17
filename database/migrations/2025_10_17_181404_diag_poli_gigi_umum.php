<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiagPoliGigiUmum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_poli_gigi_umum', function (Blueprint $table) {
            $table->id('id_diag_poli_gigi_umum');
            $table->string('diag_poli_gigi_umum_code')->unique();
            $table->string('d_reg_order_poli_code');
            $table->string('diag_poli_gigi_umum_name');
            $table->text('diag_poli_gigi_umum_desc');
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
        Schema::dropIfExists('diag_poli_gigi_umum');
    }
}
