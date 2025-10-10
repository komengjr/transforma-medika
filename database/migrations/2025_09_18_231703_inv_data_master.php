<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvDataMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_data_master', function (Blueprint $table) {
            $table->id('id_inv_data_master');
            $table->string('inv_data_master_code')->unique();
            $table->string('inv_data_master_name');
            $table->string('inv_data_location_code');
            $table->string('id_inv_data_class_code');
            $table->string('inv_data_master_merk');
            $table->string('inv_data_master_type');
            $table->string('inv_data_master_seri');
            $table->integer('inv_data_master_aset');
            $table->string('inv_data_master_tgl_beli');
            $table->bigInteger('inv_data_master_harga');
            $table->string('inv_data_master_cabang');
            $table->text('inv_data_master_file')->nullable();
            $table->string('inv_data_master_no');
            $table->string('inv_data_master_supplier');
            $table->string('inv_data_master_status');
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
        Schema::dropIfExists('inv_data_master');
    }
}
