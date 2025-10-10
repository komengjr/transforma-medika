<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccMasterCoaDataSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_master_coa_data_sub', function (Blueprint $table) {
            $table->id('id_acc_coa_data_sub');
            $table->string('acc_coa_data_sub_code')->unique();
            $table->string('acc_coa_data_sub_name');
            $table->string('acc_coa_data_sub_type');
            $table->string('acc_coa_data_sub_opt');
            $table->string('acc_coa_data_sub_level');
            $table->string('acc_coa_data_sub_status');
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
        Schema::dropIfExists('acc_master_coa_data_sub');
    }
}
