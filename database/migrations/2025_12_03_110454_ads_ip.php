<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdsIp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_ip', function (Blueprint $table) {
            $table->id();
            $table->string('news_view_user_ip', 50)->nullable();
            $table->string('news_view_user_agent')->nullable();
            $table->date('news_view_date')->nullable(); // untuk statistik harian
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
        Schema::dropIfExists('ads_ip');
    }
}
