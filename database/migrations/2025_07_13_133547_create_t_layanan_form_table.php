<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTLayananFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_layanan_form', function (Blueprint $table) {
            $table->id('id_t_layanan_form');
            $table->string('t_layanan_form_code')->unique();
            $table->string('t_layanan_data_code');
            $table->string('t_layanan_form_name');
            $table->string('t_layanan_form_jenis')->nullable();
            $table->string('t_layanan_form_type')->nullable();
            $table->string('t_layanan_form_status');
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
        Schema::dropIfExists('t_layanan_form');
    }
}
