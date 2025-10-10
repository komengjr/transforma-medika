<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvMasterLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_master_location', function (Blueprint $table) {
            $table->id('id_inv_master_location');
            $table->string('inv_master_location_code')->unique();
            $table->string('inv_master_location_name');
            $table->string('inv_master_location_status');
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
        Schema::dropIfExists('inv_master_location');
    }
}
