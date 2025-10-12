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
    public function app_hrm()
    {
        return view('public.app-hrm');
    }
    public function app_medical()
    {
        return view('public.app-medical');
    }
    public function app_accounting()
    {
        return view('public.app-accounting');
    }
    public function app_inventaris()
    {
        return view('public.app-inventaris');
    }
    public function app_logistik()
    {
        return view('public.app-logistik');
    }
    public function app_purchase()
    {
        return view('public.app-purchase');
    }
    public function app_supplier()
    {
        return view('public.app-supplier');
    }
    public function changelog()
    {
        return view('public.changelog');
    }
}
