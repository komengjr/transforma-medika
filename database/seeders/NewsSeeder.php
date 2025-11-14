<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); // FIX: gunakan Faker manual
        $categories = DB::table('news_categori')->pluck('news_categori_code')->toArray();

        // Jika kategori belum ada, hentikan proses
        if (empty($categories)) {
            echo "⚠️ Tidak ada kategori. Jalankan CategoriesSeeder dulu.\n";
            return;
        }

        $newsList = [
            'Pemerintah Umumkan Kebijakan Baru untuk Ekonomi Nasional',
            'Teknologi AI Semakin Berkembang Tahun 2025',
            'Timnas Indonesia Berhasil Menang di Laga Uji Coba',
            'Harga Emas Dunia Mengalami Kenaikan Tajam',
            'Film dan Musik Mendominasi Dunia Hiburan Tahun Ini',
            'Ahli Kesehatan Peringatkan Pola Hidup Tidak Sehat Generasi Muda',
            'Sekolah di Indonesia Akan Terapkan Kurikulum Baru',
            'Tren Fashion Urban Makin Populer di Kalangan Anak Muda',
            'Kasus Kriminalitas Menurun Berkat Peningkatan Pengamanan',
            'Berita Internasional: Negara Besar Sepakati Kerja Sama Baru',
        ];

        foreach ($newsList as $title) {

            DB::table('news_data')->insert([
                'news_data_code' => str::uuid(),
                'news_categori_code' => $categories[array_rand($categories)],
                'news_data_title' => $title,
                'news_data_slug' => Str::slug($title) . '-' . rand(100, 999),
                'news_data_content' => $faker->paragraphs(8, true),
                'news_data_thumbnail' => 'https://c.files.bbci.co.uk/CB18/production/_123329915_index-nc.png',
                'news_data_author' => $faker->name(),
                'news_data_published_at' => now()->subDays(rand(0, 60)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
