<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVLogWhatsappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v_log_whatsapp', function (Blueprint $table) {
            $table->id('id_v_log_whatsapp');
            $table->string('v_log_whatsapp_code')->unique();
            $table->string('d_reg_order_list_code');
            $table->string('v_log_whatsapp_number');
            $table->string('v_log_whatsapp_name');
            $table->string('v_log_whatsapp_filename');
            $table->longText('v_log_whatsapp_text');
            $table->longText('v_log_whatsapp_file');
            $table->longText('v_log_whatsapp_picture');
            $table->string('v_log_whatsapp_status');
            $table->timestamp('v_log_whatsapp_date');
            $table->string('v_log_whatsapp_pass');
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
        Schema::dropIfExists('v_log_whatsapp');
    }
}
