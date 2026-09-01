<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserMain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        return Redirect('dashboard/home');
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
            DB::table('user_mains_logs')->insert([
                'userid' => Auth::user()->userid,
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp(),
                'created_at' => now()
            ]);
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
    public function verifikasi_send_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Cek apakah email terdaftar di tabel user_mains
        $user = DB::table('user_mains')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email tidak ditemukan dalam sistem!'
            ], 404);
        }

        // Generate 6 Digit Kode OTP
        $otp = rand(100000, 999999);

        // Simpan OTP ke tabel reset_passwords / password_resets (atau tabel khusus OTP)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => Hash::make($otp), // Disimpan acak/hashed agar aman
                'otp_code'   => $otp,            // Jika ingin plain text untuk verifikasi mudah
                'created_at' => now()
            ]
        );

        // Kirim Email OTP
        try {
            Mail::raw("Kode OTP verifikasi reset password Anda adalah: {$otp}\n\nKode ini berlaku selama 15 menit.", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Kode OTP Reset Password - Innoventra');
            });

            return response()->json([
                'status'  => 'success',
                'message' => 'Kode OTP berhasil dikirimkan ke email Anda.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }
    public function verifikasi_otp_check(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric',
        ]);

        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Permintaan OTP tidak ditemukan. Silakan minta OTP kembali.'
            ], 400);
        }

        if ($resetRecord->otp_code != $request->otp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode OTP yang Anda masukkan salah!'
            ], 400);
        }

        $createdAt = \Carbon\Carbon::parse($resetRecord->created_at);
        if ($createdAt->addMinutes(15)->isPast()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode OTP telah kedaluwarsa. Silakan minta OTP baru.'
            ], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'OTP Valid'
        ], 200);
    }

    // 2. Verifikasi OTP & Reset Password
    public function verifikasi_reset_pass(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'otp'                   => 'required|numeric',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        // Cek Record OTP berdasarkan Email
        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Permintaan OTP tidak ditemukan. Silakan minta OTP kembali.'
            ], 400);
        }

        // Cek apakah OTP cocok
        if ($resetRecord->otp_code != $request->otp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode OTP yang Anda masukkan salah!'
            ], 400);
        }

        // Cek Masa Kadaluarsa OTP (Contoh: Batas waktu 15 menit)
        $createdAt = \Carbon\Carbon::parse($resetRecord->created_at);
        if ($createdAt->addMinutes(15)->isPast()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode OTP telah kedaluwarsa. Silakan minta OTP baru.'
            ], 400);
        }

        // Update Password Baru di Tabel user_mains
        DB::table('user_mains')
            ->where('email', $request->email)
            ->update([
                'password'   => Hash::make($request->password),
                'updated_at' => now(),
            ]);

        // Hapus Token/OTP setelah berhasil digunakan
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Password berhasil diperbarui! Silakan login.'
        ], 200);
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
