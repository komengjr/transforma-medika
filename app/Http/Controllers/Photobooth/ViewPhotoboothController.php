<?php

namespace App\Http\Controllers\Photobooth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewPhotoboothController extends Controller
{
    public function show($code)
    {
        $result = PhotoboothResult::where('code', $code)->firstOrFail();
        return view('photobooth_show', compact('result'));
    }
}
