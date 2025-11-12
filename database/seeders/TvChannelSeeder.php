<?php

namespace Database\Seeders;

use App\Models\TvChannel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TvChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TvChannel::insert([
            [
                'name' => 'Trans TV',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/65/Trans_TV_logo_2013.svg',
                'type' => 'hls',
                'stream_url_or_id' => 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8'
            ],
            [
                'name' => 'Kompas TV',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/id/8/89/Kompas_TV_logo_2017.svg',
                'type' => 'hls',
                'stream_url_or_id' => 'https://test-streams.mux.dev/test_001/stream.m3u8'
            ],
            [
                'name' => 'CNN Indonesia (YouTube)',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/id/9/9e/CNN_Indonesia_logo.svg',
                'type' => 'youtube',
                'stream_url_or_id' => '5qap5aO4i9A' // contoh live YouTube ID
            ],
        ]);
    }
}
