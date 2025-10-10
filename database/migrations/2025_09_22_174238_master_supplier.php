<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_supplier', function (Blueprint $table) {
            $table->id('id_master_supplier');
            $table->string('master_supplier_code')->unique();
            $table->string('master_supplier_name');
            $table->string('master_supplier_city');
            $table->string('master_supplier_alamat');
            $table->string('master_supplier_phone');
            $table->string('master_supplier_email');
            $table->string('master_supplier_status');
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
        Schema::dropIfExists('master_supplier');
    }
}
