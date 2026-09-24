<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // Untuk URL ramah SEO
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->string('backdrop')->nullable(); // Gambar banner besar untuk halaman detail/hero
            $table->string('triler')->nullable(); // Trailer umum (bisa link YouTube)

            // Kolom 'video' dihapus dari sini jika itu series,
            // namun jika tipe 'movie' (film tunggal), bisa tetap dipakai atau dipindah sepenuhnya ke episodes.
            // Agar fleksibel untuk film tunggal, kita biarkan atau bisa dikosongkan.
            $table->string('video')->nullable();

            // Penanda Tipe Konten (Movie / Series)
            $table->enum('type', ['movie', 'series'])->default('movie');

            $table->string('type_link')->nullable();
            $table->string('genre')->nullable();
            $table->date('release_date')->nullable();
            $table->string('rating')->nullable(); // Misal: PG-13, 18+, dll
            $table->string('duration')->nullable(); // Durasi total / rata-rata
            $table->string('quality')->default('1080p'); // 720p, 1080p, 4K
            $table->bigInteger('views_count')->default(0); // Hitungan penonton
            $table->string('subtitle')->nullable();
            $table->timestamps();
        });
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            // Berelasi ke master film/series
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');

            $table->integer('season_number')->default(1);
            $table->integer('episode_number')->default(1);
            $table->string('title'); // Judul episode (misal: "Chapter One: The Vanishing")
            $table->string('slug')->unique();
            $table->text('description')->nullable(); // Deskripsi khusus episode
            $table->string('video'); // Path video lokal (contoh: video/202602111038.mp4)
            $table->string('duration')->nullable(); // Durasi episode (misal: "48 min")
            $table->bigInteger('views_count')->default(0);
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
        Schema::dropIfExists('movies');
        Schema::dropIfExists('episodes');
    }
}
