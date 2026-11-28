<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BrainTest\BrainTestKlasifikasi;
use App\Models\BrainTest\BrainTestPaket;
use App\Models\BrainTest\BrainTestSoal;
use App\Models\NewsData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PageController extends Controller
{
    public function fisrt()
    {
        // Mengambil 3 artikel/blog terbaru berdasarkan tanggal dibuat
        $latest_blogs = Blog::orderBy('created_at', 'desc')->take(3)->get();

        // Mengirimkan variabel $latest_blogs ke file view 'public.index'
        return view('public.index', compact('latest_blogs'));
    }
    public function app_hrm()
    {
        return view('public.app-hrm');
    }
    public function app_medical()
    {
        return view('public.app-medical');
    }
    public function app_accounting()
    {
        return view('public.app-accounting');
    }
    public function app_inventaris()
    {
        return view('public.app-inventaris');
    }
    public function app_logistik()
    {
        return view('public.app-logistik');
    }
    public function app_purchase()
    {
        return view('public.app-purchase');
    }
    public function app_supplier()
    {
        return view('public.app-supplier');
    }
    public function app_movie()
    {
        return view('public.app-movie');
    }
    public function product()
    {
        $product = DB::table('log_m_product')->get();
        return view('public.product', ['product' => $product]);
    }
    public function product_detail($detail)
    {
        $data = DB::table('log_m_product')->where('log_m_product_code', $detail)->first();
        $desc = DB::table('log_m_product_desc')->where('log_m_product_code', $detail)->first();
        return view('public.product.product-deatil', [
            'data' => $data,
            'desc' => $desc
        ]);
    }
    public function about()
    {
        return view('public.about');
    }
    public function contact()
    {
        return view('public.contact');
    }
    public function privacy_policy()
    {
        return view('public.privacy-policy');
    }
    public function terms_of_service()
    {
        return view('public.terms_of_service');
    }
    public function changelog()
    {
        return view('public.changelog');
    }

    public function publicBankSoal(Request $request)
    {
        $klasifikasis = BrainTestKlasifikasi::with([
            'pakets' => function ($q) {
                $q->orderBy('id', 'asc');
            },
            'pakets.kategoris' => function ($q) {
                $q->orderBy('urutan', 'asc')->orderBy('id', 'asc')->withCount('soals');
            },
        ])->orderBy('id', 'asc')->get();

        return view('public.bank-soal', [
            'klasifikasis' => $klasifikasis,
        ]);
    }
    public function resumeSesiTes($paketId, $token)
    {
        $paket = BrainTestPaket::with('kategoris')->findOrFail($paketId);

        $sesi = DB::table('brain_test_sesi_responden')
            ->where('paket_id', $paket->id)
            ->where('token_sesi', $token)
            ->first();

        if (!$sesi) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Sesi tes tidak ditemukan.',
            ], 404);
        }

        if (($sesi->status ?? 'berlangsung') === 'selesai') {
            return response()->json([
                'status'  => 'completed',
                'message' => 'Sesi tes ini sudah selesai.',
            ], 409);
        }

        $durasiDetik = max(0, (int) ($paket->durasi_menit ?? 60) * 60);
        $waktuMulai = !empty($sesi->waktu_mulai) ? Carbon::parse($sesi->waktu_mulai) : now();
        $terpakaiDetik = max(0, $waktuMulai->diffInSeconds(now()));
        $sisaDetik = max(0, $durasiDetik - $terpakaiDetik);

        if ($sisaDetik <= 0) {
            return response()->json([
                'status'  => 'expired',
                'message' => 'Waktu sesi tes telah habis.',
            ], 410);
        }

        $soals = BrainTestSoal::with(['kategori', 'opsiJawabans'])
            ->whereIn('kategori_id', $paket->kategoris->pluck('id'))
            ->orderBy('id', 'asc')
            ->get();

        // Ambil jawaban tersimpan jika ada tabel detail jawaban sesi (opsional, aman jika belum ada)
        $jawabanMap = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('brain_test_jawaban_sesi')) {
            $rows = DB::table('brain_test_jawaban_sesi')
                ->where('sesi_id', $sesi->id)
                ->get();
            foreach ($rows as $row) {
                $jawabanMap[$row->soal_id] = [
                    'opsi_jawaban_id' => $row->opsi_jawaban_id ?? null,
                    'is_ragu'         => (bool) ($row->is_ragu ?? false),
                ];
            }
        }

        $uniqueId = $sesi->email ?: ($sesi->no_hp ?: '-');

        return response()->json([
            'status'      => 'success',
            'sesi'        => $sesi,
            'unique_id'   => $uniqueId,
            'sisa_detik'  => $sisaDetik,
            'soals'       => $soals,
            'jawaban_map' => $jawabanMap,
        ]);
    }
    public function resetSesiResponden(Request $request, $sesiId)
    {
        $sesi = DB::table('brain_test_sesi_responden')
            ->where('id', $sesiId)
            ->first();

        if (!$sesi) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data sesi responden tidak ditemukan.',
            ], 404);
        }

        DB::transaction(function () use ($sesi) {
            if (Schema::hasTable('brain_test_jawaban_sesi')) {
                DB::table('brain_test_jawaban_sesi')
                    ->where('sesi_id', $sesi->id)
                    ->delete();
            }

            DB::table('brain_test_sesi_responden')
                ->where('id', $sesi->id)
                ->delete();
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Sesi dan riwayat tes peserta berhasil direset. Peserta dapat mengikuti tes ulang.',
        ]);
    }

}
