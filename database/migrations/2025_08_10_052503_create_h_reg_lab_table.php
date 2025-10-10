<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHRegLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_reg_lab', function (Blueprint $table) {
            $table->id('id_h_reg_lab');
            $table->string('h_reg_lab_code')->unique();
            $table->string('d_reg_order_lab_code');
            $table->string('t_pem_list_val_code');
            $table->string('h_reg_lab_value');
            $table->string('h_reg_lab_metode');
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
        Schema::dropIfExists('h_reg_lab');
    }
}
