<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsCategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_categori', function (Blueprint $table) {
            $table->id('id_news_categori');
            $table->string('news_categori_code')->unique();
            $table->string('news_categori_name');
            $table->string('news_categori_slug');
            $table->text('news_categori_desc')->nullable();
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
        Schema::dropIfExists('news_categori');
    }
}
