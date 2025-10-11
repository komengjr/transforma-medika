<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Str;

class AuthController extends Controller
{


    public function index()
    {
        if (Auth::check()) {
            return Redirect('dashboard/home');
        } else {
            return view('auth.login');
        }
    }

    public function registration()
    {

        return view('auth.registration');
    }

    public function postLogin(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->access_status == 0) {
                Auth::logout();
                return redirect()->intended('register_status')
                    ->withSuccess('Gagal Login');
            } else {
                return redirect()->intended('dashboard/home')
                    ->withSuccess('Kamu Berhasil Masuk di Halaman ' . Auth::user()->fullname);
            }
        }
        return redirect("login")->withSuccess('Username dan Password Tidak Sinkron Mohon Untuk Mengingat Kembali');
    }
    public function verifikasi_Login(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->access_status == 0) {
                Auth::logout();
                return '<div class="alert alert-warning alert-dismissible fade show my-3" role="alert"> <strong>Warning !</strong> Bermasalah Pada Akun Anda <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
                // return redirect()->intended('register_status')
                //     ->withSuccess('Gagal Login');
            } else {
                // return redirect()->intended('dashboard/home')
                //     ->withSuccess('Kamu Berhasil Masuk di Halaman ' . Auth::user()->fullname);
                return '<div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                                            <strong>Greate!</strong> Selamat Datang ' . Auth::user()->fullname . '.
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <script>window.location.href = "' . route('dashboard.home') . '";</script>
                                        </div>';
            }
        }
        return '<div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                                            <strong>Error!</strong> Username Dan Password Ada Kesalahan.
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>';
    }

    public function postRegistration(Request $request)
    {

        $request->validate([
            'fullname' => 'required',
            'no_hp' => 'required',
            'username' => 'required|unique:user_mains',
            'email' => 'required|unique:user_mains',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        return redirect("confrim_user")->withSuccess('Great! You have Successfully loggedin');
    }

    // public function dashboard()
    // {

    //     if (Auth::check()) {

    //         return view('dashboard');

    //     }
    //     return redirect("login")->withSuccess('Opps! You do not have access');

    // }


    public function create(array $data)
    {

        return UserMain::create([
            'fullname' => $data['fullname'],
            'username' => $data['username'],
            'number_handphone' => $data['no_hp'],
            'email' => $data['email'],
            'access_code' => 'user',
            'access_status' => '0',
            'remember_token' => Str::random(10),
            'password' => FacadesHash::make($data['password']),

        ]);
    }
    public function confrim_user()
    {
        return view('auth.confrim-page');
    }
    public function register_status()
    {
        return view('auth.register_status');
    }
    public function forget_password()
    {
        return view('auth.forget_password');
    }

    public function logout()
    {

        FacadesSession::flush();

        Auth::logout();

        return Redirect('/')->withSuccess('Great! You have Successfully log Out');
    }
}
