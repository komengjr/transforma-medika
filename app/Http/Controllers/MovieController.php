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
        $moviee = DB::table('movies')->get();
        return view('boxoffice', ['moviee' => $moviee], compact('movies'));
    }

    public function show(Movie $movie)
    {
        return view('movie-player', compact('movie'));
    }
}
