<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiagPoliFisikUmum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diag_poli_fisik_umum', function (Blueprint $table) {
            $table->id('id_diag_poli_fisik_umum');
            $table->string('diag_poli_fisik_umum_code')->unique();
            $table->string('diag_poli_fisik_umum_name');
            $table->string('diag_poli_fisik_type');
            $table->string('diag_poli_fisik_satuan');
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
        Schema::dropIfExists('diag_poli_fisik_umum');
    }
}
