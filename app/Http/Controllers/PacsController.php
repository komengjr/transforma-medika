<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PacsController extends Controller
{
    public function pacs_preview($id){
        return view('Pacs.preview');
    }

}
