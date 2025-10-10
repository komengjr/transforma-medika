<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OcrController extends Controller
{
    public function scan_passport()
    {

        return view('reader');
    }
}
