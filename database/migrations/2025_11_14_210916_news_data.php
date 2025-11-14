<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_data', function (Blueprint $table) {
            $table->id('id_news_data');
            $table->string('news_data_code')->unique();
            $table->string('news_categori_code')
                ->nullable()
                ->constrained('news_categori')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('news_data_title');
            $table->string('news_data_slug')->unique();
            $table->longText('news_data_content');
            $table->string('news_data_thumbnail')->nullable();
            $table->string('news_data_author')->nullable();
            $table->dateTime('news_data_published_at')->nullable();
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
        Schema::dropIfExists('news_data');
    }
}
