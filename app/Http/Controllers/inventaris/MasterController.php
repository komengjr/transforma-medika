<?php

namespace App\Http\Controllers\inventaris;

use App\Http\Controllers\Controller;
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

class MasterController extends Controller
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
            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
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
    // MASTER BARANG
    public function master_barang($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('inv_data_master')->where('inv_data_master_cabang', Auth::user()->access_cabang)->get();
            return view('app-inventaris.master.master-barang', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_barang_add(Request $request)
    {
        $class = DB::table('inv_data_class')->get();
        $loc = DB::table('inv_data_location')
            ->join('inv_master_location', 'inv_master_location.inv_master_location_code', '=', 'inv_data_location.inv_master_location_code')->get();
        return view('app-inventaris.master.master-barang.form-add-barang', [
            'class' => $class,
            'loc' => $loc,
        ]);
    }
    public function master_barang_add_upload_gambar(Request $request)
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
            $path = $disk->putFileAs('public/inventaris/data_barang/' . auth::user()->access_cabang, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);
            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('inventaris/data_barang/' . auth::user()->access_cabang . '/' . $fileName),
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
    public function master_barang_add_save_data(Request $request)
    {
        // $entitas = DB::table('tbl_entitas_cabang')
        //     ->join('tbl_cabang', 'tbl_cabang.kd_entitas_cabang', '=', 'tbl_entitas_cabang.kd_entitas_cabang')
        //     ->join('tbl_setting_cabang', 'tbl_setting_cabang.kd_cabang', '=', 'tbl_cabang.kd_cabang')
        //     ->where('tbl_setting_cabang.kd_cabang', Auth::user()->access_cabang)->first();
        $total = DB::table('inv_data_master')->where('inv_data_master_cabang', Auth::user()->access_cabang)->count();
        // $lokasi = DB::table('tbl_nomor_ruangan_cabang')->where('id_nomor_ruangan_cbaang', $request->lokasi)->first();
        $nilai = preg_replace("/[^0-9]/", "", $request->harga_perolehan);
        if ($request->link == null) {
            $link = null;
        } else {
            $link = 'inventaris/data_barang/' . Auth::user()->access_cabang . '/' . $request->link;
        }
        DB::table('inv_data_master')->insert([
            'inv_data_master_code' => Auth::user()->access_cabang . '' . date('Ymdhis') . '' . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
            'inv_data_master_name' => $request->nama_barang,
            'inv_data_location_code' => $request->lokasi,
            'id_inv_data_class_code' => $request->klasifikasi,
            // 'inventaris_data_number' => 'no belum dibuat',
            'inv_data_master_aset' => $request->jenis,
            'inv_data_master_harga' => $nilai,
            'inv_data_master_merk' => $request->merk,
            'inv_data_master_type' => $request->type,
            'inv_data_master_seri' => $request->seri,
            'inv_data_master_status' => 0,
            'inv_data_master_tgl_beli' => $request->tgl_beli,
            'inv_data_master_cabang' => Auth::user()->access_cabang,
            'inv_data_master_no' => $total + 1,
            'inv_data_master_file' => $link,
            'inv_data_master_supplier' => $request->suplier,
            'created_at' => now(),
        ]);
        return 'Sukses';
    }
    // MASTER LOKASI
    public function master_lokasi($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-inventaris.master.master-lokasi', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_barang_show_data(Request $request)
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
        $totalRecords = DB::table('inv_data_master')->where('inv_data_master_cabang', Auth::user()->access_cabang)->count();
        $totalRecordswithFilter = DB::table('inv_data_master')->select('count(*) as allcount')->where('inv_data_master_name', 'like', '%' . $searchValue . '%')->where('inv_data_master_cabang', Auth::user()->access_cabang)->count();

        // Fetch records
        $records = DB::table('inv_data_master')->orderBy('id_inv_data_master', $columnSortOrder)
            // ->join('tbl_pemeriksaan','tbl_pemeriksaan.kd_pemeriksaan','=','tbl_perusahaan_paket_log.kd_pemeriksaan')
            ->where('inv_data_master.inv_data_master_name', 'like', '%' . $searchValue . '%')
            ->where('inv_data_master_cabang', Auth::user()->access_cabang)
            ->select('inv_data_master.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        // $no = 1;
        foreach ($records as $record) {
            $id = $record->id_inv_data_master;
            $nama_barang = $record->inv_data_master_name;
            $kd_lokasi = $record->inv_data_location_code;
            $no_inventaris = $record->inv_data_master_code;
            $harga_perolehan = $record->inv_data_master_harga;
            $kd_inventaris = $record->id_inv_data_class_code;
            $merk = $record->inv_data_master_merk . ' <br> ' . $record->inv_data_master_type . ' <br> ' . $record->inv_data_master_seri;
            $tglbeli = date('d-m-Y', strtotime($record->inv_data_master_tgl_beli));
            $button = '<div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-Option="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-master-barang-xl" id="button-update-barang"
                                    data-code="' . $record->inv_data_location_code . '"><span class="far fa-edit"></span>
                                    Edit Barang</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                    // id="button-data-barang-cabang" data-code="' . $record->inv_data_location_code . '"><span
                                        class="fas fa-file-import"></span> -
                                    Import Excel</button>
                            </div>
                        </div>';
            // $ruangan = DB::table('tbl_nomor_ruangan_cabang')->where('id_nomor_ruangan_cbaang', $record->id_nomor_ruangan_cbaang)->first();
            if ($record->inv_data_master_file == "") {
                $gambar = '<div class="avatar avatar-3xl"> <img src="' . asset("img/app.png") . '" alt="" /> </div>';
            } else {
                $gambar = '<div class="avatar avatar-3xl"> <img src="' . Storage::url($record->inv_data_master_file) . '" alt="" /> </div>';
            }
            if ($record->inv_data_master_status == 0) {
                $status = '<span class="text-danger">Belum Aktif</span>';
            } elseif ($record->inv_data_master_status == 1) {
                $status = '<span class="text-primary">Aktif</span>';
            }


            $data_arr[] = array(
                "id" => $id,
                "nama_barang" => $nama_barang,
                "no_inventaris" => $no_inventaris,
                "harga_perolehan" => '<span class="text-warning">Rp.' . number_format($harga_perolehan, 0, ",", ".") . '</span>',
                "kd_inventaris" => $kd_inventaris,
                "kd_lokasi" => $kd_lokasi,
                "merk" => $merk,
                "tglbeli" => $tglbeli,
                "status_barang" => $kd_lokasi,
                "gambar" => $gambar,
                "status" => $status,
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
    // PENERIMAAN NOTA
    public function inventaris_penerimaan_nota($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-inventaris.keuangan.penerimaan-nota', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function inventaris_penerimaan_nota_add(Request $request)
    {
        $data = DB::table('inv_data_master')->where('inv_data_master_cabang', Auth::user()->access_cabang)->where('inv_data_master_status', 0)->get();
        $supp = DB::table('master_supplier')->get();
        $inv = DB::table('inv_data_invoice')->count();
        $code = 'INV' . date('Ymd') . str_pad($inv + 1, 4, '0', STR_PAD_LEFT);
        return view('app-inventaris.keuangan.form.form-add-nota', ['data' => $data, 'supp' => $supp, 'code' => $code]);
    }
    public function inventaris_penerimaan_nota_add_barang(Request $request)
    {
        return 123;
    }
    public function inventaris_penerimaan_nota_save(Request $request)
    {
        return 123;
    }
}
