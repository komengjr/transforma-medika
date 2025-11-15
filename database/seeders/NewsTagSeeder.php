<?php

namespace Database\Seeders;

use App\Models\NewsData;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class NewsTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsList = NewsData::all();
        $tags = Tag::all()->pluck('id_news_tag')->toArray();

        foreach ($newsList as $news) {

            // pilih 1 sampai 4 tag acak
            $randomTags = collect($tags)->shuffle()->take(rand(1, 4))->toArray();

            // attach ke pivot
            $news->tags()->syncWithoutDetaching($randomTags);
        }
    }
}
