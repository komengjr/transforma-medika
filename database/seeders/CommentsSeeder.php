<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua id berita
        $newsList = DB::table('news_data')->pluck('news_data_code')->toArray();

        if (empty($newsList)) {
            echo "⚠️ Tidak ada data news. Jalankan NewsSeeder dulu.\n";
            return;
        }

        // Jumlah komentar yg ingin dibuat
        $totalComments = 80;

        for ($i = 0; $i < $totalComments; $i++) {
            DB::table('news_comments')->insert([
                'news_data_code' => $newsList[array_rand($newsList)],
                'news_comments_user_name' => $faker->name(),
                'news_comments_comment' => $faker->paragraph(rand(1, 3)),
                'created_at' => now()->subDays(rand(0, 60)),
                'updated_at' => now(),
            ]);
        }
    }
}
