<?php

namespace App\Http\Controllers\Photobooth;

use App\Http\Controllers\Controller;
use App\Models\Photobooth\PhotoboothData;
use App\Models\Photobooth\PhotoboothDataFrame;
use Illuminate\Http\Request;
use App\Models\PhotoboothResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PhotoboothController extends Controller
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
    // SETUP PHOTOBOOTH
    public function menu_photobooth_setup($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $photobooths = PhotoboothData::with('frames')->get();
            return view('app-photobooth.menu-photobooth.setup-photobooth', compact('photobooths'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function storesetup(Request $request)
    {
        $request->validate([
            'org_code' => 'required|unique:photobooth_data,org_code',
            'org_name' => 'required',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'background' => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
        ]);

        $orgCodeSlug = Str::slug($request->org_code);

        // Tersimpan di: storage/app/photobooth/logos
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoExtension = $request->file('logo')->getClientOriginalExtension();
            $logoFileName = 'logo_' . $orgCodeSlug . '_' . time() . '.' . $logoExtension;
            $logoPath = $request->file('logo')->storeAs('logos', $logoFileName, 'photobooth');
        }

        // Tersimpan di: storage/app/photobooth/backgrounds
        $bgPath = null;
        if ($request->hasFile('background')) {
            $bgExtension = $request->file('background')->getClientOriginalExtension();
            $bgFileName = 'bg_' . $orgCodeSlug . '_' . time() . '.' . $bgExtension;
            $bgPath = $request->file('background')->storeAs('backgrounds', $bgFileName, 'photobooth');
        }

        PhotoboothData::create([
            'org_code' => $request->org_code,
            'org_name' => $request->org_name,
            'logo_path' => $logoPath, // menyimpan misal: "logos/logo_pramita_123.png"
            'bg_path' => $bgPath,
        ]);

        return redirect()->back()->with('success', 'Organisasi berhasil ditambahkan!');
    }

    public function storeFrame(Request $request, $id)
    {
        $request->validate([
            'frame_name' => 'required',
            'frame_image' => 'required|image|mimes:png|max:4096',
        ]);

        $photobooth = PhotoboothData::findOrFail($id);
        $orgCodeSlug = Str::slug($photobooth->org_code);

        // Tersimpan di: storage/app/photobooth/frames
        $frameExtension = $request->file('frame_image')->getClientOriginalExtension();
        $frameFileName = 'frame_' . $orgCodeSlug . '_' . Str::slug($request->frame_name) . '_' . time() . '.' . $frameExtension;
        $framePath = $request->file('frame_image')->storeAs('frames', $frameFileName, 'photobooth');

        PhotoboothDataFrame::create([
            'photobooth_data_id' => $id,
            'frame_name' => $request->frame_name,
            'frame_path' => $framePath,
        ]);

        return redirect()->back()->with('success', 'Frame berhasil ditambahkan!');
    }
    public function clientView($org_code)
    {
        // Cari data photobooth berdasarkan org_code beserta relasi frames-nya
        $photobooth = PhotoboothData::with('frames')
            ->where('org_code', $org_code)
            ->firstOrFail();

        // Direct ke view tampilan photobooth client
        return view('app-photobooth.menu-photobooth.photobooth-client', compact('photobooth'));
    }
    public function index()
    {
        $frames = [
            ['name' => 'Frame 1', 'image' => asset('frames/frame1.png')],
            ['name' => 'Frame 2', 'image' => asset('frames/frame2.png')],
        ];

        return view('photobooth', compact('frames'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            // 'phone'         => 'required|string|max:20',
            // 'email'         => 'required|email|max:255',
            'image_data'    => 'required|string', // Foto Gabungan
            'single_images' => 'required|array|min:1', // Array Foto Satuan
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        try {
            do {
                $uniqueCode = Str::upper(Str::random(10));
            } while (PhotoboothResult::where('code', $uniqueCode)->exists());

            // 1. Simpan Foto Gabungan
            $mergedImage = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->input('image_data'));
            $mergedFileName = 'photobooth_merged_' . time() . '_' . $uniqueCode . '.png';
            $mergedPath = 'photobooth/' . $mergedFileName;
            Storage::disk('local')->put($mergedPath, base64_decode($mergedImage));

            // 2. Simpan Setiap Foto Satuan
            $savedSinglePaths = [];
            foreach ($request->input('single_images') as $index => $singleBase64) {
                $singleImage = str_replace(['data:image/png;base64,', ' '], ['', '+'], $singleBase64);
                $singleFileName = 'photobooth_single_' . ($index + 1) . '_' . time() . '_' . $uniqueCode . '.png';
                $singlePath = 'photobooth/' . $singleFileName;

                Storage::disk('local')->put($singlePath, base64_decode($singleImage));
                $savedSinglePaths[] = $singlePath;
            }

            // 3. Simpan ke DB
            $result = PhotoboothResult::create([
                'code'          => $uniqueCode,
                'name'          => $request->name,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'image_path'    => $mergedPath,
                'single_images' => $savedSinglePaths,
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Foto berhasil disimpan!',
                'data'      => $result,
                'share_url' => route('photobooth.show', $result->code)
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function show($code)
    {
        $result = PhotoboothResult::where('code', $code)->firstOrFail();
        return view('photobooth_show', compact('result'));
    }

    // Method akses file gambar (gabungan maupun satuan)
    public function getImage(Request $request, $code)
    {
        $result = PhotoboothResult::where('code', $code)->firstOrFail();
        $type = $request->query('type', 'merged');
        $index = (int) $request->query('index', 0);

        $path = $result->image_path;

        if ($type === 'single' && isset($result->single_images[$index])) {
            $path = $result->single_images[$index];
        }

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return response()->file(storage_path('app/' . $path));
    }
}
