<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function fisrt()
    {

        return view('index');
    }
    public function app_hrm(){
        return view('public.app-hrm');
    }
    public function changelog()
    {
        return view('public.changelog');
    }
}
