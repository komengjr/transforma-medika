<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->paginate(12);
        return view('boxoffice', compact('movies'));
    }

    public function show(Movie $movie)
    {
        return view('movie-player', compact('movie'));
    }
    public function nonotn_tv()
    {
        return view('nonton-tv');
    }
    public function movies_series(){
        return view('series.movies-series');
    }
}
