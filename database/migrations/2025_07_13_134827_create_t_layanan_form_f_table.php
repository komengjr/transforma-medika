<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTLayananFormFTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_layanan_form_f', function (Blueprint $table) {
            $table->id('id_t_layanan_form_f');
            $table->string('t_layanan_form_f_code')->unique();
            $table->string('t_layanan_form_code');
            $table->string('t_layanan_form_f_name');
            $table->string('t_layanan_form_f_type');
            $table->string('t_layanan_form_f_number');
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
        Schema::dropIfExists('t_layanan_form_f');
    }
}
