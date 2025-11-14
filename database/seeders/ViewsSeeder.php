<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ViewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $newsList = DB::table('news_data')->pluck('news_data_code')->toArray();

        if (empty($newsList)) {
            echo "⚠️ Tidak ada data news. Jalankan NewsSeeder dulu.\n";
            return;
        }

        for ($i = 0; $i < 300; $i++) {
            DB::table('news_view')->insert([
                'news_data_code' => $newsList[array_rand($newsList)],
                'news_view_user_ip' => $faker->ipv4(),
                'news_view_user_agent' => $faker->userAgent(),
                'news_view_date' => $faker->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
