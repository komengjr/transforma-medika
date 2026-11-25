<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;

class AccountingController extends Controller
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
    public function general_ledger($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $projects = DB::table('z_menu_super')
                ->where('menu_super_status', 1) // sesuaikan jika status menggunakan string seperti 'active' / 'aktif'
                ->orderBy('menu_super_name', 'asc')
                ->get();

            return view('app-accounting.general-ledger', [
                'akses'    => $akses,
                'code'     => $id,
                'projects' => $projects,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    private function parseGlDate(?string $rawDate): ?string
    {
        $rawDate = trim((string) $rawDate);
        if ($rawDate === '') {
            return null;
        }

        foreach (['d/m/Y', 'd/m/y', 'Y-m-d', 'd-m-Y'] as $format) {
            try {
                return Carbon::createFromFormat($format, $rawDate)->format('Y-m-d');
            } catch (\Exception $e) {
                // lanjut ke format berikutnya
            }
        }

        try {
            return Carbon::parse(str_replace('/', '-', $rawDate))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function general_ledger_search(Request $request)
    {
        $rawProject   = trim((string) $request->input('project', ''));
        $projectKey   = strtolower($rawProject);
        $tanggalAwal  = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $cabang       = Auth::user()->access_cabang ?? null;

        $startDate = $this->parseGlDate($tanggalAwal);
        $endDate   = $this->parseGlDate($tanggalAkhir);

        if ($startDate && $endDate && $startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $isKoperasi = in_array($projectKey, ['koperasi', 'kop', 'sp-kop', 'super-koperasi'], true)
            || str_contains($projectKey, 'koperasi');

        if ($isKoperasi) {
            $query = DB::table('kop_fin_jurnal_detail as d')
                ->join('kop_fin_jurnal as j', 'j.id_jurnal', '=', 'd.jurnal_id')
                ->leftJoin('kop_fin_master_coa as mc', 'mc.coa_code', '=', 'd.coa_code')
                ->leftJoin('acc_jurnal as aj', function ($join) {
                    $join->on(DB::raw('CAST(aj.source_jurnal_id AS CHAR)'), '=', DB::raw('CAST(j.id_jurnal AS CHAR)'))
                        ->where('aj.source_table', '=', 'kop_fin_jurnal');
                })
                ->select(
                    'j.id_jurnal',
                    'j.jurnal_no_bukti',
                    'j.jurnal_tgl',
                    'j.jurnal_keterangan',
                    'j.jurnal_ref_table',
                    'j.jurnal_ref_code',
                    'j.jurnal_user',
                    'j.jurnal_cabang',
                    'j.jurnal_created',
                    'd.id_jurnal_detail',
                    'd.jurnal_id',
                    'd.coa_code',
                    'd.jurnal_debit',
                    'd.jurnal_kredit',
                    'mc.coa_name',
                    'mc.coa_type',
                    'mc.normal_balance',
                    'aj.id_acc_jurnal',
                    'aj.acc_jurnal_no',
                    'aj.status_posting',
                    'aj.posted_at',
                    'aj.posted_by'
                )
                ->where(function ($q) {
                    $q->where('j.jurnal_user', 'koperasi')
                        ->orWhere('j.jurnal_ref_table', 'like', 'kop_%')
                        ->orWhere('j.jurnal_ref_table', 'saldo_awal');
                });

            if (!empty($cabang)) {
                $cabangExists = DB::table('kop_fin_jurnal')
                    ->where('jurnal_cabang', $cabang)
                    ->exists();

                if ($cabangExists) {
                    $query->where('j.jurnal_cabang', $cabang);
                }
            }

            if ($startDate && $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('j.jurnal_tgl', [$startDate, $endDate])
                        ->orWhereBetween(DB::raw('DATE(j.jurnal_created)'), [$startDate, $endDate]);
                });
            } elseif ($startDate) {
                $query->where(function ($q) use ($startDate) {
                    $q->whereDate('j.jurnal_tgl', '>=', $startDate)
                        ->orWhereDate(DB::raw('DATE(j.jurnal_created)'), '>=', $startDate);
                });
            } elseif ($endDate) {
                $query->where(function ($q) use ($endDate) {
                    $q->whereDate('j.jurnal_tgl', '<=', $endDate)
                        ->orWhereDate(DB::raw('DATE(j.jurnal_created)'), '<=', $endDate);
                });
            }

            $data = $query
                ->orderBy('j.id_jurnal', 'DESC')
                ->orderBy('d.id_jurnal_detail', 'ASC')
                ->get();

            return view('app-accounting.general-ledger.data-search-ledger', [
                'data'          => $data,
                'project'       => $rawProject !== '' ? $rawProject : 'koperasi',
                'tanggal_awal'  => $tanggalAwal,
                'tanggal_akhir' => $tanggalAkhir,
                'source_type'   => $rawProject !== '' ? $rawProject : 'koperasi',
            ]);
        }

        return view('app-accounting.general-ledger.data-search-ledger', [
            'data'          => collect(),
            'project'       => $rawProject,
            'tanggal_awal'  => $tanggalAwal,
            'tanggal_akhir' => $tanggalAkhir,
            'source_type'   => $rawProject !== '' ? $rawProject : 'lainnya',
        ]);
    }

    public function general_ledger_post_accounting(Request $request)
    {
        $request->validate([
            'source_jurnal_id' => 'required',
        ]);

        $sourceJurnalId = trim((string) $request->input('source_jurnal_id'));
        $sourceProject  = trim((string) $request->input('source_project', 'koperasi'));
        $sourceTable    = 'kop_fin_jurnal';

        $jurnal = DB::table('kop_fin_jurnal')
            ->where('id_jurnal', $sourceJurnalId)
            ->first();

        if (!$jurnal) {
            return response()->json([
                'success' => false,
                'message' => 'Data jurnal sumber tidak ditemukan.',
            ], 404);
        }

        $details = DB::table('kop_fin_jurnal_detail as d')
            ->leftJoin('kop_fin_master_coa as mc', 'mc.coa_code', '=', 'd.coa_code')
            ->select(
                'd.coa_code',
                'd.jurnal_debit',
                'd.jurnal_kredit',
                'mc.coa_name',
                'mc.coa_type'
            )
            ->where('d.jurnal_id', $jurnal->id_jurnal)
            ->orderBy('d.id_jurnal_detail', 'ASC')
            ->get();

        if ($details->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Detail jurnal kosong, tidak dapat diposting ke pusat keuangan.',
            ], 422);
        }

        $totalDebit  = (int) $details->sum(fn($item) => (int) $item->jurnal_debit);
        $totalKredit = (int) $details->sum(fn($item) => (int) $item->jurnal_kredit);

        if ($totalDebit !== $totalKredit) {
            return response()->json([
                'success' => false,
                'message' => 'Jurnal belum seimbang (Debit: ' . number_format($totalDebit, 0, ',', '.') . ' vs Kredit: ' . number_format($totalKredit, 0, ',', '.') . ').',
            ], 422);
        }

        // Cek apakah sudah pernah diposting ke acc_jurnal
        $existing = DB::table('acc_jurnal')
            ->where('source_table', $sourceTable)
            ->where('source_jurnal_id', (string) $jurnal->id_jurnal)
            ->first();

        if ($existing) {
            return response()->json([
                'success'      => true,
                'already_post' => true,
                'message'      => 'Jurnal sudah tercatat sebagai Posted di Akuntansi Pusat.',
                'acc_jurnal_no' => $existing->acc_jurnal_no,
                'posted_at'    => $existing->posted_at,
            ]);
        }

        $userName = Auth::user()->name ?? (Auth::user()->username ?? (Auth::user()->email ?? 'system'));
        $tglJurnal = !empty($jurnal->jurnal_tgl)
            ? $jurnal->jurnal_tgl
            : (!empty($jurnal->jurnal_created) ? Carbon::parse($jurnal->jurnal_created)->format('Y-m-d') : now()->format('Y-m-d'));

        $prefix = 'ACC-' . Carbon::parse($tglJurnal)->format('Ym') . '-';
        $lastNo = DB::table('acc_jurnal')
            ->where('acc_jurnal_no', 'like', $prefix . '%')
            ->orderBy('id_acc_jurnal', 'DESC')
            ->value('acc_jurnal_no');

        $nextSeq = 1;
        if ($lastNo) {
            $parts = explode('-', $lastNo);
            $nextSeq = ((int) end($parts)) + 1;
        }
        $accJurnalNo = $prefix . str_pad((string) $nextSeq, 4, '0', STR_PAD_LEFT);

        DB::beginTransaction();
        try {
            $accJurnalId = DB::table('acc_jurnal')->insertGetId([
                'acc_jurnal_no'    => $accJurnalNo,
                'source_project'   => $sourceProject !== '' ? $sourceProject : 'koperasi',
                'source_table'     => $sourceTable,
                'source_jurnal_id' => (string) $jurnal->id_jurnal,
                'jurnal_no_bukti'  => $jurnal->jurnal_no_bukti ?? $jurnal->jurnal_ref_code,
                'jurnal_tgl'       => $tglJurnal,
                'jurnal_keterangan' => $jurnal->jurnal_keterangan,
                'jurnal_ref_table' => $jurnal->jurnal_ref_table,
                'jurnal_ref_code'  => $jurnal->jurnal_ref_code,
                'jurnal_cabang'    => $jurnal->jurnal_cabang,
                'jurnal_user'      => $jurnal->jurnal_user,
                'status_posting'   => 'posted',
                'posted_at'        => now(),
                'posted_by'        => $userName,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            $detailRows = [];
            foreach ($details as $det) {
                $detailRows[] = [
                    'acc_jurnal_id' => $accJurnalId,
                    'coa_code'      => $det->coa_code,
                    'coa_name'      => $det->coa_name,
                    'coa_type'      => $det->coa_type,
                    'jurnal_debit'  => (int) $det->jurnal_debit,
                    'jurnal_kredit' => (int) $det->jurnal_kredit,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            DB::table('acc_jurnal_detail')->insert($detailRows);
            DB::commit();

            return response()->json([
                'success'       => true,
                'already_post'  => false,
                'message'       => 'Jurnal berhasil dilaporkan ke Pusat Keuangan (' . $accJurnalNo . ').',
                'acc_jurnal_no' => $accJurnalNo,
                'posted_at'     => now()->format('d/m/Y H:i'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan ke Akuntansi Pusat: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function ledger_report(Request $request, $akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $projects = DB::table('z_menu_super')
                ->orderBy('menu_super_name', 'asc')
                ->get();

            $project      = trim((string)$request->input('project', ''));
            $tanggalAwal  = trim((string)$request->input('tanggal_awal', ''));
            $tanggalAkhir = trim((string)$request->input('tanggal_akhir', ''));

            $startDate = $this->parseGlDate($tanggalAwal);
            $endDate   = $this->parseGlDate($tanggalAkhir);

            if ($startDate && $endDate && $startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }

            $query = DB::table('acc_jurnal_detail as ad')
                ->join('acc_jurnal as aj', 'aj.id_acc_jurnal', '=', 'ad.acc_jurnal_id')
                ->select(
                    'aj.id_acc_jurnal',
                    'aj.acc_jurnal_no',
                    'aj.source_project',
                    'aj.source_table',
                    'aj.source_jurnal_id',
                    'aj.jurnal_no_bukti',
                    'aj.jurnal_tgl',
                    'aj.jurnal_keterangan',
                    'aj.jurnal_ref_table',
                    'aj.jurnal_ref_code',
                    'aj.jurnal_cabang',
                    'aj.jurnal_user',
                    'aj.status_posting',
                    'aj.posted_at',
                    'aj.posted_by',
                    'ad.id_acc_jurnal_detail',
                    'ad.acc_jurnal_id',
                    'ad.coa_code',
                    'ad.coa_name',
                    'ad.coa_type',
                    'ad.jurnal_debit',
                    'ad.jurnal_kredit'
                );

            if ($project !== '') {
                $projLower = strtolower($project);
                $query->where(function ($q) use ($project, $projLower) {
                    $q->whereRaw('LOWER(aj.source_project) = ?', [$projLower])
                        ->orWhereRaw('LOWER(aj.source_project) LIKE ?', ['%' . $projLower . '%']);
                });
            }

            if ($startDate && $endDate) {
                $query->whereBetween('aj.jurnal_tgl', [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->whereDate('aj.jurnal_tgl', '>=', $startDate);
            } elseif ($endDate) {
                $query->whereDate('aj.jurnal_tgl', '<=', $endDate);
            }

            $reports = $query
                ->orderBy('aj.jurnal_tgl', 'DESC')
                ->orderBy('aj.id_acc_jurnal', 'DESC')
                ->orderBy('ad.id_acc_jurnal_detail', 'ASC')
                ->get();

            return view('app-accounting.ledger-report', [
                'akses'         => $akses,
                'code'          => $id,
                'projects'      => $projects,
                'reports'       => $reports,
                'project'       => $project,
                'tanggal_awal'  => $tanggalAwal,
                'tanggal_akhir' => $tanggalAkhir,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function statement_profit_loss(Request $request, $akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $projects = DB::table('z_menu_super')
                ->orderBy('menu_super_name', 'asc')
                ->get();

            $project      = trim((string)$request->input('project', ''));
            $tanggalAwal  = trim((string)$request->input('tanggal_awal', ''));
            $tanggalAkhir = trim((string)$request->input('tanggal_akhir', ''));

            $startDate = $this->parseGlDate($tanggalAwal);
            $endDate   = $this->parseGlDate($tanggalAkhir);

            if ($startDate && $endDate && $startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }

            $query = DB::table('acc_jurnal_detail as ad')
                ->join('acc_jurnal as aj', 'aj.id_acc_jurnal', '=', 'ad.acc_jurnal_id')
                ->leftJoin('kop_fin_master_coa as mc', function ($join) {
                    $join->on(DB::raw('TRIM(mc.coa_code)'), '=', DB::raw('TRIM(ad.coa_code)'));
                })
                ->select(
                    DB::raw('TRIM(ad.coa_code) as coa_code'),
                    DB::raw('MAX(COALESCE(NULLIF(TRIM(ad.coa_name), ""), NULLIF(TRIM(mc.coa_name), ""), CONCAT("Akun COA ", TRIM(ad.coa_code)))) as coa_name'),
                    DB::raw('MAX(LOWER(TRIM(COALESCE(NULLIF(TRIM(ad.coa_type), ""), NULLIF(TRIM(mc.coa_type), ""), "")))) as coa_type'),
                    DB::raw('COUNT(DISTINCT aj.id_acc_jurnal) as jumlah_jurnal'),
                    DB::raw('COALESCE(SUM(ad.jurnal_debit), 0) as total_debit'),
                    DB::raw('COALESCE(SUM(ad.jurnal_kredit), 0) as total_kredit')
                )
                ->where(function ($q) {
                    $q->whereIn(
                        DB::raw('LOWER(TRIM(COALESCE(NULLIF(TRIM(ad.coa_type), ""), NULLIF(TRIM(mc.coa_type), ""), "")))'),
                        ['pendapatan', 'revenue', 'income', 'penjualan', 'beban', 'expense', 'expenses', 'biaya', 'hpp']
                    )
                        ->orWhereRaw('LEFT(TRIM(ad.coa_code), 1) IN ("4", "5", "6", "7", "8", "9")');
                });

            if ($project !== '') {
                $projLower = strtolower($project);
                $query->where(function ($q) use ($project, $projLower) {
                    $q->whereRaw('LOWER(TRIM(aj.source_project)) = ?', [$projLower])
                        ->orWhereRaw('LOWER(TRIM(aj.source_project)) LIKE ?', ['%' . $projLower . '%']);
                });
            }

            if ($startDate && $endDate) {
                $query->whereBetween('aj.jurnal_tgl', [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->whereDate('aj.jurnal_tgl', '>=', $startDate);
            } elseif ($endDate) {
                $query->whereDate('aj.jurnal_tgl', '<=', $endDate);
            }

            $rows = $query
                ->groupBy(DB::raw('TRIM(ad.coa_code)'))
                ->orderBy(DB::raw('TRIM(ad.coa_code)'), 'ASC')
                ->get();

            $pendapatanItems = collect();
            $bebanItems      = collect();

            foreach ($rows as $row) {
                $debit   = (int) ($row->total_debit ?? 0);
                $kredit  = (int) ($row->total_kredit ?? 0);
                $codeStr = trim((string) ($row->coa_code ?? ''));
                $type    = strtolower(trim((string) ($row->coa_type ?? '')));
                $firstCh = substr($codeStr, 0, 1);

                $isPendapatan = in_array($type, ['pendapatan', 'revenue', 'income', 'penjualan'], true)
                    || ($firstCh === '4' && !in_array($type, ['aset', 'asset', 'kewajiban', 'liabilitas', 'ekuitas', 'equity', 'modal', 'beban', 'expense', 'expenses', 'biaya', 'hpp'], true));

                $isBeban = in_array($type, ['beban', 'expense', 'expenses', 'biaya', 'hpp'], true)
                    || (in_array($firstCh, ['5', '6', '7', '8', '9'], true) && !in_array($type, ['aset', 'asset', 'kewajiban', 'liabilitas', 'ekuitas', 'equity', 'modal', 'pendapatan', 'revenue', 'income', 'penjualan'], true));

                if ($isPendapatan) {
                    $saldo = $kredit - $debit;
                    $pendapatanItems->push((object) [
                        'coa_code'      => $codeStr,
                        'coa_name'      => $row->coa_name,
                        'coa_type'      => 'pendapatan',
                        'jumlah_jurnal' => (int) $row->jumlah_jurnal,
                        'total_debit'   => $debit,
                        'total_kredit'  => $kredit,
                        'saldo'         => $saldo,
                    ]);
                } elseif ($isBeban) {
                    $saldo = $debit - $kredit;
                    $bebanItems->push((object) [
                        'coa_code'      => $codeStr,
                        'coa_name'      => $row->coa_name,
                        'coa_type'      => 'beban',
                        'jumlah_jurnal' => (int) $row->jumlah_jurnal,
                        'total_debit'   => $debit,
                        'total_kredit'  => $kredit,
                        'saldo'         => $saldo,
                    ]);
                }
            }

            $totalPendapatan = (int) $pendapatanItems->sum('saldo');
            $totalBeban      = (int) $bebanItems->sum('saldo');
            $labaBersih      = $totalPendapatan - $totalBeban;
            $marginPersen    = $totalPendapatan > 0 ? round(($labaBersih / $totalPendapatan) * 100, 2) : 0;

            return view('app-accounting.profit-loss-statement', [
                'akses'           => $akses,
                'code'            => $id,
                'projects'        => $projects,
                'project'         => $project,
                'tanggal_awal'    => $tanggalAwal,
                'tanggal_akhir'   => $tanggalAkhir,
                'pendapatanItems' => $pendapatanItems,
                'bebanItems'      => $bebanItems,
                'totalPendapatan' => $totalPendapatan,
                'totalBeban'      => $totalBeban,
                'labaBersih'      => $labaBersih,
                'marginPersen'    => $marginPersen,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function statement_balance_sheet(Request $request, $akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $projects = DB::table('z_menu_super')
                ->orderBy('menu_super_name', 'asc')
                ->get();

            $project      = trim((string)$request->input('project', ''));
            $tanggalAwal  = trim((string)$request->input('tanggal_awal', ''));
            $tanggalAkhir = trim((string)$request->input('tanggal_akhir', ''));

            $startDate = $this->parseGlDate($tanggalAwal);
            $endDate   = $this->parseGlDate($tanggalAkhir);

            if ($startDate && $endDate && $startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }

            $query = DB::table('acc_jurnal_detail as ad')
                ->join('acc_jurnal as aj', 'aj.id_acc_jurnal', '=', 'ad.acc_jurnal_id')
                ->leftJoin('kop_fin_master_coa as mc', function ($join) {
                    $join->on(DB::raw('TRIM(mc.coa_code)'), '=', DB::raw('TRIM(ad.coa_code)'));
                })
                ->select(
                    DB::raw('TRIM(ad.coa_code) as coa_code'),
                    DB::raw('MAX(COALESCE(NULLIF(TRIM(ad.coa_name), ""), NULLIF(TRIM(mc.coa_name), ""), CONCAT("Akun COA ", TRIM(ad.coa_code)))) as coa_name'),
                    DB::raw('MAX(LOWER(TRIM(COALESCE(NULLIF(TRIM(ad.coa_type), ""), NULLIF(TRIM(mc.coa_type), ""), "")))) as coa_type'),
                    DB::raw('COUNT(DISTINCT aj.id_acc_jurnal) as jumlah_jurnal'),
                    DB::raw('COALESCE(SUM(ad.jurnal_debit), 0) as total_debit'),
                    DB::raw('COALESCE(SUM(ad.jurnal_kredit), 0) as total_kredit')
                );

            if ($project !== '') {
                $projLower = strtolower($project);
                $query->where(function ($q) use ($projLower) {
                    $q->whereRaw('LOWER(TRIM(aj.source_project)) = ?', [$projLower])
                        ->orWhereRaw('LOWER(TRIM(aj.source_project)) LIKE ?', ['%' . $projLower . '%']);
                });
            }

            // Neraca (Balance Sheet) bersifat posisi kumulatif sampai dengan Tanggal Akhir
            if ($endDate) {
                $query->whereDate('aj.jurnal_tgl', '<=', $endDate);
            } elseif ($startDate) {
                $query->whereDate('aj.jurnal_tgl', '>=', $startDate);
            }

            $rows = $query
                ->groupBy(DB::raw('TRIM(ad.coa_code)'))
                ->orderBy(DB::raw('TRIM(ad.coa_code)'), 'ASC')
                ->get();

            $asetItems      = collect();
            $kewajibanItems = collect();
            $ekuitasItems   = collect();

            $totalPendapatanMutasi = 0;
            $totalBebanMutasi      = 0;

            foreach ($rows as $row) {
                $debit   = (int) ($row->total_debit ?? 0);
                $kredit  = (int) ($row->total_kredit ?? 0);
                $codeStr = trim((string) ($row->coa_code ?? ''));
                $type    = strtolower(trim((string) ($row->coa_type ?? '')));
                $firstCh = substr($codeStr, 0, 1);

                $isAset = in_array($type, ['aset', 'asset', 'aktiva', 'harta'], true)
                    || ($firstCh === '1' && !in_array($type, ['kewajiban', 'liabilitas', 'liability', 'ekuitas', 'equity', 'modal', 'pendapatan', 'revenue', 'beban', 'expense'], true));

                $isKewajiban = in_array($type, ['kewajiban', 'liabilitas', 'liability', 'liabilities', 'hutang', 'utang', 'passiva'], true)
                    || ($firstCh === '2' && !in_array($type, ['aset', 'asset', 'ekuitas', 'equity', 'modal', 'pendapatan', 'revenue', 'beban', 'expense'], true));

                $isEkuitas = in_array($type, ['ekuitas', 'equity', 'modal', 'capital'], true)
                    || ($firstCh === '3' && !in_array($type, ['aset', 'asset', 'kewajiban', 'liabilitas', 'liability', 'pendapatan', 'revenue', 'beban', 'expense'], true));

                $isPendapatan = in_array($type, ['pendapatan', 'revenue', 'income', 'penjualan'], true)
                    || ($firstCh === '4' && !in_array($type, ['aset', 'asset', 'kewajiban', 'liabilitas', 'ekuitas', 'modal', 'beban', 'expense'], true));

                $isBeban = in_array($type, ['beban', 'expense', 'expenses', 'biaya', 'hpp'], true)
                    || in_array($firstCh, ['5', '6', '7', '8', '9'], true);

                if ($isAset) {
                    $asetItems->push((object) [
                        'coa_code'      => $codeStr,
                        'coa_name'      => $row->coa_name,
                        'jumlah_jurnal' => (int) $row->jumlah_jurnal,
                        'total_debit'   => $debit,
                        'total_kredit'  => $kredit,
                        'saldo'         => $debit - $kredit,
                    ]);
                } elseif ($isKewajiban) {
                    $kewajibanItems->push((object) [
                        'coa_code'      => $codeStr,
                        'coa_name'      => $row->coa_name,
                        'jumlah_jurnal' => (int) $row->jumlah_jurnal,
                        'total_debit'   => $debit,
                        'total_kredit'  => $kredit,
                        'saldo'         => $kredit - $debit,
                    ]);
                } elseif ($isEkuitas) {
                    $ekuitasItems->push((object) [
                        'coa_code'      => $codeStr,
                        'coa_name'      => $row->coa_name,
                        'jumlah_jurnal' => (int) $row->jumlah_jurnal,
                        'total_debit'   => $debit,
                        'total_kredit'  => $kredit,
                        'saldo'         => $kredit - $debit,
                    ]);
                } elseif ($isPendapatan) {
                    $totalPendapatanMutasi += ($kredit - $debit);
                } elseif ($isBeban) {
                    $totalBebanMutasi += ($debit - $kredit);
                }
            }

            $totalAset        = (int) $asetItems->sum('saldo');
            $totalKewajiban   = (int) $kewajibanItems->sum('saldo');
            $totalEkuitas     = (int) $ekuitasItems->sum('saldo');
            $labaRugiBerjalan = $totalPendapatanMutasi - $totalBebanMutasi;

            // Total Kewajiban + Ekuitas + Laba/Rugi Berjalan
            $totalKewajibanEkuitas = $totalKewajiban + $totalEkuitas + $labaRugiBerjalan;
            $selisihNeraca         = $totalAset - $totalKewajibanEkuitas;

            return view('app-accounting.balance-sheet', [
                'akses'                 => $akses,
                'code'                  => $id,
                'projects'              => $projects,
                'project'               => $project,
                'tanggal_awal'          => $tanggalAwal,
                'tanggal_akhir'         => $tanggalAkhir,
                'asetItems'             => $asetItems,
                'kewajibanItems'        => $kewajibanItems,
                'ekuitasItems'          => $ekuitasItems,
                'totalAset'             => $totalAset,
                'totalKewajiban'        => $totalKewajiban,
                'totalEkuitas'          => $totalEkuitas,
                'labaRugiBerjalan'      => $labaRugiBerjalan,
                'totalKewajibanEkuitas' => $totalKewajibanEkuitas,
                'selisihNeraca'         => $selisihNeraca,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function statement_capital_statement(Request $request, $akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $projects = DB::table('z_menu_super')
                ->orderBy('menu_super_name', 'asc')
                ->get();

            $project      = trim((string) $request->input('project', ''));
            $tanggalAwal  = trim((string) $request->input('tanggal_awal', ''));
            $tanggalAkhir = trim((string) $request->input('tanggal_akhir', ''));

            $startDate = $this->parseGlDate($tanggalAwal);
            $endDate   = $this->parseGlDate($tanggalAkhir);

            if ($startDate && $endDate && $startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }

            $baseQuery = function () use ($project) {
                $q = DB::table('acc_jurnal_detail as ad')
                    ->join('acc_jurnal as aj', 'aj.id_acc_jurnal', '=', 'ad.acc_jurnal_id')
                    ->leftJoin('kop_fin_master_coa as mc', 'mc.coa_code', '=', 'ad.coa_code');

                if ($project !== '') {
                    $projLower = strtolower($project);
                    $q->where(function ($sub) use ($projLower) {
                        $sub->whereRaw('LOWER(aj.source_project) = ?', [$projLower])
                            ->orWhereRaw('LOWER(aj.source_project) LIKE ?', ['%' . $projLower . '%']);
                    });
                }

                return $q;
            };

            // 1. Hitung Modal Awal sebelum tanggal_awal (jika tanggal_awal diisi)
            $modalAwal = 0;
            if ($startDate) {
                $priorRows = $baseQuery()
                    ->select(
                        'ad.coa_code',
                        DB::raw('LOWER(COALESCE(NULLIF(ad.coa_type, ""), NULLIF(mc.coa_type, ""), "")) as coa_type'),
                        DB::raw('COALESCE(SUM(ad.jurnal_debit), 0) as total_debit'),
                        DB::raw('COALESCE(SUM(ad.jurnal_kredit), 0) as total_kredit')
                    )
                    ->whereDate('aj.jurnal_tgl', '<', $startDate)
                    ->groupBy(
                        'ad.coa_code',
                        DB::raw('LOWER(COALESCE(NULLIF(ad.coa_type, ""), NULLIF(mc.coa_type, ""), ""))')
                    )
                    ->get();

                foreach ($priorRows as $r) {
                    $d   = (int) ($r->total_debit ?? 0);
                    $k   = (int) ($r->total_kredit ?? 0);
                    $t   = strtolower((string) ($r->coa_type ?? ''));
                    $ch1 = substr(trim((string) $r->coa_code), 0, 1);

                    if ($t === 'ekuitas' || ($t === '' && $ch1 === '3')) {
                        $modalAwal += ($k - $d);
                    } elseif ($t === 'pendapatan' || ($t === '' && $ch1 === '4')) {
                        $modalAwal += ($k - $d);
                    } elseif ($t === 'beban' || ($t === '' && in_array($ch1, ['5', '6', '7'], true))) {
                        $modalAwal -= ($d - $k);
                    }
                }
            }

            // 2. Hitung mutasi pada periode yang dipilih
            $periodQuery = $baseQuery()
                ->select(
                    'ad.coa_code',
                    DB::raw('COALESCE(NULLIF(ad.coa_name, ""), NULLIF(mc.coa_name, ""), CONCAT("Akun COA ", ad.coa_code)) as coa_name'),
                    DB::raw('LOWER(COALESCE(NULLIF(ad.coa_type, ""), NULLIF(mc.coa_type, ""), "")) as coa_type'),
                    DB::raw('COUNT(DISTINCT aj.id_acc_jurnal) as jumlah_jurnal'),
                    DB::raw('COALESCE(SUM(ad.jurnal_debit), 0) as total_debit'),
                    DB::raw('COALESCE(SUM(ad.jurnal_kredit), 0) as total_kredit')
                );

            if ($startDate && $endDate) {
                $periodQuery->whereBetween('aj.jurnal_tgl', [$startDate, $endDate]);
            } elseif ($startDate) {
                $periodQuery->whereDate('aj.jurnal_tgl', '>=', $startDate);
            } elseif ($endDate) {
                $periodQuery->whereDate('aj.jurnal_tgl', '<=', $endDate);
            }

            $periodRows = $periodQuery
                ->groupBy(
                    'ad.coa_code',
                    DB::raw('COALESCE(NULLIF(ad.coa_name, ""), NULLIF(mc.coa_name, ""), CONCAT("Akun COA ", ad.coa_code))'),
                    DB::raw('LOWER(COALESCE(NULLIF(ad.coa_type, ""), NULLIF(mc.coa_type, ""), ""))')
                )
                ->orderBy('ad.coa_code', 'ASC')
                ->get();

            $ekuitasDetails    = collect();
            $tambahanInvestasi = 0;
            $privePenarikan    = 0;
            $pendapatanPeriode = 0;
            $bebanPeriode      = 0;

            foreach ($periodRows as $row) {
                $debit   = (int) ($row->total_debit ?? 0);
                $kredit  = (int) ($row->total_kredit ?? 0);
                $type    = strtolower((string) ($row->coa_type ?? ''));
                $nameLow = strtolower((string) ($row->coa_name ?? ''));
                $firstCh = substr(trim((string) $row->coa_code), 0, 1);

                if ($type === 'ekuitas' || ($type === '' && $firstCh === '3')) {
                    $isPrive = (strpos($nameLow, 'prive') !== false)
                        || (strpos($nameLow, 'penarikan') !== false)
                        || (strpos($nameLow, 'dividen') !== false);

                    $tambahanInvestasi += $kredit;
                    $privePenarikan    += $debit;

                    $ekuitasDetails->push((object) [
                        'coa_code'      => $row->coa_code,
                        'coa_name'      => $row->coa_name,
                        'kategori'      => $isPrive ? 'Prive / Penarikan' : 'Modal / Ekuitas',
                        'jumlah_jurnal' => (int) $row->jumlah_jurnal,
                        'total_debit'   => $debit,
                        'total_kredit'  => $kredit,
                        'net_change'    => $kredit - $debit,
                    ]);
                } elseif ($type === 'pendapatan' || ($type === '' && $firstCh === '4')) {
                    $pendapatanPeriode += ($kredit - $debit);
                } elseif ($type === 'beban' || ($type === '' && in_array($firstCh, ['5', '6', '7'], true))) {
                    $bebanPeriode += ($debit - $kredit);
                }
            }

            $labaBersihPeriode = $pendapatanPeriode - $bebanPeriode;
            $kenaikanModal     = $tambahanInvestasi - $privePenarikan + $labaBersihPeriode;
            $modalAkhir        = $modalAwal + $kenaikanModal;

            return view('app-accounting.capital-statement', [
                'akses'             => $akses,
                'code'              => $id,
                'projects'          => $projects,
                'project'           => $project,
                'tanggal_awal'      => $tanggalAwal,
                'tanggal_akhir'     => $tanggalAkhir,
                'modalAwal'         => $modalAwal,
                'tambahanInvestasi' => $tambahanInvestasi,
                'privePenarikan'    => $privePenarikan,
                'labaBersihPeriode' => $labaBersihPeriode,
                'kenaikanModal'     => $kenaikanModal,
                'modalAkhir'        => $modalAkhir,
                'ekuitasDetails'    => $ekuitasDetails,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // CASH FLOW
    public function statement_cash_flow(Request $request, $akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $projects = DB::table('z_menu_super')
                ->orderBy('menu_super_name', 'asc')
                ->get();

            $project      = trim((string) $request->input('project', ''));
            $tanggalAwal  = trim((string) $request->input('tanggal_awal', ''));
            $tanggalAkhir = trim((string) $request->input('tanggal_akhir', ''));

            $startDate = $this->parseGlDate($tanggalAwal);
            $endDate   = $this->parseGlDate($tanggalAkhir);

            if ($startDate && $endDate && $startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }

            $applyProjectFilter = function ($q) use ($project) {
                if ($project !== '') {
                    $projLower = strtolower($project);
                    $q->where(function ($sub) use ($projLower) {
                        $sub->whereRaw('LOWER(TRIM(aj.source_project)) = ?', [$projLower])
                            ->orWhereRaw('LOWER(TRIM(aj.source_project)) LIKE ?', ['%' . $projLower . '%']);
                    });
                }
            };

            $isCashAccount = function ($coaCode, $coaName, $coaType) {
                $t = strtolower(trim((string) $coaType));
                $n = strtolower(trim((string) $coaName));
                $c = trim((string) $coaCode);

                if (in_array($t, ['kas', 'bank', 'kas & bank', 'kas dan bank', 'cash', 'cash & bank'], true)) {
                    return true;
                }
                if (strpos($n, 'kas') !== false || strpos($n, 'bank') !== false || strpos($n, 'cash') !== false) {
                    return true;
                }
                if (strpos($c, '1.1.1') === 0 || strpos($c, '110') === 0 || strpos($c, '101') === 0) {
                    return true;
                }

                return false;
            };

            $classifyActivity = function ($coaCode, $coaName, $coaType) {
                $t       = strtolower(trim((string) $coaType));
                $n       = strtolower(trim((string) $coaName));
                $c       = trim((string) $coaCode);
                $firstCh = substr($c, 0, 1);

                if (
                    in_array($t, ['pendapatan', 'revenue', 'income', 'penjualan', 'beban', 'expense', 'expenses', 'biaya', 'hpp', 'piutang', 'persediaan', 'hutang usaha', 'utang usaha'], true)
                    || in_array($firstCh, ['4', '5', '6', '7', '8', '9'], true)
                    || strpos($n, 'piutang') !== false
                    || strpos($n, 'persediaan') !== false
                    || strpos($n, 'gaji') !== false
                    || strpos($n, 'listrik') !== false
                    || strpos($n, 'sewa') !== false
                    || strpos($n, 'operasional') !== false
                ) {
                    return 'operasi';
                }

                if (
                    in_array($t, ['aset tetap', 'fixed asset', 'investasi', 'investment'], true)
                    || $firstCh === '1'
                    || strpos($n, 'aset tetap') !== false
                    || strpos($n, 'peralatan') !== false
                    || strpos($n, 'kendaraan') !== false
                    || strpos($n, 'gedung') !== false
                    || strpos($n, 'tanah') !== false
                    || strpos($n, 'investasi') !== false
                ) {
                    return 'investasi';
                }

                if (
                    in_array($t, ['kewajiban', 'liabilitas', 'liability', 'hutang', 'utang', 'ekuitas', 'equity', 'modal', 'capital'], true)
                    || in_array($firstCh, ['2', '3'], true)
                    || strpos($n, 'pinjaman') !== false
                    || strpos($n, 'modal') !== false
                    || strpos($n, 'prive') !== false
                    || strpos($n, 'dividen') !== false
                ) {
                    return 'pendanaan';
                }

                return 'operasi';
            };

            // 1. Hitung Saldo Kas Awal sebelum tanggal_awal (jika tanggal_awal diisi)
            $saldoKasAwal = 0;
            if ($startDate) {
                $priorCashRows = DB::table('acc_jurnal_detail as ad')
                    ->join('acc_jurnal as aj', 'aj.id_acc_jurnal', '=', 'ad.acc_jurnal_id')
                    ->leftJoin('kop_fin_master_coa as mc', function ($join) {
                        $join->on(DB::raw('TRIM(mc.coa_code)'), '=', DB::raw('TRIM(ad.coa_code)'));
                    })
                    ->select(
                        DB::raw('TRIM(ad.coa_code) as coa_code'),
                        DB::raw('MAX(COALESCE(NULLIF(TRIM(ad.coa_name), ""), NULLIF(TRIM(mc.coa_name), ""), CONCAT("Akun COA ", TRIM(ad.coa_code)))) as coa_name'),
                        DB::raw('MAX(LOWER(TRIM(COALESCE(NULLIF(TRIM(ad.coa_type), ""), NULLIF(TRIM(mc.coa_type), ""), "")))) as coa_type'),
                        DB::raw('COALESCE(SUM(ad.jurnal_debit), 0) as total_debit'),
                        DB::raw('COALESCE(SUM(ad.jurnal_kredit), 0) as total_kredit')
                    )
                    ->where($applyProjectFilter)
                    ->whereDate('aj.jurnal_tgl', '<', $startDate)
                    ->groupBy(DB::raw('TRIM(ad.coa_code)'))
                    ->get();

                foreach ($priorCashRows as $pr) {
                    if ($isCashAccount($pr->coa_code, $pr->coa_name, $pr->coa_type)) {
                        $saldoKasAwal += ((int) ($pr->total_debit ?? 0)) - ((int) ($pr->total_kredit ?? 0));
                    }
                }
            }

            // 2. Ambil baris jurnal pada periode untuk menelusuri mutasi kas per aktivitas
            $periodQuery = DB::table('acc_jurnal_detail as ad')
                ->join('acc_jurnal as aj', 'aj.id_acc_jurnal', '=', 'ad.acc_jurnal_id')
                ->leftJoin('kop_fin_master_coa as mc', function ($join) {
                    $join->on(DB::raw('TRIM(mc.coa_code)'), '=', DB::raw('TRIM(ad.coa_code)'));
                })
                ->select(
                    'aj.id_acc_jurnal',
                    'aj.jurnal_tgl',
                    DB::raw('TRIM(ad.coa_code) as coa_code'),
                    DB::raw('COALESCE(NULLIF(TRIM(ad.coa_name), ""), NULLIF(TRIM(mc.coa_name), ""), CONCAT("Akun COA ", TRIM(ad.coa_code))) as coa_name'),
                    DB::raw('LOWER(TRIM(COALESCE(NULLIF(TRIM(ad.coa_type), ""), NULLIF(TRIM(mc.coa_type), ""), ""))) as coa_type'),
                    DB::raw('COALESCE(ad.jurnal_debit, 0) as jurnal_debit'),
                    DB::raw('COALESCE(ad.jurnal_kredit, 0) as jurnal_kredit')
                )
                ->where($applyProjectFilter);

            if ($startDate && $endDate) {
                $periodQuery->whereBetween('aj.jurnal_tgl', [$startDate, $endDate]);
            } elseif ($startDate) {
                $periodQuery->whereDate('aj.jurnal_tgl', '>=', $startDate);
            } elseif ($endDate) {
                $periodQuery->whereDate('aj.jurnal_tgl', '<=', $endDate);
            }

            $linesByJournal = $periodQuery->get()->groupBy('id_acc_jurnal');

            $operasiMap   = [];
            $investasiMap = [];
            $pendanaanMap = [];

            foreach ($linesByJournal as $lines) {
                $cashNetInJournal = 0;
                $counterpartLines = [];

                foreach ($lines as $ln) {
                    $d = (int) ($ln->jurnal_debit ?? 0);
                    $k = (int) ($ln->jurnal_kredit ?? 0);
                    if ($isCashAccount($ln->coa_code, $ln->coa_name, $ln->coa_type)) {
                        $cashNetInJournal += ($d - $k);
                    } else {
                        $counterpartLines[] = $ln;
                    }
                }

                if ($cashNetInJournal === 0) {
                    continue;
                }

                if (count($counterpartLines) > 0) {
                    $totalWeight = 0;
                    foreach ($counterpartLines as $cl) {
                        $w = abs((int) ($cl->jurnal_debit ?? 0) - (int) ($cl->jurnal_kredit ?? 0));
                        if ($w === 0) {
                            $w = max((int) ($cl->jurnal_debit ?? 0), (int) ($cl->jurnal_kredit ?? 0), 1);
                        }
                        $totalWeight += $w;
                    }

                    foreach ($counterpartLines as $cl) {
                        $w = abs((int) ($cl->jurnal_debit ?? 0) - (int) ($cl->jurnal_kredit ?? 0));
                        if ($w === 0) {
                            $w = max((int) ($cl->jurnal_debit ?? 0), (int) ($cl->jurnal_kredit ?? 0), 1);
                        }
                        $share    = $totalWeight > 0 ? ($cashNetInJournal * ($w / $totalWeight)) : $cashNetInJournal;
                        $activity = $classifyActivity($cl->coa_code, $cl->coa_name, $cl->coa_type);
                        $key      = trim((string) $cl->coa_code);

                        if ($activity === 'investasi') {
                            if (!isset($investasiMap[$key])) {
                                $investasiMap[$key] = ['coa_code' => $key, 'coa_name' => $cl->coa_name, 'nominal' => 0];
                            }
                            $investasiMap[$key]['nominal'] += $share;
                        } elseif ($activity === 'pendanaan') {
                            if (!isset($pendanaanMap[$key])) {
                                $pendanaanMap[$key] = ['coa_code' => $key, 'coa_name' => $cl->coa_name, 'nominal' => 0];
                            }
                            $pendanaanMap[$key]['nominal'] += $share;
                        } else {
                            if (!isset($operasiMap[$key])) {
                                $operasiMap[$key] = ['coa_code' => $key, 'coa_name' => $cl->coa_name, 'nominal' => 0];
                            }
                            $operasiMap[$key]['nominal'] += $share;
                        }
                    }
                } else {
                    $key = 'CASH-DIRECT';
                    if (!isset($operasiMap[$key])) {
                        $operasiMap[$key] = ['coa_code' => $key, 'coa_name' => 'Mutasi Langsung Kas & Bank', 'nominal' => 0];
                    }
                    $operasiMap[$key]['nominal'] += $cashNetInJournal;
                }
            }

            $toRoundedCollection = function (array $map) {
                return collect($map)
                    ->map(function ($item) {
                        return (object) [
                            'coa_code' => $item['coa_code'],
                            'coa_name' => $item['coa_name'],
                            'nominal'  => (int) round($item['nominal']),
                        ];
                    })
                    ->sortBy('coa_code')
                    ->values();
            };

            $operasiItems   = $toRoundedCollection($operasiMap);
            $investasiItems = $toRoundedCollection($investasiMap);
            $pendanaanItems = $toRoundedCollection($pendanaanMap);

            $kasOperasi   = (int) $operasiItems->sum('nominal');
            $kasInvestasi = (int) $investasiItems->sum('nominal');
            $kasPendanaan = (int) $pendanaanItems->sum('nominal');

            $kenaikanKasBersih = $kasOperasi + $kasInvestasi + $kasPendanaan;
            $saldoKasAkhir     = $saldoKasAwal + $kenaikanKasBersih;

            return view('app-accounting.cash-flow', [
                'akses'             => $akses,
                'code'              => $id,
                'projects'          => $projects,
                'project'           => $project,
                'tanggal_awal'      => $tanggalAwal,
                'tanggal_akhir'     => $tanggalAkhir,
                'operasiItems'      => $operasiItems,
                'investasiItems'    => $investasiItems,
                'pendanaanItems'    => $pendanaanItems,
                'kasOperasi'        => $kasOperasi,
                'kasInvestasi'      => $kasInvestasi,
                'kasPendanaan'      => $kasPendanaan,
                'kenaikanKasBersih' => $kenaikanKasBersih,
                'saldoKasAwal'      => $saldoKasAwal,
                'saldoKasAkhir'     => $saldoKasAkhir,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // CASH FLOW
    public function statement_notes_to_financial(Request $request, $akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $projects = DB::table('z_menu_super')
                ->orderBy('menu_super_name', 'asc')
                ->get();

            $project      = trim((string) $request->input('project', ''));
            $tanggalAwal  = trim((string) $request->input('tanggal_awal', ''));
            $tanggalAkhir = trim((string) $request->input('tanggal_akhir', ''));

            $startDate = $this->parseGlDate($tanggalAwal);
            $endDate   = $this->parseGlDate($tanggalAkhir);

            if ($startDate && $endDate && $startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }

            $query = DB::table('acc_jurnal_detail as ad')
                ->join('acc_jurnal as aj', 'aj.id_acc_jurnal', '=', 'ad.acc_jurnal_id')
                ->leftJoin('kop_fin_master_coa as mc', function ($join) {
                    $join->on(DB::raw('TRIM(mc.coa_code)'), '=', DB::raw('TRIM(ad.coa_code)'));
                })
                ->select(
                    DB::raw('TRIM(ad.coa_code) as coa_code'),
                    DB::raw('MAX(COALESCE(NULLIF(TRIM(ad.coa_name), ""), NULLIF(TRIM(mc.coa_name), ""), CONCAT("Akun COA ", TRIM(ad.coa_code)))) as coa_name'),
                    DB::raw('MAX(LOWER(TRIM(COALESCE(NULLIF(TRIM(ad.coa_type), ""), NULLIF(TRIM(mc.coa_type), ""), "")))) as coa_type'),
                    DB::raw('COUNT(DISTINCT aj.id_acc_jurnal) as jumlah_jurnal'),
                    DB::raw('COALESCE(SUM(ad.jurnal_debit), 0) as total_debit'),
                    DB::raw('COALESCE(SUM(ad.jurnal_kredit), 0) as total_kredit')
                );

            if ($project !== '') {
                $projLower = strtolower($project);
                $query->where(function ($q) use ($projLower) {
                    $q->whereRaw('LOWER(TRIM(aj.source_project)) = ?', [$projLower])
                        ->orWhereRaw('LOWER(TRIM(aj.source_project)) LIKE ?', ['%' . $projLower . '%']);
                });
            }

            if ($startDate && $endDate) {
                $query->whereBetween('aj.jurnal_tgl', [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->whereDate('aj.jurnal_tgl', '>=', $startDate);
            } elseif ($endDate) {
                $query->whereDate('aj.jurnal_tgl', '<=', $endDate);
            }

            $rows = $query
                ->groupBy(DB::raw('TRIM(ad.coa_code)'))
                ->orderBy(DB::raw('TRIM(ad.coa_code)'), 'ASC')
                ->get();

            $noteItems = collect();

            foreach ($rows as $row) {
                $debit   = (int) ($row->total_debit ?? 0);
                $kredit  = (int) ($row->total_kredit ?? 0);
                $codeStr = trim((string) ($row->coa_code ?? ''));
                $type    = strtolower(trim((string) ($row->coa_type ?? '')));
                $firstCh = substr($codeStr, 0, 1);

                if (in_array($type, ['aset', 'asset', 'aktiva', 'harta'], true) || ($type === '' && $firstCh === '1')) {
                    $kelompok = 'Aset';
                    $saldo    = $debit - $kredit;
                } elseif (in_array($type, ['kewajiban', 'liabilitas', 'liability', 'hutang', 'utang', 'passiva'], true) || ($type === '' && $firstCh === '2')) {
                    $kelompok = 'Kewajiban';
                    $saldo    = $kredit - $debit;
                } elseif (in_array($type, ['ekuitas', 'equity', 'modal', 'capital'], true) || ($type === '' && $firstCh === '3')) {
                    $kelompok = 'Ekuitas';
                    $saldo    = $kredit - $debit;
                } elseif (in_array($type, ['pendapatan', 'revenue', 'income', 'penjualan'], true) || ($type === '' && $firstCh === '4')) {
                    $kelompok = 'Pendapatan';
                    $saldo    = $kredit - $debit;
                } elseif (in_array($type, ['beban', 'expense', 'expenses', 'biaya', 'hpp'], true) || ($type === '' && in_array($firstCh, ['5', '6', '7', '8', '9'], true))) {
                    $kelompok = 'Beban';
                    $saldo    = $debit - $kredit;
                } else {
                    $kelompok = $type !== '' ? ucfirst($type) : 'Lain-lain';
                    $saldo    = $debit - $kredit;
                }

                $noteItems->push((object) [
                    'coa_code'      => $codeStr,
                    'coa_name'      => $row->coa_name,
                    'kelompok'      => $kelompok,
                    'jumlah_jurnal' => (int) $row->jumlah_jurnal,
                    'total_debit'   => $debit,
                    'total_kredit'  => $kredit,
                    'saldo'         => $saldo,
                    'deskripsi'     => 'Ringkasan saldo akun ' . $row->coa_name . ' (' . $kelompok . ') dari ' . (int) $row->jumlah_jurnal . ' jurnal terposting.',
                ]);
            }

            return view('app-accounting.notes-to-financial', [
                'akses'         => $akses,
                'code'          => $id,
                'projects'      => $projects,
                'project'       => $project,
                'tanggal_awal'  => $tanggalAwal,
                'tanggal_akhir' => $tanggalAkhir,
                'noteItems'     => $noteItems,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // CONSOLIDATED
    public function statement_consolidated_financial($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-accounting.consolidated-financial', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER COA
    public function master_accounting_coa($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $total = DB::table('acc_master_coa_data')->where('acc_coa_data_opt', 0)->count();
            $data = DB::table('acc_master_coa')->get();
            return view('app-accounting.master.master-coa', [
                'akses' => $akses,
                'code' => $id,
                'total' => $total,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_accounting_coa_add_level(Request $request)
    {
        $data = DB::table('acc_master_coa_data')->where('acc_master_coa_code', $request->code)->get();
        return view('app-accounting.master.form.form-add-level-coa', [
            'level' => $request->level,
            'code' => $request->code,
            'nomor' => $request->nomor,
            'data' => $data
        ]);
    }
    public function master_accounting_coa_save_level(Request $request)
    {
        try {
            $get = DB::table('acc_master_coa_data')->where('acc_coa_data_code', $request->code)->first();
            if (!$get) {
                $get = DB::table('acc_master_coa')->where('acc_master_coa_code', $request->code)->first();
                $no = $get->acc_master_coa_no;
            } else {
                $no = $get->acc_coa_data_no;
            }
            $total = DB::table('acc_master_coa_data')->where('acc_master_coa_code', $request->code)->count();
            DB::table('acc_master_coa_data')->insert([
                'acc_coa_data_code' => $request->code . str_pad($total + 1, 3, '0', STR_PAD_LEFT),
                'acc_master_coa_code' => $request->code,
                'acc_coa_data_no' => $no . '.' . ($total + 1),
                'acc_coa_data_name' => $request->name,
                'acc_coa_data_type' => 1,
                'acc_coa_data_level' => $request->level,
                'acc_coa_data_opt' => $request->option,
                'acc_coa_data_status' => 1,
                'created_at' => now()
            ]);
            $total = DB::table('acc_master_coa_data')->where('acc_coa_data_opt', 0)->count();
            $data = DB::table('acc_master_coa_data')->where('acc_master_coa_code', $request->code)->get();
            return view('app-accounting.master.form.data-table-coa', ['data' => $data]);
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_accounting_coa_update_level(Request $request)
    {
        $data = DB::table('acc_master_coa_data')->where('acc_coa_data_code', $request->code)->first();
        return view('app-accounting.master.form.form-update-level-coa', ['data' => $data]);
    }
    public function master_accounting_coa_update_save_level(Request $request)
    {
        DB::table('acc_master_coa_data')->where('acc_coa_data_code', $request->code)->update([
            'acc_coa_data_name' => $request->name,
            'acc_coa_data_opt' => $request->option,
        ]);
        return 123;
    }
}
