<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmMasterPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_master_position', function (Blueprint $table) {
            $table->id('id_hrm_master_position');
            $table->string('hrm_master_position_code')->unique();
            $table->string('hrm_master_position_name');
            $table->string('hrm_master_position_lvl');
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
        Schema::dropIfExists('hrm_master_position');
    }
}
