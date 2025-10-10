<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_item', function (Blueprint $table) {
            $table->id('id_master_item');
            $table->string('master_item_code')->unique();
            $table->string('master_item_name');
            $table->string('master_item_type');
            $table->string('master_item_class');
            $table->string('master_item_opt');
            $table->text('master_item_pic')->nullable();
            $table->text('master_item_barcode')->nullable();
            $table->string('master_item_status');
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
        Schema::dropIfExists('master_item');
    }
}
