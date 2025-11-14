<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua id news
        $newsList = DB::table('news_data')->pluck('news_data_code')->toArray();

        if (empty($newsList)) {
            echo "⚠️ Tidak ada data news. Jalankan NewsSeeder dulu.\n";
            return;
        }

        // Set banyak rating yang ingin dibuat
        $totalRatings = 50;

        for ($i = 0; $i < $totalRatings; $i++) {

            DB::table('news_ratings')->insert([
                'news_data_code' => $newsList[array_rand($newsList)],
                'news_ratings_rating' => rand(1, 5),
                'news_ratings_user_ip' => $faker->ipv4(),
                'created_at' => now()->subDays(rand(0, 60)),
                'updated_at' => now(),
            ]);
        }
    }
}
