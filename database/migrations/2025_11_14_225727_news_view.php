<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_view', function (Blueprint $table) {
            $table->string('news_data_code')
                ->constrained('news_data')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

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
        Schema::dropIfExists('news_view');
    }
}
