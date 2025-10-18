<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiagPoliFisikUmumD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_poli_fisik_umum_d', function (Blueprint $table) {
            $table->id('id_diag_poli_fisik_umum_d');
            $table->string('diag_poli_fisik_umum_d_code')->unique();
            $table->string('diag_poli_fisik_umum_code');
            $table->string('d_reg_order_poli_code');
            $table->string('diag_poli_fisik_umum_d_val');
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
        Schema::dropIfExists('diag_poli_fisik_umum_d');
    }
}
