<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function fisrt()
    {
        $app = DB::table('z_menu_super')->get();
        $menu = DB::table('z_menu')->get();
        return view('index', [
            'app' => $app,
            'menu' => $menu
        ]);
    }
    public function changelog()
    {
        $app = DB::table('z_menu_super')->get();
        $menu = DB::table('z_menu')->get();
        return view('public.changelog', [
            'app' => $app,
            'menu' => $menu
        ]);
    }
}
