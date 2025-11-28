<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\EventModel;
use App\Models\Event\SubEventModel;
use App\Models\Movie;
use App\Models\NewsCat;
use App\Models\NewsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class EventController extends Controller
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
    public function menu_event_create($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $cat = NewsCat::latest()->get();
            return view('app-event.menu-event.create-event', ['akses' => $akses, 'code' => $id, 'cat' => $cat]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_event_create_save(Request $request)
    {
        if ($request->link_cover == '') {
            $cover = null;
        } else {
            $cover = 'event/cover/' . auth::user()->userid . '/' . $request->link_cover;
        }
        try {
            EventModel::insert([
                'event_data_code' => 'EVENT' . $request->data_code,
                'event_data_tittle' => $request->title,
                'event_data_start_date' => $request->start_date,
                'event_data_end_date' => $request->end_date,
                'event_data_reg_deadline' => $request->end_date,
                'event_data_venue' => $request->venue,
                'event_data_address' => $request->address,
                'event_data_city' => $request->city,
                'event_data_status' => 0,
                'event_data_desc' => $request->desc,
                'event_data_cover' => $cover,
                'event_data_template' => 'event/template/' . auth::user()->userid . '/' . $request->link,
                'event_data_user_id' => Auth::user()->userid,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return $e;
        }
    }
    public function menu_event_data_upload_template(Request $request)
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
            $path = $disk->putFileAs('public/event/template/' . auth::user()->userid, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('/event/template/' . auth::user()->userid . '/' . $fileName),
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
    public function menu_event_data_upload_cover(Request $request)
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
            $path = $disk->putFileAs('public/event/cover/' . auth::user()->userid, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('/event/cover/' . auth::user()->userid . '/' . $fileName),
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
    public function menu_event_data($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = EventModel::latest()->get();
            return view('app-event.menu-event.data-event', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_event_data_add_sub_event(Request $request)
    {
        return view('app-event.menu-event.data-event.form-add-sub-event', ['code' => $request->code]);
    }
    public function menu_event_data_save_sub_event(Request $request)
    {
        try {
            $total = SubEventModel::where('event_data_code', $request->data_code)->count();
            $total = $total + 1;
            SubEventModel::insert([
                'event_data_sub_code' => $request->data_code . '' . str_pad($total, 3, '0', STR_PAD_LEFT),
                'event_data_code' => $request->data_code,
                'event_data_sub_name' => $request->name,
                'event_data_sub_start' => $request->start,
                'event_data_sub_end' => $request->end,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function menu_event_data_detail_event(Request $request)
    {
        $data = EventModel::where('event_data_code', $request->code)->first();
        $sub_event = SubEventModel::where('event_data_code', $request->code)->get();
        return view('app-event.menu-event.data-event.form-detail-event', ['code' => $request->code], compact('data', 'sub_event'));
    }
    public function menu_event_data_detail_event_add_type(Request $request){
        return view('app-event.menu-event.data-event.form-add-type-peserta');
    }
    public function menu_event_data_detail_event_save_class(Request $request){
        return view('app-event.menu-event.data-event.data-table-event-class');
    }
}
