<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BMasterContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_master_contact', function (Blueprint $table) {
            $table->id('id_b_master_contact');
            $table->string('b_master_contact_code')->unique();
            $table->string('b_master_contact_name');
            $table->string('b_master_contact_email');
            $table->string('b_master_contact_whatsapp');
            $table->string('b_master_contact_cabang');
            $table->string('b_master_contact_status');
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
        Schema::dropIfExists('b_master_contact');
    }
}
