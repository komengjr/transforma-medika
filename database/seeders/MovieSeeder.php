<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movies = [
            [
                'title' => 'Avengers: Endgame',
                'description' => 'The final battle to defeat Thanos and save the universe.',
                'poster' => 'https://image.tmdb.org/t/p/w500/ulzhLuWrPK07P1YkdWQLZnQh1JL.jpg',
                'video' => 'sample.mp4',
            ],
            [
                'title' => 'The Batman',
                'description' => 'Gotham City’s new guardian faces the Riddler.',
                'poster' => 'https://image.tmdb.org/t/p/w500/74xTEgt7R36Fpooo50r9T25onhq.jpg',
                'video' => 'sample.mp4',
            ],
            [
                'title' => 'Interstellar',
                'description' => 'A journey beyond the stars to save humanity.',
                'poster' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
                'video' => 'sample.mp4',
            ],
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
