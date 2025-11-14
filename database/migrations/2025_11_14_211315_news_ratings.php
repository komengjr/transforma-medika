<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_ratings', function (Blueprint $table) {
            $table->id('id_news_ratings');
            $table->string('news_data_code')
                ->constrained('news_data')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->tinyInteger('news_ratings_rating')->unsigned()->comment('1-5');
            $table->string('news_ratings_user_ip', 50)->nullable();
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
        Schema::dropIfExists('news_ratings');
    }
}
