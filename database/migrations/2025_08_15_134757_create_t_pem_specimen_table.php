<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPemSpecimenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pem_specimen', function (Blueprint $table) {
            $table->id('id_t_pem_specimen');
            $table->string('t_pem_specimen_code')->unique();
            $table->string('s_specimen_data_code');
            $table->string('t_pemeriksaan_list_code');
            $table->string('t_pem_specimen_status');
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
        Schema::dropIfExists('t_pem_specimen');
    }
}
