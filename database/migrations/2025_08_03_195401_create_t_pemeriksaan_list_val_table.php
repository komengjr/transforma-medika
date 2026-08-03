<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPemeriksaanListValTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pemeriksaan_list_val', function (Blueprint $table) {
            $table->id('id_t_pem_list_val');
            $table->string('t_pem_list_val_code')->unique();
            $table->string('t_pemeriksaan_list_code');
            $table->string('t_pem_list_val_name');
            $table->string('t_pem_list_val_nilai');
            $table->string('t_pem_list_val_rujukan');
            $table->string('t_pem_list_val_satuan');
            $table->string('t_pem_list_val_instrumen');
            $table->string('t_pem_list_val_param');
            $table->string('t_pem_list_val_param');
            $table->string('t_pem_list_val_metode');
            $table->string('t_pem_list_val_kali');
            $table->string('t_pem_list_val_opt');
            $table->string('t_pem_list_val_opt_code')->nullable();
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
        Schema::dropIfExists('t_pemeriksaan_list_val');
    }
}
