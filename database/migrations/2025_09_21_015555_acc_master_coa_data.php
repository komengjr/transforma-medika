<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccMasterCoaData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_master_coa_data', function (Blueprint $table) {
            $table->id('id_acc_master_coa_data');
            $table->string('acc_coa_data_code')->unique();
            $table->string('acc_master_coa_code');
            $table->string('acc_coa_data_no');
            $table->string('acc_coa_data_name');
            $table->string('acc_coa_data_type');
            $table->string('acc_coa_data_level');
            $table->string('acc_coa_data_opt');
            $table->string('acc_coa_data_status');
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
        Schema::dropIfExists('acc_master_coa_data');
    }
}
