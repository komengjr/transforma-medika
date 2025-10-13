<?php

namespace App\Http\Controllers\Logsitik;

use App\Http\Controllers\Controller;
use App\Imports\ItemsImport;
use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class LogistikController extends Controller
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
    // PRODUCT IN
    public function transaction_product_in($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('log_schedule_product')->orderBy('id_schedule_product', 'DESC')->get();
            return view('app-logistik.menu.transaction-product-in', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function transaction_product_in_add_schedule(Request $request)
    {

        return view('app-logistik.menu.form.form-add-schedule');
    }
    public function transaction_product_in_save_schedule(Request $request)
    {
        $total = DB::table('log_schedule_product')->count();
        DB::table('log_schedule_product')->insert([
            'schedule_product_code' => 'SCH' . date('Ymdhis') . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
            'schedule_product_name' => $request->name,
            'schedule_product_date' => $request->date,
            'schedule_product_by' => Auth::user()->userid,
            'schedule_product_status' => 0,
            'created_at' => now()
        ]);
        return 'Done';
    }
    public function transaction_product_in_incoming(Request $request)
    {
        $data = DB::table('pem_pr_order_datas')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_datas.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('log_m_product_in')
                    ->whereColumn('log_m_product_in.pem_pr_order_datas_code', 'pem_pr_order_datas.pem_pr_order_datas_code');
            })
            ->where('pem_pr_order_datas.pem_pr_order_datas_status', 2)
            ->where('master_item.master_item_type', 'brg')->get();
        $product = DB::table('log_m_product_in')
            ->join('pem_pr_order_datas', 'pem_pr_order_datas.pem_pr_order_datas_code', '=', 'log_m_product_in.pem_pr_order_datas_code')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_datas.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('master_item.master_item_type', 'brg')
            ->where('log_m_product_in.schedule_product_code', $request->code)->get();
        return view('app-logistik.menu.form.form-barang-masuk', [
            'data' => $data,
            'code' => $request->code,
            'product' => $product
        ]);
    }
    public function transaction_product_in_incoming_check(Request $request)
    {
        DB::table('log_m_product_in')->insert([
            'log_m_product_in_code' => str::uuid(),
            'schedule_product_code' => $request->id,
            'pem_pr_order_datas_code' => $request->code,
            'log_m_product_in_date' => now(),
            'log_m_product_in_status' => 1,
            'created_at' => now(),
        ]);
        $data = DB::table('pem_pr_order_datas')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_datas.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('log_m_product_in')
                    ->whereColumn('log_m_product_in.pem_pr_order_datas_code', 'pem_pr_order_datas.pem_pr_order_datas_code');
            })->where('pem_pr_order_datas.pem_pr_order_datas_status', 2)
            ->where('master_item.master_item_type', 'brg')
            ->get();
        $product = DB::table('log_m_product_in')
            ->join('pem_pr_order_datas', 'pem_pr_order_datas.pem_pr_order_datas_code', '=', 'log_m_product_in.pem_pr_order_datas_code')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_datas.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('master_item.master_item_type', 'brg')
            ->where('log_m_product_in.schedule_product_code', $request->id)->get();
        return view('app-logistik.menu.table.table-barang-masuk', [
            'data' => $data,
            'code' => $request->id,
            'product' => $product
        ]);
    }
    public function transaction_product_in_pilih_barang(Request $request)
    {
        return view('app-logistik.menu.form.form-pilih-barang');
    }
    public function transaction_product_in_save_incoming(Request $request)
    {
        $cekbarang = DB::table('log_m_product_in')->where('schedule_product_code', $request->code)->count();
        if ($cekbarang == 0) {
            return 0;
        } else {
            DB::table('log_schedule_product')->where('schedule_product_code', $request->code)->update([
                'schedule_product_status' => 1
            ]);
            return 123;
        }
    }
    public function transaction_product_in_preview_schedule(Request $request)
    {
        return view('app-logistik.menu.form.form-preview-product-in', ['code' => $request->code]);
    }
    public function transaction_product_in_preview_report(Request $request)
    {
        $product = DB::table('log_m_product_in')
            ->join('pem_pr_order_datas', 'pem_pr_order_datas.pem_pr_order_datas_code', '=', 'log_m_product_in.pem_pr_order_datas_code')
            ->join('pem_pr_order', 'pem_pr_order.pem_pr_order_code', '=', 'pem_pr_order_datas.pem_pr_order_code')
            ->join('pem_grn_token', 'pem_grn_token.pem_pr_order_code', '=', 'pem_pr_order.pem_pr_order_code')
            ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
            ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
            ->where('master_item.master_item_type', 'brg')
            ->where('log_m_product_in.schedule_product_code', $request->code)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $fontPath = asset('font/Danzallama-Regular-ttf.ttf');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-logistik.report.report-product-in', [
            'code' => $request->code,
            'product' => $product
        ], compact('image'))->setPaper('A5', 'potrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font($fontPath);
        $dompdf->get_canvas()->page_text(200, 570, "{PAGE_NUM} / {PAGE_COUNT}", $fontPath, 8, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
    }
    // PRODUCT OUT
    public function transaction_product_out($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('pem_pr_req')->orderBy('id_pem_pr_req', 'DESC')->get();
            return view('app-logistik.menu.transaction-product-out', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER ITEM
    public function master_logistik_item($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-logistik.master.master-item', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_logistik_data_item(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = DB::table('master_item')->count();
        $totalRecordswithFilter = DB::table('master_item')->select('count(*) as allcount')->where('master_item_name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = DB::table('master_item')->orderBy('id_master_item', $columnSortOrder)
            ->where('master_item.master_item_name', 'like', '%' . $searchValue . '%')
            ->select('master_item.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        $no = $start + 1;
        foreach ($records as $record) {
            $id = $no++;
            $item_code = $record->master_item_code;
            $item_name = $record->master_item_name;
            $item_type = $record->master_item_type;
            $item_opt = $record->master_item_opt;
            $item_class = $record->master_item_class;
            $barcode = $record->master_item_barcode;
            $button = '<div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-Option="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-master-barang-xl" id="button-update-barang"
                                    data-code="' . $record->master_item_code . '"><span class="far fa-edit"></span>
                                    Edit Barang</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                    // id="button-data-barang-cabang" data-code="' . $record->master_item_code . '"><span
                                        class="fas fa-file-import"></span> -
                                    Import Excel</button>
                            </div>
                        </div>';
            // $ruangan = DB::table('tbl_nomor_ruangan_cabang')->where('id_nomor_ruangan_cbaang', $record->id_nomor_ruangan_cbaang)->first();
            if ($record->master_item_pic == "") {
                $gambar = '<div class="avatar avatar-3xl"> <img src="' . asset("img/product.png") . '" alt="" /> </div>';
            } else {
                $gambar = '<div class="avatar avatar-3xl"> <img src="' . Storage::url($record->master_item_pic) . '" alt="" /> </div>';
            }
            if ($record->master_item_status == 0) {
                $status = '<span class="badge bg-danger">Belum Aktif</span>';
            } elseif ($record->master_item_status == 1) {
                $status = '<span class="badge bg-primary">Aktif</span>';
            }
            if ($record->master_item_class == 'BHP') {
                $class = '<span class="text-warning">Bahan Habis Pakai</span>';
            } elseif ($record->master_item_class == 'BTHP') {
                $class = '<span class="text-success">Bahan Tak Habis Pakai</span>';
            } else {
                $class = '<span class="text-danger">Tidak ditemukan</span>';
            }

            $data_arr[] = array(
                "id" => $id,
                "item_code" => $item_code,
                "item_name" => $item_name,
                "item_type" => $item_type,
                "item_opt" => $item_opt,
                "item_class" => $class,
                "item_status" => $status,
                "barcode" => $barcode,
                "gambar" => $gambar,
                "btn" => $button
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }
    public function master_logistik_add_item(Request $request)
    {
        return view('app-logistik.master.form.form-add-item');
    }
    public function master_logistik_add_item_upload_file(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name
            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('public/logistik/data_item/' . auth::user()->access_cabang, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);
            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('logistik/data_item/' . auth::user()->access_cabang . '/' . $fileName),
                'filename' => $fileName
            ];
        }
        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
    public function master_logistik_add_item_clear_file(Request $request)
    {
        Storage::delete('public/logistik/data_item/' . auth::user()->access_cabang . '/' . $request->link);
        return 'ok';
    }
    public function master_logistik_save_item(Request $request)
    {
        if ($request->link == null) {
            $link = null;
        } else {
            $link = 'logistik/data_item/' . Auth::user()->access_cabang . '/' . $request->link;
        }
        $total = DB::table('master_item')->count();
        try {
            DB::table('master_item')->insert([
                'master_item_code' => str::uuid() . '-' . str_pad($total + 1, 10, '0', STR_PAD_LEFT),
                'master_item_name' => $request->name,
                'master_item_type' => $request->type,
                'master_item_class' => $request->class,
                'master_item_opt' => $request->satuan,
                'master_item_barcode' => $request->barcode,
                'master_item_status' => 1,
                'master_item_pic' => $link,
                'created_at' => now()
            ]);
            return '<button class="btn btn-outline-success">Berhasil</button>';
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_logistik_save_item_upload_file(Request $request)
    {
        return view('app-logistik.master.form.form-upload-file-item');
    }
    public function master_logistik_proses_item_upload_file(Request $request)
    {
        Excel::import(new ItemsImport('class', 'brg'), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
    // MASTER PRODUCT
    public function master_logistik_product($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('pem_pr_req')->orderBy('id_pem_pr_req', 'DESC')->get();
            return view('app-logistik.master.master-product', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_logistik_data_product(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = DB::table('log_m_product')->count();
        $totalRecordswithFilter = DB::table('log_m_product')->select('count(*) as allcount')->where('log_m_product_name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = DB::table('log_m_product')->orderBy('id_log_m_product', $columnSortOrder)
            ->join('log_m_class', 'log_m_class.log_m_class_code', '=', 'log_m_product.log_m_class_code')
            ->join('log_m_type', 'log_m_type.log_m_type_code', '=', 'log_m_product.log_m_type_code')
            ->where('log_m_product.log_m_product_name', 'like', '%' . $searchValue . '%')
            ->select('log_m_product.*', 'log_m_class.*', 'log_m_type.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        // $no = 1;
        foreach ($records as $record) {
            $id = $record->id_log_m_product;
            $id_product = $record->log_m_product_code;
            $nama_product = $record->log_m_product_name;
            $class = $record->log_m_class_name;
            $type = $record->log_m_type_name;
            $qr = $record->log_m_product_name;
            $button = '<div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-Option="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-master-barang-xl" id="button-update-barang"
                                    data-code="' . $record->log_m_product_name . '"><span class="far fa-edit"></span>
                                    Edit Barang</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                    // id="button-data-barang-cabang" data-code="' . $record->log_m_product_name . '"><span
                                        class="fas fa-file-import"></span> -
                                    Import Excel</button>
                            </div>
                        </div>';
            // $ruangan = DB::table('tbl_nomor_ruangan_cabang')->where('id_nomor_ruangan_cbaang', $record->id_nomor_ruangan_cbaang)->first();
            if ($record->log_m_product_file == "") {
                $gambar = '<div class="avatar avatar-3xl"> <img src="' . asset("img/product.png") . '" alt="" /> </div>';
            } else {
                $gambar = '<div class="avatar avatar-3xl"> <img src="' . Storage::url($record->log_m_product_file) . '" alt="" /> </div>';
            }
            if ($record->log_m_product_status == 0) {
                $status = '<span class="text-danger">Belum Aktif</span>';
            } elseif ($record->log_m_product_status == 1) {
                $status = '<span class="text-primary">Aktif</span>';
            }


            $data_arr[] = array(
                "id" => $id,
                "id_product" => $id_product,
                "nama_product" => $nama_product,
                "class" => $class,
                "type" => $type,
                "status" => $status,
                "qr" => $qr,
                "gambar" => $gambar,
                "btn" => $button
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }
    public function master_logistik_add_product(Request $request)
    {
        $type = DB::table('log_m_type')->get();
        $class = DB::table('log_m_class')->get();
        return view('app-logistik.master.form.form-add-product', ['type' => $type, 'class' => $class]);
    }
    public function master_logistik_add_product_upload_file(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name
            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('public/logistik/data_product/' . auth::user()->access_cabang, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);
            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('logistik/data_product/' . auth::user()->access_cabang . '/' . $fileName),
                'filename' => $fileName
            ];
        }
        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
    public function master_logistik_add_product_clear_file(Request $request)
    {
        Storage::delete('public/logistik/data_product/' . auth::user()->access_cabang . '/' . $request->link);
        return 'ok';
    }
    public function master_logistik_save_product(Request $request)
    {
        if ($request->link == null) {
            $link = null;
        } else {
            $link = 'logistik/data_product/' . Auth::user()->access_cabang . '/' . $request->link;
        }
        $total = DB::table('log_m_product')->count();
        try {
            DB::table('log_m_product')->insert([
                'log_m_product_code' => 'PRO' . str_pad($total + 1, 10, '0', STR_PAD_LEFT),
                'log_m_product_name' => $request->nama_product,
                'log_m_class_code' => $request->klasifikasi,
                'log_m_type_code' => $request->jenis,
                'log_m_product_status' => 1,
                'log_m_product_qr' => str::uuid(),
                'log_m_product_file' => $link,
                'created_at' => now()
            ]);
            return '<button class="btn btn-outline-success">Berhasil</button>';
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_logistik_upload_file_product(Request $request)
    {
        return view('app-logistik.master.form.form-upload-file-product');
    }
    public function master_logistik_proses_product_upload_file(Request $request)
    {
        Excel::import(new ProductImport($request->type, 454), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
}
