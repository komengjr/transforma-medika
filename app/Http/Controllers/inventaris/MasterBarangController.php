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

class MasterBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function url_akses($akses)
    {
        $data = DB::table('z_menu_user')->where('menu_sub_code', $akses)->where('access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    public function url_akses_sub($akses)
    {
        $data = DB::table('z_menu_user_sub')->where('menu_main_sub_code', $akses)->where('access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    public function master_barang($akses, $id)
    {
        if ($this->url_akses($akses) == true) {
            return view('app-inventaris.master.master-barang', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_barang_add(Request $request)
    {
        $class = DB::table('inv_data_class')->get();
        $loc = DB::table('inv_data_location')
        ->join('inv_master_location','inv_master_location.inv_master_location_code','=','inv_data_location.inv_master_location_code')->get();
        return view('app-inventaris.master.master-barang.form-add-barang',[
            'class'=>$class,
            'loc'=>$loc,
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
}
