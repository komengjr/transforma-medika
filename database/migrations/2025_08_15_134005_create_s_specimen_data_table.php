<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSSpecimenDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_specimen_data', function (Blueprint $table) {
            $table->id('id_s_specimen_data');
            $table->string('s_specimen_data_code')->unique();
            $table->string('s_specimen_data_name');
            $table->string('s_specimen_data_type');
            $table->string('s_specimen_data_status');
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
        Schema::dropIfExists('s_specimen_data');
    }
}
