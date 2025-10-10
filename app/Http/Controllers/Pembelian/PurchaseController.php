<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function url_akses($akses, $id)
    {
        $data = DB::table('z_menu_user')
            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
            ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
            ->where('z_menu.menu_super_code', $id)
            ->where('z_menu_user.menu_sub_code', $akses)
            ->where('z_menu_user.access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    public function url_akses_sub($akses, $id)
    {
        $data = DB::table('z_menu_user_sub')
            ->join('z_menu_sub_main', 'z_menu_sub_main.menu_main_sub_code', '=', 'z_menu_user_sub.menu_main_sub_code')
            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_sub_main.menu_sub_code')
            ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
            ->where('z_menu.menu_super_code', $id)
            ->where('z_menu_user_sub.menu_main_sub_code', $akses)
            ->where('z_menu_user_sub.access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    // PURCHASE REQUEST
    public function purchase_req($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('pem_pr_req')->orderBy('id_pem_pr_req', 'DESC')->get();
            return view('app-pembelian.purchase.purchase-requisition', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function purchase_req_add(Request $request)
    {
        $user = DB::table('hrm_master_pegawai')->get();
        return view('app-pembelian.purchase.form.form-add-pr', ['user' => $user]);
    }
    public function purchase_req_save(Request $request)
    {
        try {
            $total = DB::table('pem_pr_req')->count();
            DB::table('pem_pr_req')->insert([
                'pem_pr_req_code' => str::uuid(),
                'pem_pr_req_nomor' => 'PR' . date('Ymd') . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
                'pem_pr_req_name' => $request->nama,
                'pem_pr_req_date' => $request->date,
                'pem_pr_req_date_require' => $request->date_req,
                'pem_pr_req_by' => $request->req_by,
                'pem_pr_req_app_by' => $request->app_by,
                'pem_pr_req_create_by' => Auth::user()->userid,
                'pem_pr_req_status' => 0,
                'created_at' => now()
            ]);
            return '<span class="badge bg-success">Mohon Tunggu</span>';
        } catch (\Throwable $e) {
            return '0';
        }

    }
    public function purchase_req_add_item(Request $request)
    {
        $info = DB::table('pem_pr_req')->where('pem_pr_req_code', $request->code)->first();
        if ($info->pem_pr_req_status == 0) {
            $item = DB::table('master_item')->get();
            $data = DB::table('pem_pr_req_data')
                ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                ->where('pem_pr_req_data.pem_pr_req_code', $request->code)->get();
            return view('app-pembelian.purchase.form.form-add-item-pr', [
                'code' => $request->code,
                'data' => $data,
                'info' => $info,
                'item' => $item
            ]);
        } else {
            return '<script>location.reload();</script>';
        }

    }
    public function purchase_req_add_item_data(Request $request)
    {
        try {
            $cek = DB::table('pem_pr_req_data')->where('pem_pr_req_code', $request->code)->where('master_item_code', $request->item)->first();
            if ($cek) {
                DB::table('pem_pr_req_data')->where('pem_pr_req_code', $request->code)->where('master_item_code', $request->item)->update([
                    'pem_pr_req_data_qty' => $request->qty + $cek->pem_pr_req_data_qty
                ]);
            } else {
                DB::table('pem_pr_req_data')->insert([
                    'pem_pr_req_data_code' => str::uuid(),
                    'pem_pr_req_code' => $request->code,
                    'master_item_code' => $request->item,
                    'pem_pr_req_data_name' => '-',
                    'pem_pr_req_data_type' => $request->type,
                    'pem_pr_req_data_qty' => $request->qty,
                    'created_at' => now(),
                ]);
            }
            $data = DB::table('pem_pr_req_data')
                ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                ->where('pem_pr_req_data.pem_pr_req_code', $request->code)->get();
            return view('app-pembelian.purchase.table.table-barang-request', ['data' => $data, 'code' => $request->code]);
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function purchase_req_remove_item_data(Request $request)
    {
        DB::table('pem_pr_req_data')->where('pem_pr_req_data_code', $request->id)->delete();
        $data = DB::table('pem_pr_req_data')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_req_data.pem_pr_req_code', $request->code)->get();
        return view('app-pembelian.purchase.table.table-barang-request', ['data' => $data, 'code' => $request->code]);
    }
    public function purchase_req_add_save_item(Request $request)
    {
        $cek = DB::table('pem_pr_req_data')->where('pem_pr_req_code', $request->code)->first();
        if ($cek) {
            $data = DB::table('pem_pr_req')->where('pem_pr_req_code', $request->code)->update([
                'pem_pr_req_status' => 1
            ]);
            return 'done';
        } else {
            return '0';
        }
    }
    public function purchase_req_verify(Request $request)
    {
        $info = DB::table('pem_pr_req')->where('pem_pr_req_code', $request->code)->first();
        $data = DB::table('pem_pr_req_data')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_req_data.pem_pr_req_code', $request->code)->get();
        return view('app-pembelian.purchase.form.form-verify-pr', ['code' => $request->code, 'data' => $data, 'info' => $info]);

    }
    public function purchase_req_verify_reject(Request $request)
    {
        return 333;
    }
    public function purchase_req_verify_save(Request $request)
    {
        $info = DB::table('pem_pr_req')->where('pem_pr_req_code', $request->code)->first();
        if ($info->pem_pr_req_status == 1) {
            DB::table('pem_pr_req')->where('pem_pr_req_code', $request->code)->update([
                'pem_pr_req_status' => 2
            ]);
            return '<script>location.reload();</script>';
        } else {
            return '<script>location.reload();</script>';
        }

    }
    public function purchase_req_preview_pr(Request $request)
    {
        return view('app-pembelian.purchase.form.form-preview-pr', ['code' => $request->code]);
    }
    public function purchase_req_report_pr(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('pem_pr_req')->where('pem_pr_req_code', $request->code)->first();
        $item = DB::table('pem_pr_req_data')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_req_data.pem_pr_req_code', $request->code)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-pembelian.purchase.report.report-purchase-request', [
            'data' => $data,
            'item' => $item,
            'code' => $request->code
        ], compact('image'))->setPaper('A5', 'potrait')->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                ]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
    }
    // PURCHASE ORDER
    public function purchase_order($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('pem_pr_order')
                ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
                ->orderBy('id_pem_pr_order', 'DESC')->get();
            return view('app-pembelian.purchase.purchase-order', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function purchase_order_add(Request $request)
    {
        $supp = DB::table('master_supplier')->get();
        $user = DB::table('hrm_master_pegawai')->get();
        return view('app-pembelian.purchase.form.form-add-pr-order', ['supp' => $supp, 'user' => $user]);
    }
    public function purchase_order_save(Request $request)
    {
        try {
            if ($request->ppn == 0) {
                $ppn = 0;
            } else {
                $ppn = 12;
            }

            $total = DB::table('pem_pr_order')->count();
            DB::table('pem_pr_order')->insert([
                'pem_pr_order_code' => str::uuid(),
                'pem_pr_req_code' => '-',
                'pem_pr_order_no' => 'PO' . date('Ymd') . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
                'pem_pr_order_date' => $request->date,
                'pem_pr_order_app' => $request->app_by,
                'pem_pr_order_ppn' => $request->ppn,
                'pem_pr_order_ppn_v' => $ppn,
                'master_supplier_code' => $request->supplier,
                'pem_pr_order_payment' => 0,
                'pem_pr_order_discount' => 0,
                'pem_pr_order_create_by' => Auth::user()->userid,
                'pem_pr_order_status' => 0,
                'created_at' => now(),
            ]);
            return 123;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function purchase_order_add_item(Request $request)
    {
        $info = DB::table('pem_pr_order')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
        $data = DB::table('pem_pr_req_data')
            ->join('pem_pr_req', 'pem_pr_req.pem_pr_req_code', '=', 'pem_pr_req_data.pem_pr_req_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('pem_pr_order_data')
                    ->whereColumn('pem_pr_req_data.pem_pr_req_data_code', 'pem_pr_order_data.pem_pr_req_data_code');
            })->where('pem_pr_req.pem_pr_req_status', 2)->get();
        $order = DB::table('pem_pr_order_data')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('pem_pr_req', 'pem_pr_req.pem_pr_req_code', '=', 'pem_pr_req_data.pem_pr_req_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
        return view('app-pembelian.purchase.form.form-add-item-order', [
            'code' => $request->code,
            'info' => $info,
            'data' => $data,
            'order' => $order
        ]);
    }
    public function purchase_order_pilih_item(Request $request)
    {
        $data = DB::table('pem_pr_req_data')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_req_data.pem_pr_req_data_code', $request->id)->first();
        return view('app-pembelian.purchase.form.form-pilih-barang-order', ['data' => $data, 'code' => $request->code]);
    }
    public function purchase_order_order_item(Request $request)
    {
        try {
            $nilai = preg_replace("/[^0-9]/", "", $request->harga);
            $info = DB::table('pem_pr_req_data')->where('pem_pr_req_data_code', $request->data_code)->first();
            DB::table('pem_pr_order_data')->insert([
                'pem_pr_order_data_code' => str::uuid(),
                'pem_pr_order_code' => $request->code,
                'pem_pr_req_data_code' => $request->data_code,
                'pem_pr_order_data_qty' => $info->pem_pr_req_data_qty,
                'pem_pr_order_data_harga' => $nilai,
                'pem_pr_order_data_discount' => $request->discount,
                'pem_pr_order_data_status' => 0,
                'created_at' => now(),
            ]);
            $data = DB::table('pem_pr_req_data')
                ->join('pem_pr_req', 'pem_pr_req.pem_pr_req_code', '=', 'pem_pr_req_data.pem_pr_req_code')
                ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('pem_pr_order_data')
                        ->whereColumn('pem_pr_req_data.pem_pr_req_data_code', 'pem_pr_order_data.pem_pr_req_data_code');
                })->get();
            $order = DB::table('pem_pr_order_data')
                ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
                ->join('pem_pr_req', 'pem_pr_req.pem_pr_req_code', '=', 'pem_pr_req_data.pem_pr_req_code')
                ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
            return view('app-pembelian.purchase.table.table-barang-order', [
                'data' => $data,
                'code' => $request->code,
                'order' => $order
            ]);
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function purchase_order_remove_item_order(Request $request)
    {
        DB::table('pem_pr_order_data')->where('pem_pr_order_code', $request->code)->where('pem_pr_req_data_code', $request->id)->delete();
        $data = DB::table('pem_pr_req_data')
            ->join('pem_pr_req', 'pem_pr_req.pem_pr_req_code', '=', 'pem_pr_req_data.pem_pr_req_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('pem_pr_order_data')
                    ->whereColumn('pem_pr_req_data.pem_pr_req_data_code', 'pem_pr_order_data.pem_pr_req_data_code');
            })->get();
        $order = DB::table('pem_pr_order_data')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('pem_pr_req', 'pem_pr_req.pem_pr_req_code', '=', 'pem_pr_req_data.pem_pr_req_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
        return view('app-pembelian.purchase.table.table-barang-order', [
            'data' => $data,
            'code' => $request->code,
            'order' => $order
        ]);
    }
    public function purchase_order_save_proses_order(Request $request)
    {
        $data = DB::table('pem_pr_order_data')->where('pem_pr_order_code', $request->code)->count();
        if ($data == 0) {
            return 0;
        } else {
            DB::table('pem_pr_order')->where('pem_pr_order_code', $request->code)->update([
                'pem_pr_order_status' => 1
            ]);
            return 'Saved';
        }

    }
    public function purchase_order_preview_send(Request $request)
    {

        $info = DB::table('pem_pr_order')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
        if ($info->pem_pr_order_status == 1) {
            $data = DB::table('pem_pr_order_data')
                ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
                ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
            return view('app-pembelian.purchase.form.form-preview-order', [
                'code' => $request->code,
                'info' => $info,
                'data' => $data
            ]);
        } else {
            return '<script>location.reload()</script>';
        }

    }
    public function purchase_order_preview_report(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('pem_pr_order_data')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
        $info = DB::table('pem_pr_order')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-pembelian.purchase.report.report-purchase-order', [
            'data' => $data,
            'info' => $info,
            'code' => $request->code
        ], compact('image'))->setPaper('A5', 'potrait')->setOptions(['defaultFont' => 'sans-serif']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
    }
    public function purchase_order_evaluasi_purchase_order(Request $request)
    {

        $info = DB::table('pem_pr_order')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
        if ($info->pem_pr_order_status == 2) {
            $data = DB::table('pem_pr_order_data')
                ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
                ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
            $payment = DB::table('pem_pr_order_payment')
                ->join('m_pay_detail', 'm_pay_detail.m_pay_detail_code', '=', 'pem_pr_order_payment.m_pay_detail_code')
                ->where('pem_pr_order_code', $request->code)->first();
            return view('app-pembelian.purchase.form.form-evaluasi-purchase-order', [
                'code' => $request->code,
                'info' => $info,
                'payment' => $payment,
                'data' => $data
            ]);
        } else {
            return '<script>location.reload()</script>';
        }
    }
    public function purchase_order_checklist_purchase_order(Request $request)
    {
        $data = DB::table('pem_pr_order_data')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', '.pem_pr_order_data.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_req_data.pem_pr_req_data_code', $request->code)->first();
        $data_supp = DB::table('pem_pr_order_datas')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', '.pem_pr_order_datas.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_order_datas.pem_pr_req_data_code', $request->code)->first();
        return view('app-pembelian.purchase.form.form-evaluasi-checklist-purchase-order', ['data' => $data, 'code' => $request->code, 'data_supp' => $data_supp]);
    }
    public function purchase_order_accept_purchase_order(Request $request)
    {
        DB::table('pem_pr_order_datas')->where('pem_pr_req_data_code', $request->id)->update([
            'pem_pr_order_datas_status' => 1
        ]);
        $info = DB::table('pem_pr_order')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
        $data = DB::table('pem_pr_order_data')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
        return view('app-pembelian.purchase.table.table-evaluasi-purchase-order', [
            'code' => $request->code,
            'info' => $info,
            'data' => $data
        ]);
    }
    public function purchase_order_save_send_purchase_order(Request $request)
    {
        $cek = DB::table('pem_pr_order_datas')->where('pem_pr_order_code', $request->code)->where('pem_pr_order_datas_status', '<', 1)->first();
        if ($cek) {
            return 0;
        } else {
            DB::table('pem_pr_order')->where('pem_pr_order_code', $request->code)->update([
                'pem_pr_order_status' => 3
            ]);
            return 'Berhasil Kirim';
        }

    }
    public function purchase_order_terima_barang(Request $request)
    {
        $info = DB::table('pem_pr_order')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
        $data = DB::table('pem_pr_order_data')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
        return view('app-pembelian.purchase.form.form-terima-barang-po', [
            'code' => $request->code,
            'info' => $info,
            'data' => $data
        ]);
    }
    public function purchase_order_terima_barang_order(Request $request)
    {
        DB::table('pem_pr_order_datas')->where('pem_pr_req_data_code', $request->id)->update([
            'pem_pr_order_datas_status' => 2
        ]);
        $info = DB::table('pem_pr_order')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_pr_order.pem_pr_order_code', $request->code)->first();
        $data = DB::table('pem_pr_order_data')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_pr_order_data.pem_pr_order_code', $request->code)->get();
        return view('app-pembelian.purchase.table.table-terima-barang-po', [
            'code' => $request->code,
            'info' => $info,
            'data' => $data
        ]);
    }
    public function purchase_order_save_and_generate_grn(Request $request)
    {
        $cek = DB::table('pem_pr_order_datas')->where('pem_pr_order_code', $request->code)->where('pem_pr_order_datas_status', '<', 2)->first();
        if ($cek) {
            return 0;
        } else {
            try {
                $data = DB::table('pem_pr_order')->where('pem_pr_order_code', $request->code)->first();
                $total = DB::table('pem_grn_token')->count();
                DB::table('pem_grn_token')->insert([
                    'pem_grn_token_code' => str::uuid(),
                    'pem_pr_order_code' => $request->code,
                    'pem_grn_token_number' => 'GRN' . date('Ymd') . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
                    'pem_grn_token_do' => $data->pem_pr_order_do,
                    'pem_grn_token_status' => 0,
                    'pem_grn_token_date' => now(),
                    'created_at' => now()
                ]);
                DB::table('pem_pr_order')->where('pem_pr_order_code', $request->code)->update([
                    'pem_pr_order_status' => 4
                ]);
                return 'Created GRN';
            } catch (\Throwable $e) {
                return 1;
            }
        }

    }
    // PURCHASE GRN
    public function goods_recived_note($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('pem_grn_token')
                ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_grn_token.pem_pr_order_code')
                ->join('pem_pr_order_payment', 'pem_pr_order_payment.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
                ->join('m_pay_detail', 'm_pay_detail.m_pay_detail_code', '=', 'pem_pr_order_payment.m_pay_detail_code')
                ->join('m_pay', 'm_pay.m_pay_code', '=', 'm_pay_detail.m_pay_code')
                ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
                ->orderBy('id_pem_grn_token', 'DESC')
                ->get();
            return view('app-pembelian.purchase.goods-recived-note', [
                'akses' => $akses,
                'code' => $id,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function goods_recived_note_detail(Request $request)
    {
        return view('app-pembelian.purchase.form.form-report-grn', ['code' => $request->code]);
    }
    public function goods_recived_note_report(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $info = DB::table('pem_pr_order')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_grn_token.pem_grn_token_code', $request->code)->first();
        $data = DB::table('pem_pr_order_data')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_data.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_grn_token.pem_grn_token_code', $request->code)->get();
        $data_supp = DB::table('pem_pr_order_datas')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_datas.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_grn_token.pem_grn_token_code', $request->code)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-pembelian.purchase.report.report-goods-recived-note', [
            'data' => $data,
            'data_supp' => $data_supp,
            'info' => $info,
            'code' => $request->code
        ], compact('image'))->setPaper('A5', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(200, 570, "{PAGE_NUM} / {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        // $canvas->page_script('
        //     // $pdf->set_opacity(.9);
        //     $pdf->image("img/cover.png", 12, 12, 400, 575);
        //     ');
        return base64_encode($pdf->stream());
    }
    public function goods_recived_note_pay(Request $request)
    {
        $data = DB::table('pem_grn_token')->where('pem_grn_token_code', $request->code)->first();
        if ($request->id == 'paynow') {
            $total = DB::table('pem_pr_cash')->count();
            DB::table('pem_pr_cash')->insert([
                'pem_pr_cash_code' => str::uuid(),
                'pem_pr_cash_no' => 'PI' . date('Ymd') . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
                'pem_grn_token_code' => $data->pem_grn_token_code,
                'pem_pr_order_code' => $data->pem_pr_order_code,
                'pem_pr_cash_price' => 0,
                'pem_pr_cash_status' => 1,
                'created_at' => now()
            ]);
            DB::table('pem_grn_token')->where('pem_grn_token_code', $request->code)->update([
                'pem_grn_token_metode' => $request->id,
                'pem_grn_token_invoice' => $request->no_invoice,
                'pem_grn_token_status' => 1
            ]);
            return $request->name . ' Berhasil';
        } elseif ($request->id == 'paylater') {
            $total = DB::table('pem_pr_invoice')->count();
            DB::table('pem_pr_invoice')->insert([
                'pem_pr_invoice_code' => str::uuid(),
                'pem_pr_invoice_no' => 'PI' . date('Ymd') . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
                'pem_grn_token_code' => $data->pem_grn_token_code,
                'pem_pr_order_code' => $data->pem_pr_order_code,
                'pem_pr_invoice_price' => 0,
                'pem_pr_invoice_status' => 1,
                'created_at' => now()
            ]);
            DB::table('pem_grn_token')->where('pem_grn_token_code', $request->code)->update([
                'pem_grn_token_metode' => $request->id,
                'pem_grn_token_invoice' => $request->no_invoice,
                'pem_grn_token_status' => 1
            ]);
            return $request->name . ' Berhasil';
        }

    }
    public function goods_recived_note_preview(Request $request)
    {
        return view('app-pembelian.purchase.form.form-report-grn-fix', ['code' => $request->code]);
    }
    public function goods_recived_note_preview_report(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $info = DB::table('pem_pr_order')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
            ->where('pem_grn_token.pem_grn_token_code', $request->code)->first();
        $data = DB::table('pem_pr_order_data')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_data.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_data.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_grn_token.pem_grn_token_code', $request->code)->get();
        $data_supp = DB::table('pem_pr_order_datas')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_datas.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('pem_grn_token.pem_grn_token_code', $request->code)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-pembelian.purchase.report.report-goods-recived-note', [
            'data' => $data,
            'data_supp' => $data_supp,
            'info' => $info,
            'code' => $request->code
        ], compact('image'))->setPaper('A5', 'potrait')->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                ]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(200, 570, "{PAGE_NUM} / {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
    }
    // PURCHASE INVOICE
    public function purchase_invoice($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('pem_pr_invoice')
                ->join('pem_grn_token', 'pem_grn_token.pem_grn_token_code', '=', 'pem_pr_invoice.pem_grn_token_code')
                ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_grn_token.pem_pr_order_code')
                ->join('pem_pr_order_payment', 'pem_pr_order_payment.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
                ->join('m_pay_detail', 'm_pay_detail.m_pay_detail_code', '=', 'pem_pr_order_payment.m_pay_detail_code')
                ->join('m_pay', 'm_pay.m_pay_code', '=', 'm_pay_detail.m_pay_code')
                ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
                ->get();
            return view('app-pembelian.purchase.purchase-invoice', [
                'akses' => $akses,
                'code' => $id,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function purchase_invoice_preview_report(Request $request)
    {
        return view('app-pembelian.purchase.form.form-report-purchase-invoice', ['code' => $request->code]);
    }
    public function purchase_invoice_print_report(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-pembelian.purchase.report.report-purchase-invoice', [
            'code' => $request->code
        ], compact('image'))->setPaper('A5', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(200, 570, "{PAGE_NUM} / {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
    }
    // PURCHASE INVOICE
    public function purchase_cash_purchase($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('pem_pr_cash')
                ->join('pem_grn_token', 'pem_grn_token.pem_grn_token_code', '=', 'pem_pr_cash.pem_grn_token_code')
                ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_grn_token.pem_pr_order_code')
                ->join('pem_pr_order_payment', 'pem_pr_order_payment.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
                ->join('m_pay_detail', 'm_pay_detail.m_pay_detail_code', '=', 'pem_pr_order_payment.m_pay_detail_code')
                ->join('m_pay', 'm_pay.m_pay_code', '=', 'm_pay_detail.m_pay_code')
                ->join('master_supplier', 'master_supplier.master_supplier_code', '=', 'pem_pr_order.master_supplier_code')
                ->get();
            return view('app-pembelian.purchase.cash-purchase', [
                'akses' => $akses,
                'code' => $id,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function purchase_cash_purchase_preview(Request $request)
    {
        return view('app-pembelian.purchase.form.form-report-cash-purchase', ['code' => $request->code]);
    }
    public function purchase_cash_purchase_print(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-pembelian.purchase.report.report-cash-purchase', [
            'code' => $request->code
        ], compact('image'))->setPaper('A5', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(200, 570, "{PAGE_NUM} / {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
    }
}
