<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_company', function (Blueprint $table) {
            $table->id('id_master_company');
            $table->string('master_company_code')->unique();
            $table->string('master_company_name');
            $table->string('master_company_wilayah');
            $table->string('master_company_nat')->nullable();
            $table->string('master_company_type');
            $table->string('master_company_phone')->nullable();
            $table->string('master_company_email')->nullable();
            $table->string('master_company_level');
            $table->string('master_company_user');
            $table->integer('master_company_status');
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
        Schema::dropIfExists('master_company');
    }
}
