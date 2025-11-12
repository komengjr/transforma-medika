<?php

namespace App\Http\Controllers;

use App\Models\TvChannel;
use Illuminate\Http\Request;

class LiveTvController extends Controller
{
    public function index(Request $request)
    {
        $channels = TvChannel::all();
        return view('live-tv', compact('channels'));
    }
}
