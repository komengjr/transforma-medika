<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function display_antrian(){
        return view('antrian.display-try');
    }
    public function both_antrian(){
        return view('antrian.both-antiran');
    }
}
