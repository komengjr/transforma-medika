<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\EventModel;
use App\Models\Movie;
use App\Models\NewsCat;
use App\Models\NewsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

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
        EventModel::insert([
            'event_data_code' => 'EVENT' . date('Ymdhis'),
            'event_data_tittle' => $request->title,
            'event_data_start_date' => $request->start_date,
            'event_data_end_date' => $request->end_date,
            'event_data_reg_deadline' => $request->end_date,
            'event_data_venue' => $request->venue,
            'event_data_address' => $request->address,
            'event_data_city' => $request->city,
            'event_data_state' => $request->state,
            'event_data_desc' => $request->desc,
            'created_at' => now()
        ]);
        return 123;
    }
}
