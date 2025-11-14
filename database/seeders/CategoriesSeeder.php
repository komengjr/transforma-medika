<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Politik',
            'Teknologi',
            'Olahraga',
            'Ekonomi',
            'Hiburan',
            'Kesehatan',
            'Pendidikan',
            'Gaya Hidup',
            'Kriminal',
            'Internasional'
        ];

        foreach ($categories as $cat) {
            DB::table('news_categori')->insert([
                'news_categori_code' => str::uuid(),
                'news_categori_name' => $cat,
                'news_categori_slug' => Str::slug($cat),
                'news_categori_desc' => $cat . ' - kategori berita.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
