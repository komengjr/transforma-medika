<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->paginate(12);
        $moviee = Movie::latest()->get();
        return view('boxoffice', compact('movies','moviee'));
    }

    public function show(Movie $movie)
    {
        return view('movie-player', compact('movie'));
    }
}
