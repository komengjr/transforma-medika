<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccMasterCoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_master_coa', function (Blueprint $table) {
            $table->id('id_acc_master_coa');
            $table->string('acc_master_coa_code')->unique();
            $table->string('acc_master_coa_name');
            $table->string('acc_master_coa_type');
            $table->string('acc_master_coa_status');
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
        Schema::dropIfExists('acc_master_coa');
    }
}
