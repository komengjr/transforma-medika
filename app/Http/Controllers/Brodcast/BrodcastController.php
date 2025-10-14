<?php

namespace App\Http\Controllers\Brodcast;

use App\Http\Controllers\Controller;
use App\Imports\PesertaEventImport;
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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Svg\Tag\Rect;

class BrodcastController extends Controller
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
    // BRODCAST WHATSAPP
    public function menu_brodcast_whatsapp($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('log_schedule_product')->orderBy('id_schedule_product', 'DESC')->get();
            return view('app-brodcast.menu.brodcast-whatsapp', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_brodcast_whatsapp_send(Request $request)
    {
        $nomorhp = $request->number;
        //Terlebih dahulu kita trim dl
        $nomorhp = trim($nomorhp);
        //bersihkan dari karakter yang tidak perlu
        $nomorhp = strip_tags($nomorhp);
        // Berishkan dari spasi
        $nomorhp = str_replace(" ", "", $nomorhp);
        // Berishkan dari -
        $nomorhp = str_replace("-", "", $nomorhp);
        // bersihkan dari bentuk seperti  (022) 66677788
        $nomorhp = str_replace("(", "", $nomorhp);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $nomorhp = str_replace(".", "", $nomorhp);

        if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nomorhp), 0, 3) == '+62') {
                $nomorhp = trim($nomorhp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr($nomorhp, 0, 1) == '0') {
                $nomorhp = '+62' . substr($nomorhp, 1);
            }
        }
        $text = "Hi *" . Auth::user()->fullname . "* \nSelamat Anda Terdaftar Sebagai Peserta \n\n" . $request->text . "\n\nSupport By. Innoverta";
        DB::table('v_log_whatsapp')->insert([
            'v_log_whatsapp_code' => str::uuid(),
            'd_reg_order_list_code' => str::uuid(),
            'v_log_whatsapp_number' => $nomorhp,
            'v_log_whatsapp_name' => Auth::user()->fullname,
            'v_log_whatsapp_filename' => Auth::user()->fullname,
            'v_log_whatsapp_text' => $text,
            'v_log_whatsapp_file' => 'N',
            'v_log_whatsapp_picture' => 0,
            'v_log_whatsapp_status' => 0,
            'v_log_whatsapp_date' => now(),
            'v_log_whatsapp_pass' => mt_rand(10000, 90000),
            'created_at' => now()
        ]);
        return 123;
    }
    // BRODCAST WHATSAPP
    public function menu_brodcast_management($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('b_event')->orderBy('id_b_event', 'DESC')->get();
            return view('app-brodcast.menu.brodcast-management', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_brodcast_management_add(Request $request)
    {
        return view('app-brodcast.menu.form.form-add-event');
    }
    public function menu_brodcast_management_save(Request $request)
    {
        try {
            DB::table('b_event')->insert([
                'b_event_code' => str::uuid(),
                'b_event_name' => $request->name,
                'b_event_location' => $request->location,
                'b_event_class' => $request->class,
                'b_event_date' => $request->date,
                'b_event_status' => 1,
                'created_at' => now()
            ]);
            return 'sukses';
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function menu_brodcast_management_add_peserta(Request $request)
    {
        return view('app-brodcast.menu.form.form-add-peserta', ['code' => $request->code]);
    }
    public function menu_brodcast_management_save_peserta(Request $request)
    {
        try {
            $event = DB::table('b_event')->where('b_event_code', $request->code_event)->first();
            DB::table('b_event_peserta')->insert([
                'b_event_peserta_code' => str::uuid(),
                'b_event_code' => $request->code_event,
                'b_event_peserta_name' => $request->name,
                'b_event_peserta_booking' => $request->booking,
                'b_event_peserta_class' => $event->b_event_location,
                'b_event_peserta_room' => $event->b_event_class,
                'b_event_peserta_hp' => $request->hp,
                'b_event_peserta_email' => $request->email,
                'b_event_peserta_lembaga' => $request->lembaga,
                'b_event_peserta_desc' => $request->desc,
                'b_event_peserta_status' => 1,
                'created_at' => now(),
            ]);
            return 'sukses';
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_brodcast_management_brodcast_whatsapp(Request $request)
    {
        $data = DB::table('b_event_peserta')->where('b_event_code', $request->code)->get();
        return view('app-brodcast.menu.form.form-brodcast-whatsapp', [
            'data' => $data,
            'code' => $request->code
        ]);
    }
    public function menu_brodcast_management_brodcast_whatsapp_send(Request $request)
    {
        $data = DB::table('b_event_peserta')->where('b_event_code', $request->code)->get();
        $event = DB::table('b_event')->where('b_event_code', $request->code)->first();
        foreach ($data as $datas) {
            if ($datas->b_event_peserta_hp == "") {
                # code...
            } else {
                $cek = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $datas->b_event_peserta_code)->first();

                if (!$cek) {
                    $nomorhp = $datas->b_event_peserta_hp;
                    //Terlebih dahulu kita trim dl
                    $nomorhp = trim($nomorhp);
                    //bersihkan dari karakter yang tidak perlu
                    $nomorhp = strip_tags($nomorhp);
                    // Berishkan dari spasi
                    $nomorhp = str_replace(" ", "", $nomorhp);
                    // Berishkan dari -
                    $nomorhp = str_replace("-", "", $nomorhp);
                    // bersihkan dari bentuk seperti  (022) 66677788
                    $nomorhp = str_replace("(", "", $nomorhp);
                    // bersihkan dari format yang ada titik seperti 0811.222.333.4
                    $nomorhp = str_replace(".", "", $nomorhp);

                    if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
                        // cek apakah no hp karakter 1-3 adalah +62
                        if (substr(trim($nomorhp), 0, 3) == '+62') {
                            $nomorhp = trim($nomorhp);
                        }
                        // cek apakah no hp karakter 1 adalah 0
                        elseif (substr($nomorhp, 0, 1) == '0') {
                            $nomorhp = '+62' . substr($nomorhp, 1);
                        }
                    }
                    $text = "Hi *" . $datas->b_event_peserta_name . "* \nSelamat Anda Terdaftar Sebagai Peserta Event : " . $event->b_event_name . " \nLokasi Event : " . $event->b_event_location . "\nRoom : " . $event->b_event_class . "\nTanggal : " . $event->b_event_date . "\nKode Booking : " . $datas->b_event_peserta_booking . "\n\nSupport By. *www.innoventra.site*";
                    $qrcode = base64_encode(QrCode::format('png')
                        ->size(500)
                        ->errorCorrection('H')
                        ->eyeColor(2, 100, 100, 255, 0, 0, 0)
                        ->style('round')
                        ->margin(2)
                        ->generate($datas->b_event_peserta_booking));
                    DB::table('v_log_whatsapp')->insert([
                        'v_log_whatsapp_code' => str::uuid(),
                        'd_reg_order_list_code' => $datas->b_event_peserta_code,
                        'v_log_whatsapp_number' => $nomorhp,
                        'v_log_whatsapp_name' => $datas->b_event_peserta_name,
                        'v_log_whatsapp_filename' => 'N',
                        'v_log_whatsapp_text' => $text,
                        'v_log_whatsapp_file' => 'N',
                        'v_log_whatsapp_picture' => $qrcode,
                        'v_log_whatsapp_status' => 0,
                        'v_log_whatsapp_date' => now(),
                        'v_log_whatsapp_pass' => mt_rand(100000, 9999999),
                        'created_at' => now()

                    ]);
                }
            }

        }
        $data = DB::table('b_event_peserta')->where('b_event_code', $request->code)->get();
        return view('app-brodcast.menu.table.table-peserta-event', ['data' => $data]);
    }
    public function menu_brodcast_management_export_excel(Request $request)
    {
        return view('app-brodcast.menu.form.form-export-excel-peserta', ['code' => $request->code]);
    }
    public function menu_brodcast_management_export_excel_start(Request $request)
    {
        Excel::import(new PesertaEventImport($request->code, 454), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
}
