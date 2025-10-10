<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSSpecimenLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_specimen_log', function (Blueprint $table) {
            $table->id('id_s_specimen_log');
            $table->string('s_specimen_log_code')->unique();
            $table->string('t_pem_specimen_code');
            $table->string('d_reg_order_list_code');
            $table->string('s_specimen_log_time');
            $table->string('s_specimen_log_end_time');
            $table->string('s_specimen_log_user');
            $table->string('s_specimen_log_status');
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
        Schema::dropIfExists('s_specimen_log');
    }
}
