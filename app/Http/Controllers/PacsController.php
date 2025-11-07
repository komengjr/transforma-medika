<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PacsController extends Controller
{
    public function pacs_preview($id){
        return view('Pacs.preview');
    }
    public function pacs_antrian(){
        return view('antrian.display-try');
    }
}
