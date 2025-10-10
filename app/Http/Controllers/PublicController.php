<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    public function app_supp_token($id, $token)
    {
        $info = DB::table('pem_pr_order')->where('pem_pr_order_code', $token)->first();
        if ($info) {
            if ($info->pem_pr_order_status == 1) {
                return view('auth.verifikasi-po', ['info' => $info]);
            } else {
                return view('auth.supplier.error');
            }
        } else {
            return view('auth.supplier.error');
        }
    }
    public function app_supp_user_token(Request $request)
    {
        if ($request->email == 'agus') {
            $info = DB::table('pem_pr_order')
                ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
                ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
            // DB::table('pem_pr_order')->where('pem_pr_order.pem_pr_order_code', $request->code)->update([
            //     'pem_pr_order_status' => 1
            // ]);
            $data = DB::table('pem_pr_order_data')
                ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
                ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
            return view('auth.supplier.form-2', ['info' => $info, 'data' => $data]);
        } else {
            return 0;
        }

    }
    public function app_supp_update_order(Request $request)
    {
        $data = DB::table('pem_pr_order_data')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_order_data.pem_pr_order_data_code', $request->code)
            ->first();
        return view('auth.supplier.form-update-order', ['data' => $data, 'code' => $request->code, 'id' => $request->id]);
    }
    public function app_supp_simpan_order(Request $request)
    {
        try {
            $nilai = preg_replace("/[^0-9]/", "", $request->harga);
            $cek = DB::table('pem_pr_order_datas')->where('pem_pr_order_code', $request->code)->where('pem_pr_req_data_code', $request->data_code)->first();
            if ($cek) {
                $cek = DB::table('pem_pr_order_datas')->where('pem_pr_order_code', $request->code)->where('pem_pr_req_data_code', $request->data_code)->update([
                    'pem_pr_order_datas_qty' => $request->jumlah,
                    'pem_pr_order_datas_harga' => $nilai,
                    'pem_pr_order_datas_discount' => $request->discount,
                ]);
            } else {
                DB::table('pem_pr_order_datas')->insert([
                    'pem_pr_order_datas_code' => Str::uuid(),
                    'pem_pr_order_code' => $request->code,
                    'pem_pr_req_data_code' => $request->data_code,
                    'pem_pr_order_datas_qty' => $request->jumlah,
                    'pem_pr_order_datas_harga' => $nilai,
                    'pem_pr_order_datas_discount' => $request->discount,
                    'pem_pr_order_datas_status' => 0,
                    'created_at' => now()
                ]);
            }
            $info = DB::table('pem_pr_order')
                ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
                ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
            $data = DB::table('pem_pr_order_data')
                ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
                ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
            return view('auth.supplier.table-order-supplier', ['info' => $info, 'data' => $data]);
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function app_supp_user_token_next(Request $request)
    {
        $order = DB::table('pem_pr_order_data')->where('pem_pr_order_code', $request->code)->count();
        $order1 = DB::table('pem_pr_order_datas')->where('pem_pr_order_code', $request->code)->count();
        if ($order == $order1) {
            $pay = DB::table('m_pay_detail')->join('m_pay', 'm_pay.m_pay_code', '=', 'm_pay_detail.m_pay_code')->get();
            return view('auth.supplier.form-3', ['pay' => $pay, 'code' => $request->code]);
        } else {
            return 0;
        }
    }
    public function app_supp_user_token_last(Request $request)
    {

        $order = DB::table('pem_pr_order_data')->where('pem_pr_order_code', $request->code)->count();
        $order1 = DB::table('pem_pr_order_datas')->where('pem_pr_order_code', $request->code)->count();
        if ($order == $order1) {
            DB::table('pem_pr_order')->where('pem_pr_order_code', $request->code)->update([
                'pem_pr_order_status' => 2,
                'pem_pr_order_do' => $request->faktur
            ]);
            if ($request->payment == 'PAY001001') {
                $rek = '-';
            } else {
                $rek = $request->rek;
            }

            DB::table('pem_pr_order_payment')->insert([
                'pem_pr_order_payment_code' => 'PO-PAY-' . date('Ymdhis'),
                'pem_pr_order_code' => $request->code,
                'm_pay_detail_code' => $request->payment,
                'pem_pr_order_payment_no_rek' => $rek,
                'pem_pr_order_payment_termin' => $request->termin,
                'pem_pr_order_payment_price' => 0,
                'pem_pr_order_payment_status' => 0,
                'created_at' => now()
            ]);
            return view('auth.supplier.form-4');
        } else {
            return 0;
        }
    }
    public function app_testpdf()
    {

        $data = [

            'title' => 'Welcome to ItSolutionStuff.com',

        ];



        $pdf = PDF::loadView('app-logistik.report.report-product-in', $data);



        return $pdf->download('itsolutionstuff.pdf');
    }
}
