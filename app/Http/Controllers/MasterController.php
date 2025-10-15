<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use TianRosandhy\LaravelFonnte\Fonnte;
class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function master_dashboard()
    {
        if (Auth::user()->access_code == 'master') {
            return view('master.dashboard', ['akses' => 123]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_cabang()
    {
        if (Auth::user()->access_code == 'master') {
            return view('master.dashboard', ['akses' => 123]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_coa()
    {
        if (Auth::user()->access_code == 'master') {
            return view('master.master-coa', ['akses' => 123]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_user()
    {
        if (Auth::user()->access_code == 'master') {
            $user = DB::table('user_mains')->get();
            return view('master.master-user', ['akses' => 123, 'user' => $user]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_user_add()
    {
        if (Auth::user()->access_code == 'master') {
            $akses = DB::table('master_access')->get();
            return view('master.user.form-add', ['akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_user_save(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $code = Str::uuid();
            DB::table('user_mains')->insert([
                'fullname' => $request->nama_lengkap,
                'username' => $request->username,
                'userid' => str::uuid(),
                'email' => $request->email,
                'number_handphone' => $request->no_hp,
                'password' => Hash::make($request['password']),
                'access_code' => $request->akses,
                'access_cabang' => $request->cabang,
                'access_status' => 1,
                'remember_token' => str::uuid(),
                'created_at' => now(),
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_menu()
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('z_menu_sub')->get();
            return view('master.master-menu', ['data' => $data, 'akses' => 123]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_add()
    {
        if (Auth::user()->access_code == 'master') {
            $menu = DB::table('z_menu')->get();
            return view('master.menu.form-add', ['menu' => $menu]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_save(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $code = Str::uuid();
            DB::table('z_menu_sub')->insert([
                'menu_sub_code' => $code,
                'menu_code' => $request->code,
                'menu_sub_name' => $request->name,
                'menu_sub_link' => $request->link,
                'menu_sub_option' => $request->option,
                'menu_sub_icon' => $request->icon,
                'menu_sub_status' => 1,
            ]);
            DB::table('z_menu_user')->insert([
                'menu_sub_code' => $code,
                'access_code' => 'master',
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_update(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $menu = DB::table('z_menu_sub')->where('menu_sub_code', $request->code)->first();
            return view('master.menu.form-update', ['menu' => $menu]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_update_save(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return view('application.error.404');
        }
    }
    public function master_sub_menu_save(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            DB::table('z_menu_sub_main')->insert([
                'menu_main_sub_code' => str::uuid(),
                'menu_sub_code' => $request->code,
                'menu_main_sub_name' => $request->name,
                'menu_main_sub_link' => $request->link,
                'menu_main_sub_icon' => $request->icon,
                'menu_main_sub_status' => 1,
                'created_at' => now(),
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_akses()
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('master_access')->get();
            return view('master.master-menu-akses', ['data' => $data, 'akses' => 123]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_akses_add()
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('master_access')->get();
            return view('master.access.form-add', ['data' => $data, 'akses' => 123]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_akses_save(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            DB::table('master_access')->insert([
                'master_access_code' => str::uuid(),
                'master_access_name' => $request->name,
                'master_access_status' => 1,
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_akses_setup_super_menu(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('z_menu_super')->get();
            return view('master.access.form-setup-super-menu', [
                'code' => $request->code,
                'data' => $data,
                'akses' => 123
            ]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_gateway_whatsapp(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            return view('master.master-gateway-whatsapp');
        } else {
            return view('application.error.404');
        }
    }
    public function master_gateway_whatsapp_send_message(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            return view('master.gateway.form-kirim-pesan');
        } else {
            return view('application.error.404');
        }
    }
    public function master_gateway_whatsapp_send_message_prosess(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => '085159852577',
                    'message' => 'hallo broo',
                    'url' => 'http://127.0.0.1:8000/img/logo.png',
                    'filename' => 'http://127.0.0.1:8000/file/file.pdf',
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . 'BKFshex2Z7ntm6wNKNTg'
                ),
            ));

            $response = curl_exec($curl);

            // curl_close($curl);
            // echo $response;
            //log response fonnte
            // $recipients = ['089694107336'];
            // $message = "Hello world!";
            // $additional_param = [
            //     'target' => $recipients,
            //     'message' => $message,
            // ];
            // Fonnte::sendMessage($recipients, $message, $additional_param);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return view('application.error.404');
        }
    }
}
