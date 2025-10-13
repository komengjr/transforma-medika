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
    public function product()
    {
        $product = DB::table('log_m_product')->get();
        return view('public.product', ['product' => $product]);
    }
    public function product_detail($detail)
    {
        $data = DB::table('log_m_product')->where('log_m_product_code', $detail)->first();
        $desc = DB::table('log_m_product_desc')->where('log_m_product_code', $detail)->first();
        return view('public.product.product-deatil', [
            'data' => $data,
            'desc' => $desc
        ]);
    }
    public function changelog()
    {
        return view('public.changelog');
    }
}
