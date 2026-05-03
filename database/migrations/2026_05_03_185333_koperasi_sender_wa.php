<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiSenderWa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_sender_wa', function (Blueprint $table) {
            $table->id('id_kop_sender_wa');
            $table->string('kop_sender_wa_code')->unique();
            $table->string('kop_sender_wa_code_token');
            $table->string('kop_sender_wa_code_number');
            $table->string('kop_sender_wa_code_name');
            $table->string('kop_sender_wa_code_filename');
            $table->longText('kop_sender_wa_code_text');
            $table->longText('kop_sender_wa_code_file');
            $table->longText('kop_sender_wa_code_picture');
            $table->string('kop_sender_wa_code_status');
            $table->timestamp('kop_sender_wa_code_date');
            $table->string('kop_sender_wa_code_pass');
            $table->string('kop_sender_wa_code_user');
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
        Schema::dropIfExists('kop_sender_wa');
    }
}
