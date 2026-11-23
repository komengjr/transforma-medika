<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Models\BrainTest\BrainTestJawabanResponden;
use App\Models\BrainTest\BrainTestPaket;
use App\Models\BrainTest\BrainTestSesiResponden;
use App\Models\BrainTest\BrainTestSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    private const TABLE_SESI = 'brain_test_sesi_responden';
    private const TABLE_JAWABAN = 'brain_test_jawaban_responden';
    public function test()
    {
        return view('app-exam.test-online');
    }
    public function halamanTes($paketId)
    {
        $paket = BrainTestPaket::with([
            'klasifikasi',
            'kategoris' => function ($q) {
                $q->orderBy('urutan')->withCount('soals');
            },
        ])->findOrFail($paketId);

        return view('app-brain-test.tes.form-tes', [
            'paket' => $paket,
        ]);
    }

    public function mulaiSesiTes(Request $request, $paketId)
    {
        $paket = BrainTestPaket::with(['kategoris' => function ($q) {
            $q->orderBy('urutan');
        }])->findOrFail($paketId);

        $namaResponden = trim((string) $request->input('nama_responden', ''));
        $email = trim((string) $request->input('email', ''));
        $noHp = trim((string) $request->input('no_hp', ''));
        $keterangan = trim((string) $request->input('keterangan', ''));

        if ($namaResponden === '') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Nama lengkap wajib diisi.',
            ], 422);
        }

        if ($email === '' && $noHp === '') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Silakan isi Email atau No. HP sebagai ID unik.',
            ], 422);
        }

        $uniqueIdentifiers = array_values(array_filter([$email, $noHp], fn($val) => $val !== ''));
        $primaryUniqueId = $email !== '' ? $email : $noHp;

        $existingSesi = DB::table(self::TABLE_SESI)
            ->where('paket_id', $paket->id)
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', '!=', 'reset');
            })
            ->whereIn('email_atau_hp', $uniqueIdentifiers)
            ->orderByDesc('id')
            ->first();

        if ($existingSesi) {
            $statusSesi = $existingSesi->status ?? 'sedang_mengerjakan';

            if ($statusSesi === 'selesai') {
                return response()->json([
                    'status'         => 'already_taken',
                    'already_taken'  => true,
                    'responden_nama' => $existingSesi->nama_responden ?? null,
                    'message'        => 'Email atau No. HP tersebut sudah menyelesaikan tes ini sebelumnya.',
                ], 409);
            }

            $durasiDetik = max(0, (int) ($paket->durasi_menit ?? 60) * 60);
            $waktuMulai = !empty($existingSesi->waktu_mulai) ? Carbon::parse($existingSesi->waktu_mulai) : now();
            $sisaDetik = max(0, $durasiDetik - max(0, $waktuMulai->diffInSeconds(now())));

            $soals = BrainTestSoal::with(['kategori', 'opsiJawabans'])
                ->whereIn('kategori_id', $paket->kategoris->pluck('id'))
                ->orderBy('id', 'asc')
                ->get();

            $jawabanMap = $this->ambilJawabanMapSesi($existingSesi->id);

            return response()->json([
                'status'      => 'success',
                'sesi'        => $existingSesi,
                'unique_id'   => $existingSesi->email_atau_hp ?: '-',
                'sisa_detik'  => $sisaDetik > 0 ? $sisaDetik : $durasiDetik,
                'soals'       => $soals,
                'jawaban_map' => $jawabanMap,
            ]);
        }

        $tokenSesi = Str::uuid()->toString();
        $now = now();

        $sesiId = DB::table(self::TABLE_SESI)->insertGetId([
            'paket_id'       => $paket->id,
            'nama_responden' => $namaResponden,
            'email_atau_hp'  => $primaryUniqueId,
            'asal_instansi'  => $keterangan !== '' ? $keterangan : null,
            'token_sesi'     => $tokenSesi,
            'status'         => 'sedang_mengerjakan',
            'total_skor'     => 0,
            'waktu_mulai'    => $now,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        $sesi = DB::table(self::TABLE_SESI)->where('id', $sesiId)->first();

        $soals = BrainTestSoal::with(['kategori', 'opsiJawabans'])
            ->whereIn('kategori_id', $paket->kategoris->pluck('id'))
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'status'      => 'success',
            'sesi'        => $sesi,
            'unique_id'   => $primaryUniqueId,
            'sisa_detik'  => max(0, (int) ($paket->durasi_menit ?? 60) * 60),
            'soals'       => $soals,
            'jawaban_map' => [],
        ]);
    }
    public function resumeSesiTes($paketId, $tokenSesi)
    {
        $paket = BrainTestPaket::with('kategoris')->findOrFail($paketId);

        $sesi = DB::table(self::TABLE_SESI)
            ->where('paket_id', $paket->id)
            ->where('token_sesi', $tokenSesi)
            ->first();

        if (!$sesi || ($sesi->status ?? '') === 'reset') {
            return response()->json([
                'status'  => 'reset',
                'message' => 'Sesi tes telah direset atau tidak ditemukan.',
            ], 404);
        }

        if (($sesi->status ?? 'sedang_mengerjakan') === 'selesai') {
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

        $jawabanMap = $this->ambilJawabanMapSesi($sesi->id);

        return response()->json([
            'status'      => 'success',
            'sesi'        => $sesi,
            'unique_id'   => $sesi->email_atau_hp ?: '-',
            'sisa_detik'  => $sisaDetik,
            'soals'       => $soals,
            'jawaban_map' => $jawabanMap,
        ]);
    }
    private function ambilJawabanMapSesi($sesiId): array
    {
        $jawabanMap = [];
        if (Schema::hasTable(self::TABLE_JAWABAN)) {
            $rows = DB::table(self::TABLE_JAWABAN)
                ->where('sesi_responden_id', $sesiId)
                ->get();

            foreach ($rows as $row) {
                $jawabanMap[$row->soal_id] = [
                    'opsi_jawaban_id' => $row->opsi_jawaban_id ?? null,
                    'is_ragu'         => (bool) ($row->is_ragu ?? false),
                ];
            }
        }

        return $jawabanMap;
    }
    public function simpanJawabanSesi(Request $request, $tokenSesi)
    {
        $sesi = DB::table(self::TABLE_SESI)
            ->where('token_sesi', $tokenSesi)
            ->first();

        if (!$sesi) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Sesi tidak ditemukan.',
            ], 404);
        }

        if (($sesi->status ?? '') === 'selesai') {
            return response()->json([
                'status'  => 'completed',
                'message' => 'Sesi sudah selesai.',
            ], 409);
        }

        $soalId = (int) $request->input('soal_id');
        $opsiJawabanId = $request->input('opsi_jawaban_id');
        $opsiJawabanId = ($opsiJawabanId !== null && $opsiJawabanId !== '') ? (int) $opsiJawabanId : null;
        $isRagu = filter_var($request->input('is_ragu', false), FILTER_VALIDATE_BOOLEAN);

        if ($soalId <= 0 || !Schema::hasTable(self::TABLE_JAWABAN)) {
            return response()->json(['status' => 'error'], 422);
        }

        $now = now();
        $existing = DB::table(self::TABLE_JAWABAN)
            ->where('sesi_responden_id', $sesi->id)
            ->where('soal_id', $soalId)
            ->first();

        if ($existing) {
            DB::table(self::TABLE_JAWABAN)
                ->where('id', $existing->id)
                ->update([
                    'opsi_jawaban_id' => $opsiJawabanId,
                    'is_ragu'         => $isRagu,
                    'updated_at'      => $now,
                ]);
        } else {
            DB::table(self::TABLE_JAWABAN)->insert([
                'sesi_responden_id' => $sesi->id,
                'soal_id'           => $soalId,
                'opsi_jawaban_id'   => $opsiJawabanId,
                'is_ragu'           => $isRagu,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);
        }

        return response()->json(['status' => 'success']);
    }
    public function selesaiSesiTes(Request $request, $tokenSesi)
    {
        $sesi = DB::table(self::TABLE_SESI)
            ->where('token_sesi', $tokenSesi)
            ->first();

        if (!$sesi) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Sesi tes tidak ditemukan.',
            ], 404);
        }

        $paket = BrainTestPaket::with(['kategoris' => function ($q) {
            $q->orderBy('urutan');
        }])->find($sesi->paket_id);

        $soals = BrainTestSoal::with(['kategori', 'opsiJawabans'])
            ->when($paket, function ($q) use ($paket) {
                $q->whereIn('kategori_id', $paket->kategoris->pluck('id'));
            })
            ->orderBy('id', 'asc')
            ->get();

        $jawabanRows = collect([]);
        if (Schema::hasTable(self::TABLE_JAWABAN)) {
            $jawabanRows = DB::table(self::TABLE_JAWABAN)
                ->where('sesi_responden_id', $sesi->id)
                ->get()
                ->keyBy('soal_id');
        }

        $totalSkor = 0;
        $jawabanSalah = [];

        foreach ($soals as $index => $soal) {
            $opsiList = $soal->opsiJawabans ?? collect();
            $row = $jawabanRows->get($soal->id);
            $selectedId = $row->opsi_jawaban_id ?? null;

            $selectedOpsi = $selectedId
                ? $opsiList->first(fn($opt) => (int) $opt->id === (int) $selectedId)
                : null;

            // Opsi dengan is_benar = true, atau jika tidak ada is_benar maka poin tertinggi
            $correctOpsi = $opsiList->first(fn($opt) => (bool) ($opt->is_benar ?? false))
                ?: $opsiList->sortByDesc(fn($opt) => (int) ($opt->poin ?? 0))->first();

            $hasAnyTrueFlag = $opsiList->contains(fn($opt) => (bool) ($opt->is_benar ?? false));

            $isCorrect = false;
            if ($selectedOpsi) {
                if ($hasAnyTrueFlag) {
                    $isCorrect = (bool) ($selectedOpsi->is_benar ?? false);
                } else {
                    $maxPoin = (int) ($correctOpsi->poin ?? 0);
                    $isCorrect = $maxPoin > 0 && (int) ($selectedOpsi->poin ?? 0) >= $maxPoin;
                }
            }

            // Hitung skor: gunakan poin opsi jika > 0, atau bobot_nilai soal jika jawaban benar
            if ($selectedOpsi) {
                $poinOpsi = (int) ($selectedOpsi->poin ?? 0);
                if ($poinOpsi > 0) {
                    $totalSkor += $poinOpsi;
                } elseif ($isCorrect) {
                    $totalSkor += (int) ($soal->bobot_nilai ?? 1);
                }
            }

            if (!$isCorrect) {
                $teksBenar = $correctOpsi->teks_jawaban ?? '-';
                $teksUser = $selectedOpsi->teks_jawaban ?? 'Tidak dijawab';

                if (!empty($soal->pembahasan)) {
                    $alasanDetail = $soal->pembahasan;
                } elseif (!$selectedOpsi) {
                    $alasanDetail = "Anda tidak memilih jawaban pada soal ini. Jawaban yang benar adalah \"{$teksBenar}\".";
                } else {
                    $alasanDetail = "Pilihan Anda \"{$teksUser}\" belum tepat karena kunci jawaban untuk soal ini adalah \"{$teksBenar}\".";
                }

                $jawabanSalah[] = [
                    'nomor'         => $index + 1,
                    'soal_id'       => $soal->id,
                    'kategori'      => $soal->kategori->nama_kategori ?? '-',
                    'pertanyaan'    => $soal->pertanyaan,
                    'jawaban_user'  => $teksUser,
                    'jawaban_benar' => $teksBenar,
                    'penjelasan'    => $alasanDetail,
                ];
            }
        }

        DB::table(self::TABLE_SESI)
            ->where('id', $sesi->id)
            ->update([
                'status'        => 'selesai',
                'total_skor'    => $totalSkor,
                'waktu_selesai' => now(),
                'updated_at'    => now(),
            ]);

        return response()->json([
            'status'        => 'success',
            'total_skor'    => $totalSkor,
            'jumlah_salah'  => count($jawabanSalah),
            'jawaban_salah' => $jawabanSalah,
        ]);
    }
}
