<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Teknologi',
            'Game',
            'Politik',
            'Bisnis',
            'Kesehatan',
            'Olahraga',
            'Gaya Hidup',
            'Hiburan',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'news_tag_name' => $tag,
                'news_tag_slug' => Str::slug($tag),
            ]);
        }
    }
}
