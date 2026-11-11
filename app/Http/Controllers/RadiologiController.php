<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class RadiologiController extends Controller
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
    public function data_registrasi_radiologi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.radiologi.data-registrasi-radiologi', [
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_radiologi_table(Request $request)
    {
        // Base Query menggunakan skema medical_registrasi, transaksi, dan detail yang baru
        $query = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
            ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
            ->leftJoin('medical_master_doctor as doc_pengirim', 'doc_pengirim.id', '=', 'reg.doctor_id')
            ->where(function ($q) {
                // Filter hanya yang masuk kategori Radiologi (RAD)
                $q->where('tl.prefix', 'LIKE', '%RAD%')
                    ->orWhere('td.no_pemeriksaan', 'LIKE', 'RAD%')
                    ->orWhere(function ($subQ) {
                        $subQ->where('mp.is_paket', 1)
                            ->whereExists(function ($query) {
                                $query->select(DB::raw(1))
                                    ->from('medical_paket_detail as pd')
                                    ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                                    ->join('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                                    ->whereColumn('pd.paket_id', 'mp.id')
                                    ->where('sub_tl.prefix', 'LIKE', '%RAD%');
                            });
                    });
            })
            ->whereNull('td.deleted_at'); // Mengakomodasi softDeletes()

        // Filter Rentang Tanggal berdasarkan kolom tanggal_registrasi
        $tglAwal = $request->input('tgl1');
        $tglAkhir = $request->input('tgl2');
        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $tglAwal . ' 00:00:00',
                $tglAkhir . ' 23:59:59'
            ]);
        }

        // Filter Dokter Rujukan (Berdasarkan ID atau nama dari master doctor)
        if ($request->filled('dokter')) {
            $dokterVal = $request->input('dokter');
            $query->where(function ($q) use ($dokterVal) {
                $q->where('reg.doctor_id', $dokterVal)
                    ->orWhere('doc_pengirim.nama_lengkap', 'like', "%{$dokterVal}%");
            });
        }

        // Filter Penjamin
        if ($request->filled('penjamin')) {
            $query->where('reg.sub_penjamin_id', $request->input('penjamin'));
        }

        // Filter Pemeriksaan Spesifik
        if ($request->filled('pemeriksaan')) {
            $query->where('mp.id', $request->input('pemeriksaan'));
        }

        $totalQuery = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
            ->whereNull('td.deleted_at');

        if ($tglAwal && $tglAkhir) {
            $totalQuery->whereBetween('reg.tanggal_registrasi', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);
        }
        $totalData = $totalQuery->count();

        // Global Search DataTables
        $searchValue = $request->input('search.value') ?? $request->input('search_custom');
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('reg.no_registrasi', 'like', "%{$searchValue}%")
                    ->orWhere('p.nama', 'like', "%{$searchValue}%")
                    ->orWhere('p.pid', 'like', "%{$searchValue}%")
                    ->orWhere('td.no_pemeriksaan', 'like', "%{$searchValue}%")
                    ->orWhere('mp.nama_layanan', 'like', "%{$searchValue}%")
                    ->orWhere('doc_pengirim.nama_lengkap', 'like', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // Pagination & Ordering
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);

        $rawQuery = $query->select([
            'reg.id as registrasi_id',
            'reg.no_registrasi',
            'reg.tanggal_registrasi',
            'doc_pengirim.nama_lengkap as nama_dokter_pengirim',
            'p.pid as rm_pasien',
            'p.nama as nama_pasien',
            'td.id as detail_id',
            'td.no_pemeriksaan as no_pemeriksaan_rad',
            'mp.id as master_pemeriksaan_id',
            'mp.nama_layanan',
            'mp.is_paket',
            'td.status_pemeriksaan',
            't.status_pembayaran'
        ])
            ->orderBy('reg.tanggal_registrasi', 'DESC')
            ->offset($start)
            ->limit($length)
            ->get();

        // Grouping data berdasarkan no_registrasi
        $groupedData = $rawQuery->groupBy('no_registrasi')->map(function ($rows) {
            $first = $rows->first();

            // 1. Kumpulkan ID master pemeriksaan yang sudah menjadi bagian dari paket pada transaksi ini
            $pemeriksaanDalamPaketIds = [];
            foreach ($rows as $row) {
                if ($row->is_paket == 1 || $row->is_paket == true) {
                    $komponenIds = DB::table('medical_paket_detail as pd')
                        ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                        ->leftJoin('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                        ->where('pd.paket_id', $row->master_pemeriksaan_id)
                        ->where('sub_tl.prefix', 'LIKE', '%RAD%')
                        ->pluck('pd.pemeriksaan_id')
                        ->toArray();

                    $pemeriksaanDalamPaketIds = array_merge($pemeriksaanDalamPaketIds, $komponenIds);
                }
            }

            $itemsPemeriksaan = [];
            foreach ($rows as $row) {
                // 2. Jika pemeriksaan satuan ini sudah ada di dalam paket yang diambil, lewati (tidak dimunculkan duplikat)
                if (($row->is_paket != 1 && $row->is_paket != true) && in_array($row->master_pemeriksaan_id, $pemeriksaanDalamPaketIds)) {
                    continue;
                }

                $subPaketItems = [];
                if ($row->is_paket == 1 || $row->is_paket == true) {
                    $subPaketItems = DB::table('medical_paket_detail as pd')
                        ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                        ->leftJoin('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                        ->where('pd.paket_id', $row->master_pemeriksaan_id)
                        ->where('sub_tl.prefix', 'LIKE', '%RAD%')
                        ->select('sub_mp.nama_layanan', 'sub_mp.kode_layanan')
                        ->get();
                }

                $itemsPemeriksaan[] = [
                    'detail_id' => $row->detail_id,
                    'no_pemeriksaan' => $row->no_pemeriksaan_rad,
                    'nama_layanan' => $row->nama_layanan,
                    'is_paket' => $row->is_paket,
                    'status_pemeriksaan' => $row->status_pemeriksaan,
                    'sub_paket' => $subPaketItems
                ];
            }

            return (object)[
                'registrasi_id' => $first->registrasi_id,
                'no_registrasi' => $first->no_registrasi,
                'tanggal_registrasi' => $first->tanggal_registrasi,
                'dokter' => $first->nama_dokter_pengirim ?? '-',
                'rm_pasien' => $first->rm_pasien,
                'nama_pasien' => $first->nama_pasien,
                'status_pembayaran' => $first->status_pembayaran,
                'items' => $itemsPemeriksaan
            ];
        })->filter(function ($group) {
            // Pastikan baris registrasi tidak kosong itemnya setelah difilter
            return count($group->items) > 0;
        })->values();

        // Format Output JSON untuk DataTables
        $formattedData = [];
        $no = $start + 1;

        foreach ($groupedData as $datas) {
            $noRegHtml = '<div class="d-flex flex-column">
                        <span class="code-block text-info">' . e($datas->no_registrasi) . '</span>
                        <span class="text-muted fs--2 mt-1">Reg. Kunjungan</span>
                      </div>';

            $pasienHtml = '<div class="fw-bold text-dark">' . e($datas->nama_pasien) . '</div>
                       <span class="text-muted fs--2">PID: ' . e($datas->rm_pasien) . '</span>';

            $tglHtml = '<div class="text-nowrap text-secondary">
                        <i class="far fa-clock me-1 opacity-50"></i>' . date('d/m/Y H:i', strtotime($datas->tanggal_registrasi)) . '
                    </div>';

            $rujukanHtml = '<span class="text-dark fw-medium">' . e($datas->dokter ?? '-') . '</span>';

            $pemeriksaanHtml = '<div class="d-flex flex-column gap-3">';
            foreach ($datas->items as $item) {
                $paketBadge = ($item['is_paket'] == 1 || $item['is_paket'] == true)
                    ? '<span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">PAKET</span>'
                    : '';

                $subPaketHtml = '';
                if (($item['is_paket'] == 1 || $item['is_paket'] == true) && !empty($item['sub_paket']) && count($item['sub_paket']) > 0) {
                    $subPaketHtml .= '<div class="ms-3 border-start ps-2 my-1">
                                    <span class="text-xs fw-bold text-muted d-block mb-1" style="font-size: 0.7rem;">Isi Paket Pemeriksaan:</span>';
                    foreach ($item['sub_paket'] as $sub) {
                        $subPaketHtml .= '<span class="text-dark fs--2 d-block mb-1">
                                            <i class="fas fa-angle-right text-info me-1"></i> ' . e($sub->nama_layanan) . ' <span class="text-muted">(' . e($sub->kode_layanan) . ')</span>
                                         </span>';
                    }
                    $subPaketHtml .= '</div>';
                }

                $pemeriksaanHtml .= '<div class="border-bottom pb-2 mb-1">
                                    <div>
                                        <span class="list-pemeriksaan-tag">
                                            <i class="fas fa-radiation me-1 text-info fs--2"></i>' . e($item['nama_layanan']) . $paketBadge . '
                                        </span>
                                        <div class="code-block text-danger fs--2 mt-1">
                                            <i class="fas fa-barcode me-1"></i>' . e($item['no_pemeriksaan']) . '
                                        </div>
                                    </div>
                                    ' . $subPaketHtml . '
                                 </div>';
            }
            $pemeriksaanHtml .= '</div>';

            $status = $datas->items[0]['status_pemeriksaan'] ?? 'MENUNGGU';
            if ($status == 'MENUNGGU') {
                $statusHtml = '<span class="badge badge-soft-danger px-2 py-1 rounded-pill"><i class="fas fa-exclamation-circle me-1"></i>Belum</span>';
            } elseif ($status == 'PROSES') {
                $statusHtml = '<span class="badge badge-soft-warning px-2 py-1 rounded-pill"><i class="fas fa-spinner fa-spin me-1"></i>Proses</span>';
            } elseif ($status == 'SELESAI') {
                $statusHtml = '<span class="badge badge-soft-success px-2 py-1 rounded-pill"><i class="fas fa-check me-1"></i>Selesai</span>';
            } elseif ($status == 'BATAL') {
                $statusHtml = '<span class="badge bg-dark text-white px-2 py-1 rounded-pill"><i class="fas fa-times me-1"></i>Batal</span>';
            } else {
                $statusHtml = '<span class="badge badge-soft-info px-2 py-1 rounded-pill">' . e($status) . '</span>';
            }

            $firstNoPemeriksaan = $datas->items[0]['no_pemeriksaan'] ?? '';
            $actionHtml = '<div class="dropdown font-sans-serif position-static">
                        <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            <span class="fas fa-ellipsis-h fs--1"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end border py-2">
                            <a class="dropdown-item text-info fw-medium button-proses-handling-rad" href="#" data-bs-toggle="modal" data-bs-target="#modal-radiologi" data-code="' . e($firstNoPemeriksaan) . '">
                                <i class="fas fa-radiation me-2"></i>Proses Handling Pasien
                            </a>
                        </div>
                       </div>';

            $formattedData[] = [
                'no'            => $no++,
                'no_registrasi' => $noRegHtml,
                'nama_pasien'   => $pasienHtml,
                'tanggal_reg'   => $tglHtml,
                'rujukan'       => $rujukanHtml,
                'pemeriksaan'   => $pemeriksaanHtml,
                'status'        => '<div class="text-center">' . $statusHtml . '</div>',
                'action'        => '<div class="text-center">' . $actionHtml . '</div>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }
    public function data_registrasi_radiologi_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.data-registrasi-radiologi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    public function data_registrasi_radiologi_handling(Request $request)
    {
        $data = DB::table('d_reg_order_rad')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_rad.d_reg_order_rad_code', $request->code)
            ->first();
        return view('application.radiologi.data-registrasi.form-handling', ['data' => $data, 'code' => $request->code]);
    }
    // 1. Fungsi untuk load tampilan awal saja
    public function menu_radiologi_handling($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Hanya me-return view, data pasien akan dimuat via AJAX di background
            return view('application.radiologi.radiologi-handling', [
                'akses' => $akses,
                'code'  => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    // 2. Fungsi BARU untuk mengambil data JSON (dipanggil via AJAX)
    public function getDataRadiologiHandling(Request $request)
    {
        // Ambil parameter filter (Default tanggal hari ini)
        $tglAwal  = $request->input('tgl_awal', date('Y-m-d'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $cari     = $request->input('cari');
        $penjamin = $request->input('penjamin');

        $rawQuery = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
            ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
            ->where(function ($q) {
                $q->where('tl.prefix', 'LIKE', '%RAD%')
                    ->orWhere('td.no_pemeriksaan', 'LIKE', 'RAD%');
            })
            ->whereNull('td.deleted_at')
            ->whereNull('reg.deleted_at')
            ->whereBetween('reg.tanggal_registrasi', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);

        // Filter pencarian
        if (!empty($cari)) {
            $rawQuery->where(function ($q) use ($cari) {
                $q->where('reg.no_registrasi', 'LIKE', "%{$cari}%")
                    ->orWhere('p.nama', 'LIKE', "%{$cari}%");
            });
        }

        // Filter Kelompok Pelanggan
        if (!empty($penjamin) && $penjamin != 'Semua') {
            $rawQuery->where('sp.nama_sub_penjamin', $penjamin);
        }

        $result = $rawQuery->select(
            'reg.id as registrasi_id',
            'reg.no_registrasi',
            'reg.tanggal_registrasi',
            'sp.nama_sub_penjamin as nama_penjamin',
            'p.nama as master_patient_name',
            'p.pid as master_patient_code',
            'td.status_pemeriksaan'
        )
            ->orderBy('reg.tanggal_registrasi', 'DESC')
            ->get();

        // Grouping data
        $data = $result->groupBy('no_registrasi')->map(function ($rows) {
            $first = $rows->first();
            return [
                'registrasi_id'       => $first->registrasi_id,
                'no_registrasi'       => $first->no_registrasi,
                'tanggal_registrasi'  => \Carbon\Carbon::parse($first->tanggal_registrasi)->format('d-m-Y H:i'),
                'penjamin'            => $first->nama_penjamin ?? 'UMUM',
                'master_patient_name' => $first->master_patient_name,
                'status_pemeriksaan'  => $first->status_pemeriksaan
            ];
        })->values();

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function menu_radiologi_handling_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.radiologi-handling', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_radiologi_handling_pasien(Request $request)
    {
        // 1. Validasi input
        if (!$request->filled('code')) {
            return response()->view('components.alert-error', [
                'message' => 'Kode Registrasi Radiologi tidak ditemukan.'
            ], 400);
        }

        $code = $request->code;

        // 2. Ambil data Master Pasien & Transaksi Registrasi
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->where('reg.id', $code)
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'p.pid as master_patient_code',
                'p.nama as master_patient_name',
                'p.no_id as master_patient_nik',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.jk as master_patient_jk',
                'p.no_hp as master_patient_no_hp',
                'p.tempat_lahir as master_patient_tempat_lahir',
                'p.agama as master_patient_agama',
                'p.foto as master_patient_profile',
                't.status_pembayaran'
            )
            ->first();

        if (!$data) {
            return response()->html(
                '<div class="alert alert-warning border-0 rounded-3 shadow-sm p-4 text-center">' .
                    '<i class="fas fa-exclamation-circle fa-2x mb-2 text-warning"></i>' .
                    '<h6>Data Tidak Ditemukan</h6>' .
                    '<p class="mb-0 small">Data Registrasi Radiologi tidak terdaftar di sistem.</p>' .
                    '</div>'
            );
        }

        // 3. Query Detail Pemeriksaan List
        $pemeriksaanList = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
            ->leftJoin('medical_radiologi_handling_log as log', 'log.transaksi_detail_id', '=', 'td.id')
            ->where('t.registrasi_id', $code)
            ->where(function ($q) {
                $q->where('tl.prefix', 'LIKE', '%RAD%')
                    ->orWhere('td.no_pemeriksaan', 'LIKE', 'RAD%');
            })
            ->whereNull('td.deleted_at')
            ->select(
                'td.id as detail_id',
                'td.no_pemeriksaan as order_rad_list_code',
                'td.status_pemeriksaan',
                'mp.kode_layanan as t_pemeriksaan_list_code',
                'mp.nama_layanan as nama_pemeriksaan',
                't.status_pembayaran',
                'log.waktu_mulai',
                'log.waktu_selesai',
                'log.durasi_pengerjaan_menit',
                'log.status_handling'
            )
            ->get();

        // 4. Loop parameter ekspertise & validasi kesiapan
        $pemeriksaanList->transform(function ($item) {
            if (!empty($item->t_pemeriksaan_list_code)) {
                $item->parameters = DB::table('t_pemeriksaan_list_val')
                    ->where('t_pemeriksaan_list_code', $item->t_pemeriksaan_list_code)
                    ->get();
            } else {
                $item->parameters = collect([]);
            }

            // Validasi: Form aktif jika pembayaran valid & status handling minimal sudah proses/selesai
            $isPaid = in_array($item->status_pembayaran, ['LUNAS', 'SEBAGIAN', 'ASURANSI']);
            $item->is_ready = $isPaid && in_array($item->status_pemeriksaan, ['PROSES', 'SELESAI']);

            return $item;
        });

        return view('application.radiologi.radiologi-handling.form-handling-pasien', [
            'data'            => $data,
            'pemeriksaanList' => $pemeriksaanList,
            'code'            => $code
        ]);
    }
    public function mulaiHandling(Request $request)
    {
        $detailId = $request->input('detail_id');
        $orderCode = $request->input('order_code');

        // Update status di transaksi detail
        DB::table('medical_transaksi_detail')->where('id', $detailId)->update([
            'status_pemeriksaan' => 'PROSES'
        ]);

        // Catat log waktu mulai
        DB::table('medical_radiologi_handling_log')->updateOrInsert(
            ['transaksi_detail_id' => $detailId],
            [
                'order_rad_list_code' => $orderCode,
                'user_id' => auth()->id(),
                'nama_petugas' => auth()->user()->name ?? 'Petugas Radiologi',
                'waktu_mulai' => now(),
                'status_handling' => 'DIPROSES',
                'updated_at' => now()
            ]
        );

        return response()->json(['success' => true, 'message' => 'Pemeriksaan mulai diproses.']);
    }
    public function selesaiHandling(Request $request)
    {
        $detailId = $request->input('detail_id');

        $log = DB::table('medical_radiologi_handling_log')->where('transaksi_detail_id', $detailId)->first();
        $waktuMulai = $log && $log->waktu_mulai ? \Carbon\Carbon::parse($log->waktu_mulai) : now();
        $waktuSelesai = now();
        $durasiMenit = $waktuMulai->diffInMinutes($waktuSelesai);

        // Minimal durasi 1 menit jika kurang dari 1 menit
        if ($durasiMenit < 1) {
            $durasiMenit = 1;
        }

        // Update status detail jadi SELESAI
        DB::table('medical_transaksi_detail')->where('id', $detailId)->update([
            'status_pemeriksaan' => 'SELESAI'
        ]);

        // Update log waktu selesai & durasi
        DB::table('medical_radiologi_handling_log')->where('transaksi_detail_id', $detailId)->update([
            'waktu_selesai' => $waktuSelesai,
            'durasi_pengerjaan_menit' => $durasiMenit,
            'status_handling' => 'SELESAI',
            'updated_at' => now()
        ]);

        // UPDATE DI SINI: Kirimkan nilai 'durasi' ke respons JSON agar ditangkap oleh AJAX
        return response()->json([
            'success' => true,
            'durasi' => $durasiMenit,
            'message' => 'Handling pemeriksaan selesai. Silakan isi ekspertise.'
        ]);
    }
    public function menu_radiologi_handling_pasien_old(Request $request)
    {
        // 1. Validasi input
        if (!$request->filled('code')) {
            return response()->view('components.alert-error', [
                'message' => 'Kode Registrasi Radiologi tidak ditemukan.'
            ], 400);
        }

        $code = $request->code;

        // 2. Ambil data Master Pasien & Order
        $data = DB::table('d_reg_order_rad')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_rad.d_reg_order_rad_code', $code)
            ->select('d_reg_order_rad.*', 'd_reg_order.*', 'master_patient.*')
            ->first();

        if (!$data) {
            return response()->html(
                '<div class="alert alert-warning border-0 rounded-3 shadow-sm p-4 text-center">' .
                    '<i class="fas fa-exclamation-circle fa-2x mb-2 text-warning"></i>' .
                    '<h6>Data Tidak Ditemukan</h6>' .
                    '<p class="mb-0 small">No Registrasi Radiologi (' . e($code) . ') tidak terdaftar di sistem.</p>' .
                    '</div>'
            );
        }

        // 3. Query Join Bertahap: d_reg_order_rad_list -> p_sales_data -> t_pemeriksaan_list
        $pemeriksaanList = DB::table('d_reg_order_rad_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
            ->leftJoin('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_rad_list.d_reg_order_rad_code', $code)
            ->select(
                'd_reg_order_rad_list.*',
                'p_sales_data.p_sales_data_name',
                'p_sales_data.t_pemeriksaan_list_code',
                't_pemeriksaan_list.t_pemeriksaan_list_name',
                't_pemeriksaan_list.t_pemeriksaan_list_type'
            )
            ->get();

        // 4. Loop untuk mengambil parameter dari t_pemeriksaan_list_val
        $pemeriksaanList->transform(function ($item) {
            if (!empty($item->t_pemeriksaan_list_code)) {
                $item->parameters = DB::table('t_pemeriksaan_list_val')
                    ->where('t_pemeriksaan_list_code', $item->t_pemeriksaan_list_code)
                    ->get();
            } else {
                $item->parameters = collect([]);
            }

            return $item;
        });

        $layanan = DB::table('t_layanan_cat')->get();

        return view('application.radiologi.radiologi-handling.form-handling-pasien', [
            'data'            => $data,
            'pemeriksaanList' => $pemeriksaanList,
            'layanan'         => $layanan,
            'code'            => $code
        ]);
    }
    // 1. FUNGSI MENAMPILKAN FORM (Telah Diperbarui dengan Logika Kunci Form)
    public function menu_radiologi_verifikasi_handling_pasien(Request $request)
    {
        $registrasiId = $request->input('code');
        $orderRadCode = $request->input('reg');

        $dataPasien = DB::table('medical_registrasi as r')
            ->join('medical_transaksi as t', 't.registrasi_id', '=', 'r.id')
            ->join('medical_patient as p', 'r.pasien_id', '=', 'p.id')
            ->select(
                'r.id as registrasi_id',
                'r.no_registrasi',
                'p.pid as master_patient_code',
                'p.nama as master_patient_name',
                'p.no_id as master_patient_nik',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.jk as master_patient_jk',
                'p.no_hp as master_patient_no_hp',
                'p.tempat_lahir as master_patient_tempat_lahir',
                'p.agama as master_patient_agama',
                'p.foto as master_patient_profile',
                't.status_pembayaran'
            )
            ->where('r.id', $registrasiId)
            ->first();

        if (!$dataPasien) {
            return "<div class='alert alert-danger p-3 rounded-3'>Data pasien tidak ditemukan.</div>";
        }

        $pemeriksaanList = DB::table('medical_transaksi_detail as td')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->select(
                'td.id as detail_id',
                'td.no_pemeriksaan as order_rad_list_code',
                'mp.kode_layanan as t_pemeriksaan_list_code',
                'mp.nama_layanan as nama_pemeriksaan',
                'td.status_pemeriksaan'
            )
            ->where('td.transaksi_id', function ($query) use ($registrasiId) {
                $query->select('id')->from('medical_transaksi')->where('registrasi_id', $registrasiId)->limit(1);
            })
            ->where('td.no_pemeriksaan', 'LIKE', 'RAD%')
            ->whereNull('td.deleted_at')
            ->get();

        foreach ($pemeriksaanList as $item) {
            $status = strtolower($item->status_pemeriksaan ?? '');
            $item->is_ready = ($status === 'proses' || $status === 'selesai');

            // Ambil Data Header Tersimpan
            $savedHeader = DB::table('medical_radiologi_hasil')->where('transaksi_detail_id', $item->detail_id)->first();
            $item->saved_header = $savedHeader;

            // FLAG PENTING: Cek apakah sudah diverifikasi final
            $item->is_verified = ($savedHeader && $savedHeader->status_verifikasi === 'VERIFIED');

            $item->parameters = DB::table('medical_master_pemeriksaan_parameter as mpp')
                ->select(
                    'mpp.kode_parameter as t_pem_list_val_code',
                    'mpp.nama_parameter as t_pem_list_val_name',
                    'mpp.satuan as t_pem_list_val_satuan',
                    'mpp.nilai_rujukan as t_pem_list_val_rujukan',
                    'mpp.tipe_input as t_pem_list_val_opt',
                    'mpp.opsi_input as t_pem_list_val_opt_code',
                    'mpp.baris_textarea as t_pem_list_val_kali'
                )
                ->where('mpp.master_pemeriksaan_id', function ($q) use ($item) {
                    $q->select('id')->from('medical_master_pemeriksaan')->where('kode_layanan', $item->t_pemeriksaan_list_code)->first();
                })
                ->get();

            $savedDetails = collect();
            if ($savedHeader) {
                $savedDetails = DB::table('medical_radiologi_hasil_detail')
                    ->where('radiologi_hasil_id', $savedHeader->id)->get()->keyBy('parameter_code');
            }

            foreach ($item->parameters as $param) {
                $param->saved_value = $savedDetails->has($param->t_pem_list_val_code) ? $savedDetails[$param->t_pem_list_val_code]->nilai_hasil : '';
            }
        }

        return view('application.radiologi.verifikasi-hasil.form-verifikasi-hasil-pasien', [
            'data'            => $dataPasien,
            'pemeriksaanList' => $pemeriksaanList,
            'code'            => $registrasiId
        ]);
    }
    public function simpan_hasil_ekspertise(\Illuminate\Http\Request $request)
    {
        DB::beginTransaction();
        try {
            $detailId = $request->input('transaksi_detail_id');

            if (!$detailId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ID Transaksi Detail tidak ditemukan.'
                ], 422);
            }

            $header = DB::table('medical_radiologi_hasil')->where('transaksi_detail_id', $detailId)->first();

            $dataHeader = [
                'transaksi_detail_id' => $detailId,
                'order_rad_list_code' => $request->input('order_rad_list_code'),
                'klinis_indikasi'     => $request->input('klinis_indikasi'),
                'teknik_pemeriksaan'  => $request->input('teknik_pemeriksaan'),
                'kesan_kesimpulan'    => $request->input('kesan_kesimpulan'),
                'saran'               => $request->input('saran'),
                'dokter_id'           => auth()->id() ?? 1,
                'dokter_radiolog'     => auth()->user()->name ?? 'Dr. Radiologi',
                'updated_at'          => now()
            ];

            if ($header) {
                DB::table('medical_radiologi_hasil')->where('id', $header->id)->update($dataHeader);
                $headerId = $header->id;
            } else {
                $dataHeader['status_verifikasi'] = 'DRAFT';
                $dataHeader['created_at']        = now();
                $headerId = DB::table('medical_radiologi_hasil')->insertGetId($dataHeader);
            }

            // Ambil data detail parameter dari form modal
            $inputDetails = $request->input('details');

            if (!empty($inputDetails) && is_array($inputDetails)) {
                foreach ($inputDetails as $det) {
                    $parameterCode = $det['parameter_code'] ?? 'DEFAULT';
                    $namaParameter = $det['nama_parameter'] ?? 'Parameter';
                    $nilaiHasil    = $det['nilai_hasil'] ?? '';

                    $exist = DB::table('medical_radiologi_hasil_detail')
                        ->where('radiologi_hasil_id', $headerId)
                        ->where('parameter_code', $parameterCode)
                        ->first();

                    if ($exist) {
                        DB::table('medical_radiologi_hasil_detail')
                            ->where('id', $exist->id)
                            ->update([
                                'nilai_hasil' => $nilaiHasil,
                                'updated_at'  => now()
                            ]);
                    } else {
                        DB::table('medical_radiologi_hasil_detail')->insert([
                            'radiologi_hasil_id' => $headerId,
                            'parameter_code'     => $parameterCode,
                            'nama_parameter'     => $namaParameter,
                            'nilai_hasil'        => $nilaiHasil,
                            'created_at'         => now(),
                            'updated_at'         => now()
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Draf berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan ke database: ' . $e->getMessage()
            ], 500);
        }
    }
    // FUNGSI VERIFIKASI FINAL (Dipanggil oleh AJAX saat tombol Verifikasi Final diklik)
    public function verifikasi_final(\Illuminate\Http\Request $request)
    {
        try {
            $detailId = $request->input('transaksi_detail_id');

            if (!$detailId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ID Transaksi Detail tidak ditemukan.'
                ], 422);
            }

            // Cek apakah data header ekspertise sudah ada di database
            $header = DB::table('medical_radiologi_hasil')->where('transaksi_detail_id', $detailId)->first();

            if (!$header) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Harap simpan draf terlebih dahulu sebelum melakukan verifikasi final.'
                ], 422);
            }

            // Ubah status verifikasi menjadi VERIFIED dan catat tanggal verifikasinya
            DB::table('medical_radiologi_hasil')->where('transaksi_detail_id', $detailId)->update([
                'status_verifikasi'  => 'VERIFIED',
                'tanggal_verifikasi' => now(),
                'updated_at'         => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diverifikasi dan dikunci.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }







    public function menu_radiologi_handling_pasien_print_barcode(Request $request) {}
    private $orthancUrl = 'http://192.168.61.249:8042'; // Ganti dengan IP/Port Orthanc Anda
    private $orthancUser = 'orthanc';               // Kosongkan jika tanpa auth
    private $orthancPass = 'orthanc';               // Kosongkan jika tanpa auth
    public function menu_radiologi_handling_pasien_image($code)
    {
        try {
            // 1. Ambil SEMUA item pemeriksaan berdasarkan d_reg_order_rad_code
            $orders = DB::table('d_reg_order_rad_list')
                ->join('d_reg_order_rad', 'd_reg_order_rad.d_reg_order_rad_code', '=', 'd_reg_order_rad_list.d_reg_order_rad_code')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->leftJoin('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
                ->where('d_reg_order_rad_list.d_reg_order_rad_code', $code)
                ->select(
                    'd_reg_order_rad_list.order_rad_list_code',
                    'd_reg_order_rad.d_reg_order_rad_code',
                    'p_sales_data.p_sales_data_name as nama_pemeriksaan'
                )
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Data order tidak ditemukan'], 404);
            }

            $images = [];
            $studiesList = [];

            // 2. LOOPING PER ITEM PEMERIKSAAN (Agar Tombol OHIF Dipisah Per Pemeriksaan)
            foreach ($orders as $item) {
                $listCode = $item->order_rad_list_code;
                $namaPemeriksaan = $item->nama_pemeriksaan ?? 'Pemeriksaan Radiologi';

                // Cari Study di Orthanc berdasarkan PatientID = order_rad_list_code
                $res = Http::withBasicAuth($this->orthancUser, $this->orthancPass)
                    ->post("{$this->orthancUrl}/tools/find", [
                        'Level' => 'Study',
                        'Query' => [
                            'PatientID' => $listCode
                        ]
                    ]);

                if ($res->successful()) {
                    $studies = $res->json();

                    foreach ($studies as $studyId) {
                        $studyDetail = Http::withBasicAuth($this->orthancUser, $this->orthancPass)
                            ->get("{$this->orthancUrl}/studies/{$studyId}")
                            ->json();

                        if (!isset($studyDetail['Series'])) {
                            continue;
                        }

                        // Tambahkan ke daftar Study terpisah per item pemeriksaan
                        $studiesList[] = [
                            'order_rad_list_code' => $listCode,
                            'nama_pemeriksaan'    => $namaPemeriksaan,
                            'orthanc_study_id'   => $studyDetail['ID'] ?? $studyId,
                            'study_description'  => $studyDetail['MainDicomTags']['StudyDescription'] ?? $namaPemeriksaan,
                        ];

                        // Ambil instance gambar untuk preview gallery
                        foreach ($studyDetail['Series'] as $seriesId) {
                            $seriesDetail = Http::withBasicAuth($this->orthancUser, $this->orthancPass)
                                ->get("{$this->orthancUrl}/series/{$seriesId}")
                                ->json();

                            $modality = $seriesDetail['MainDicomTags']['Modality'] ?? 'CR';

                            if (isset($seriesDetail['Instances'])) {
                                foreach ($seriesDetail['Instances'] as $instanceId) {
                                    $images[] = [
                                        'study_id'         => $studyId,
                                        'instance_id'      => $instanceId,
                                        'nama_pemeriksaan' => $namaPemeriksaan,
                                        'preview_url'      => route('menu_radiologi_handling_pasien_rander_image', ['instanceId' => $instanceId]),
                                        'caption'          => "[$modality] " . $namaPemeriksaan . ' - ' . substr($instanceId, 0, 8)
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            return response()->json([
                'success'      => true,
                'studies_list' => $studiesList, // Berisi list study + nama pemeriksaan untuk membuat button OHIF terpisah
                'images'       => $images
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_radiologi_handling_pasien_rander_image($instanceId)
    {
        try {
            // Mengambil preview gambar (PNG) langsung dari API Orthanc
            $response = Http::withBasicAuth($this->orthancUser, $this->orthancPass)
                ->get("{$this->orthancUrl}/instances/{$instanceId}/preview");

            if ($response->failed()) {
                return response('Gagal mengambil preview gambar', 404);
            }

            return response($response->body(), 200)
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'max-age=86400, public');
        } catch (\Exception $e) {
            return response('Error: ' . $e->getMessage(), 500);
        }
    }
    public function menu_radiologi_handling_pasien_simpan_hasil(Request $request)
    {
        // 1. Validasi Request
        $request->validate([
            'code'                    => 'required|string', // Kode pendaftaran utama
            'order_rad_list_code'     => 'required|string', // Unique per-item pemeriksaan
            't_pemeriksaan_list_code' => 'nullable|string',
            'results'                 => 'required|array',
            'results.*.t_pem_list_val_code' => 'required|string',
            'results.*.nilai'                => 'required|string',
        ], [
            'results.*.nilai.required' => 'Semua parameter hasil pemeriksaan wajib diisi.'
        ]);

        DB::beginTransaction();

        try {
            $orderRadListCode = $request->order_rad_list_code;
            $results          = $request->results; // Array data hasil dari form

            foreach ($results as $item) {
                $valCode = $item['t_pem_list_val_code'];
                $nilai   = $item['nilai'];

                // Ambil metode dari master t_pemeriksaan_list_val
                $masterVal = DB::table('t_pemeriksaan_list_val')
                    ->where('t_pem_list_val_code', $valCode)
                    ->first();

                $metode = $masterVal->t_pem_list_val_metode ?? '-';

                // Generate kode unik h_reg_radcode
                $radCode = 'HRAD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

                // Simpan / Update ke tabel h_reg_rad berdasarkan order_rad_list_code
                DB::table('h_reg_rad')->updateOrInsert(
                    [
                        'order_rad_list_code' => $orderRadListCode, // Match per item pemeriksaan
                        't_pem_list_val_code' => $valCode,          // Match per parameter
                    ],
                    [
                        'h_reg_radcode'    => $radCode, // Terisi saat INSERT data baru
                        'h_reg_rad_flag'   => 'COMPLETED',
                        'h_reg_rad_value'  => $nilai,
                        'h_reg_rad_metode' => $metode,
                        'updated_at'       => now(),
                        'created_at'       => now(),
                    ]
                );
            }

            // 2. Update status pada item order (d_reg_order_rad_list / tabel detail order)
            DB::table('d_reg_order_rad_list')
                ->where('order_rad_list_code', $orderRadListCode)
                ->update([
                    'status_pembayaran' => $request->status_pembayaran ?? 'DONE', // atau kolom status terkait
                    'updated_at'        => now()
                ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Hasil ekspertise radiologi berhasil disimpan!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan hasil: ' . $e->getMessage()
            ], 500);
        }
    }
    // VERIFIKASI HASIL RADIOLOGI
    // 1. Fungsi untuk load tampilan awal (View)
    public function hasil_radiologi_verifikasi(\Illuminate\Http\Request $request, $akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.radiologi.verifikasi-hasil-radiologi', [
                'akses' => $akses,
                'code'  => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    // 2. Fungsi BARU untuk mengambil data JSON (dipanggil via AJAX)
    public function getDataVerifikasiRadiologi(\Illuminate\Http\Request $request)
    {
        $tglAwal     = $request->input('tgl_awal', date('Y-m-d'));
        $tglAkhir    = $request->input('tgl_akhir', date('Y-m-d'));
        $cari        = $request->input('cari');
        $penjamin    = $request->input('penjamin');
        $pemeriksaan = $request->input('pemeriksaan');

        $rawQuery = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
            ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
            ->leftJoin('medical_radiologi_handling_log as log', 'log.transaksi_detail_id', '=', 'td.id')
            ->where(function ($q) {
                $q->where('tl.prefix', 'LIKE', '%RAD%')
                    ->orWhere('td.no_pemeriksaan', 'LIKE', 'RAD%');
            })
            ->whereNull('td.deleted_at')
            ->whereNull('reg.deleted_at')
            ->whereBetween('reg.tanggal_registrasi', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);

        if (!empty($cari)) {
            $rawQuery->where(function ($q) use ($cari) {
                $q->where('reg.no_registrasi', 'LIKE', "\%{$cari}%")
                    ->orWhere('p.nama', 'LIKE', "%{$cari}%")
                    ->orWhere('p.pid', 'LIKE', "%{$cari}%");
            });
        }

        if (!empty($penjamin) && $penjamin != 'Semua') {
            $rawQuery->where('sp.nama_sub_penjamin', $penjamin);
        }

        if (!empty($pemeriksaan) && $pemeriksaan != 'Semua') {
            $rawQuery->where('mp.nama_layanan', 'LIKE', "\%{$pemeriksaan}%");
        }

        $result = $rawQuery->select(
            'reg.id as registrasi_id',
            'reg.no_registrasi',
            'reg.tanggal_registrasi',
            'sp.nama_sub_penjamin as nama_penjamin',
            'p.nama as master_patient_name',
            'p.pid as master_patient_code',
            't.status_pembayaran',
            'td.id as detail_id',
            'td.status_pemeriksaan',
            'td.no_pemeriksaan as order_rad_code',
            'log.nama_petugas as nama_dokter_petugas'
        )
            ->orderBy('reg.tanggal_registrasi', 'DESC')
            ->get();

        // Format data sebelum dikirim sebagai JSON
        $data = $result->map(function ($item) {
            $item->tanggal_registrasi_formatted = \Carbon\Carbon::parse($item->tanggal_registrasi)->format('d/m/Y H:i');
            $item->nama_penjamin = $item->nama_penjamin ?? 'UMUM';
            $item->nama_dokter_petugas = $item->nama_dokter_petugas ?? 'Dokter Radiologi';
            return $item;
        });

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function hasil_radiologi_verifikasi_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.verifikasi-hasil-radiologi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function hasil_radiologi_verifikasi_detail(Request $request)
    {
        $code = $request->code; // d_reg_order_rad_code
        $reg  = $request->reg;  // Kode registrasi pasien

        // 1. Ambil daftar pemeriksaan radiologi dari d_reg_order_rad_list
        $pemeriksaanList = DB::table('d_reg_order_rad_list as dro')
            ->leftJoin('p_sales_data as psd', 'dro.p_sales_data_code', '=', 'psd.p_sales_data_code')
            ->leftJoin('t_pemeriksaan_list as tpl', 'dro.p_sales_data_code', '=', 'tpl.t_pemeriksaan_list_code')
            ->where('dro.d_reg_order_rad_code', $reg)
            ->select(
                'dro.order_rad_list_code',
                'dro.p_sales_data_code',
                DB::raw("COALESCE(tpl.t_pemeriksaan_list_code, dro.p_sales_data_code) as t_pemeriksaan_list_code"),
                DB::raw("COALESCE(tpl.t_pemeriksaan_list_name, psd.p_sales_data_name, 'Radiologi') as t_pemeriksaan_list_name")
            )
            ->get();

        // 2. Ambil parameter & hasil ekspertise dari h_reg_rad untuk setiap item pemeriksaan
        foreach ($pemeriksaanList as $item) {
            $item->parameters = DB::table('t_pemeriksaan_list_val as tplv')
                ->leftJoin('h_reg_rad as hrr', function ($join) use ($item) {
                    $join->on('hrr.t_pem_list_val_code', '=', 'tplv.t_pem_list_val_code')
                        ->where('hrr.order_rad_list_code', '=', $item->order_rad_list_code);
                })
                ->where('tplv.t_pemeriksaan_list_code', $item->t_pemeriksaan_list_code)
                ->select(
                    'tplv.t_pem_list_val_code',
                    'tplv.t_pem_list_val_name',
                    'tplv.t_pem_list_val_satuan',
                    'tplv.t_pem_list_val_rujukan',
                    'hrr.h_reg_rad_value',
                    'hrr.h_reg_rad_flag',
                    'hrr.h_reg_rad_metode'
                )
                ->get();

            // Fallback jika pemeriksaan tidak menggunakan sub-parameter/t_pemeriksaan_list_val
            if ($item->parameters->isEmpty()) {
                $item->fallbackResult = DB::table('h_reg_rad')
                    ->where('order_rad_list_code', $item->order_rad_list_code)
                    ->first();
            }
        }

        // 3. Kirim data ke view
        return view('application.radiologi.verifikasi-hasil.verifikasi-hasil-detail', [
            'code'            => $code,
            'reg'             => $reg,
            'pemeriksaanList' => $pemeriksaanList
        ]);
    }
    public function verifikasi_radiologi_preview_report(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_rad_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_rad_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_rad')->where('d_reg_order_rad_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.radiologi.verifikasi-hasil.report.report-hasil-radiologi', [
            'code' => $request->code,
            'data' => $data,
            'reg' => $reg,
            'pemeriksaan' => $pemeriksaan,
        ], compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $dompdf->get_canvas()->page_text(34, 820, "Print by. Admin", $font1, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
            ');
        return base64_encode($pdf->stream());
    }
    public function hasil_radiologi_verifikasi_data(Request $request)
    {
        $registrasiId = $request->code; // ID Registrasi
        $orderRadListCode = $request->reg; // Nomor detail pemeriksaan (order_rad_list_code)

        // 1. Ambil Data Pasien (Tanpa join users yang bermasalah)
        $dataPasien = DB::table('medical_registrasi as r')
            ->join('medical_transaksi as t', 't.registrasi_id', '=', 'r.id')
            ->join('medical_patient as p', 'r.pasien_id', '=', 'p.id')
            ->select(
                'r.id as registrasi_id',
                'r.no_registrasi',
                'p.pid as master_patient_code',
                'p.nama as master_patient_name',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.jk as master_patient_jk',
                'p.alamat as master_patient_alamat',
                'r.created_at'
            )
            ->where('r.id', $registrasiId)
            ->first();

        if (!$dataPasien) {
            return "Data registrasi pasien tidak ditemukan.";
        }

        // Tambahkan properti default untuk dokter rujukan agar aman dipanggil di PDF
        $dataPasien->dokter_rujukan = 'Dokter Rujukan / Luar';

        // 2. Ambil Header Ekspertise & Master Layanan
        $pemeriksaanList = DB::table('medical_transaksi_detail as td')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->join('medical_radiologi_hasil as mrh', 'mrh.transaksi_detail_id', '=', 'td.id')
            ->select(
                'td.id as detail_id',
                'td.no_pemeriksaan as order_rad_list_code',
                'mp.nama_layanan',
                'mrh.id as radiologi_hasil_id',
                'mrh.klinis_indikasi',
                'mrh.teknik_pemeriksaan',
                'mrh.kesan_kesimpulan',
                'mrh.saran',
                'mrh.dokter_radiolog',
                'mrh.tanggal_verifikasi'
            )
            ->where('td.no_pemeriksaan', $orderRadListCode)
            ->get();

        // 3. Ambil Detail Ekspertise untuk setiap pemeriksaan
        foreach ($pemeriksaanList as $pem) {
            $pem->details = DB::table('medical_radiologi_hasil_detail')
                ->where('radiologi_hasil_id', $pem->radiologi_hasil_id)
                ->get();
        }

        $image = base64_encode(file_get_contents(public_path('img/logo.png')));

        // Render PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.radiologi.verifikasi-hasil.report.report-hasil-radiologi', [
            'code'            => $registrasiId,
            'reg'             => $orderRadListCode,
            'data'            => $dataPasien,
            'pemeriksaanList' => $pemeriksaanList,
        ], compact('image'))->setPaper('A4', 'portrait')->setOptions(['defaultFont' => 'Helvetica']);

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
        $pdf->image("img/cover.png", 12, 12, 575, 823);
    ');

        // Password Enkripsi PDF berdasarkan tanggal lahir
        $tglLahir = $dataPasien->master_patient_tgl_lahir ?? date('Y-m-d');
        $pdf->get_canvas()->get_cpdf()->setEncryption("admin", date('dmY', strtotime($tglLahir)));

        // Proses penyimpanan PDF ke storage
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file;
        list($type, $data) = explode(';', $base64Pdf);
        list(, $data) = explode(',', $data);
        $pdfBinaryData = base64_decode($data);

        $tempPdfPath = storage_path('app/public/hasil/rad/' . $request->reg . '.pdf');

        if (!file_exists(dirname($tempPdfPath))) {
            mkdir(dirname($tempPdfPath), 0755, true);
        }

        file_put_contents($tempPdfPath, $pdfBinaryData);

        return 'berhasil';
    }
    public function hasil_radiologi_verifikasi_data_old(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_rad_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_rad_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_rad')->where('d_reg_order_rad_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.radiologi.verifikasi-hasil.report.report-hasil-radiologi', [
            'code' => $request->code,
            'data' => $data,
            'reg' => $reg,
            'pemeriksaan' => $pemeriksaan,
        ], compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
            ');
        $pdf->get_canvas()->get_cpdf()->setEncryption("admin", date('dmY', strtotime($data->master_patient_tgl_lahir)));
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file; // Your Base64 encoded PDF string
        list($type, $data) = explode(';', $base64Pdf);
        list(, $data) = explode(',', $data);
        $pdfBinaryData = base64_decode($data);
        $tempPdfPath = storage_path('app/public/hasil/rad/' . $request->reg . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);
        return 'berhasil';
    }
    // DOKUMENTASI HASIL RADIOLOGI
    public function hasil_radiologi_dokumnatasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.dokumentasi-hasil-radiologi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function dokumentasi_hasil_radiologi_detail(Request $request)
    {
        return view('application.radiologi.dokumentasi-hasil.form-dokumentasi-hasil-radiologi', ['code' => $request->code]);
    }
    public function dokumentasi_hasil_radiologi_detail_kirim_hasil(Request $request)
    {
        $user = DB::table('d_reg_order_rad')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_rad.d_reg_order_rad_code', $request->code)->first();
        $nomorhp = $user->master_patient_no_hp;
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
        // $tempPdfPath = storage_path('app/public/hasil/rpt.pdf');
        $name = storage_path('app/public/hasil/rad/' . $request->code . '.pdf');

        $img = file_get_contents($name);
        // a route is created, (it must already be created in its repository(pdf)).
        // $rute    = "pdf/" . $name;
        $pass = date('dmY', strtotime($user->master_patient_tgl_lahir));
        // decode base64
        $pdf_b64 = base64_encode($img);
        $cek = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->first();
        if ($cek) {
            DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->update([
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Radiologi Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
                'created_at' => now(),
            ]);
        } else {
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid() . mt_rand(1000, 9999),
                'd_reg_order_list_code' => $request->code,
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Radiologi Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
                'created_at' => now(),
            ]);
        }
        return $pdf_b64;
    }
    // DOKUMENTASI HASIL RADIOLOGI
    public function hasil_radiologi_pengiriman($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.dokumentasi-hasil-radiologi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // PACS SERVER
    public function pacs_server_studies_list($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $baseUrl = config('services.orthanc.url');
            $username = config('services.orthanc.username'); // Opsional jika pakai auth
            $password = config('services.orthanc.password'); // Opsional jika pakai auth

            $studiesList = [];

            try {
                // Menyiapkan HTTP Request ke Orthanc
                $http = Http::timeout(10);

                // Tambahkan Basic Auth jika diset di .env
                if ($username && $password) {
                    $http->withBasicAuth($username, $password);
                }

                // Gunakan endpoint /tools/find dengan MINTA TAG ModalitiesInStudy
                $response = $http->post("{$baseUrl}/tools/find", [
                    'Level'         => 'Study',
                    'Query'         => (object)[], // Kosongkan untuk mengambil SEMUA study
                    'Expand'        => true,       // true = sertakan detail tag DICOM pasien
                    'RequestedTags' => ['ModalitiesInStudy'] // <--- INI KUNCINYA agar Modality (CR, DX, CT) langsung keluar
                ]);

                if ($response->successful()) {
                    $studies = $response->json() ?? [];

                    foreach ($studies as $study) {
                        // 1. Ambil Modality dari RequestedTags atau MainDicomTags
                        $modality = $study['RequestedTags']['ModalitiesInStudy']
                            ?? $study['MainDicomTags']['ModalitiesInStudy']
                            ?? null;

                        // Jika masih null/array, format menjadi string (misal "CR" atau "CR, DX")
                        if (is_array($modality)) {
                            $modality = implode(', ', $modality);
                        } elseif (!$modality) {
                            $modality = 'CR'; // Fallback default
                        }

                        // 2. Hitung jumlah instance/gambar DICOM keseluruhan
                        $instancesCount = 0;
                        if (isset($study['Series']) && is_array($study['Series'])) {
                            // Biasanya jumlah instance estimasi dari series
                            $instancesCount = count($study['Series']);
                        }

                        $studiesList[] = [
                            'orthanc_study_id'   => $study['ID'],
                            'patient_id'         => $study['PatientMainDicomTags']['PatientID'] ?? '-',
                            'patient_name'       => $study['PatientMainDicomTags']['PatientName'] ?? 'anon',
                            'patient_birth_date' => $study['PatientMainDicomTags']['PatientBirthDate'] ?? '-',
                            'study_description'  => $study['MainDicomTags']['StudyDescription'] ?? '-',
                            'study_date'         => $study['MainDicomTags']['StudyDate'] ?? '-',
                            'modality'           => $modality, // <--- Sudah berisi CR, DX, CT, MR, dll.
                            'accession_number'   => $study['MainDicomTags']['AccessionNumber'] ?? '-',
                            'series_count'       => count($study['Series'] ?? []),
                            'instances_count'    => $instancesCount,
                        ];
                    }
                } else {
                    Log::error("Orthanc API Error Status: " . $response->status());
                }
            } catch (\Exception $e) {
                Log::error("Gagal terhubung ke Orthanc: " . $e->getMessage());
            }

            return view('application.radiologi.pacs-server.studies-list', compact('studiesList'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function pacs_server_studies_show(Request $request, $studyId)
    {
        $baseUrl = config('services.orthanc.url');
        $username = config('services.orthanc.username');
        $password = config('services.orthanc.password');

        $studyDetail = null;
        $studyInstanceUID = null;

        try {
            $http = Http::timeout(5);
            if ($username && $password) {
                $http->withBasicAuth($username, $password);
            }

            // Ambil detail Study dari Orthanc
            $response = $http->get("{$baseUrl}/studies/{$studyId}");

            if ($response->successful()) {
                $studyDetail = $response->json();
                // Mengambil StudyInstanceUID dari tag DICOM
                $studyInstanceUID = $studyDetail['MainDicomTags']['StudyInstanceUID'] ?? null;
            }
        } catch (\Exception $e) {
            // Handle error jika koneksi gagal
        }

        // =========================================================================
        // SOLUSI: Sisipkan Basic Auth langsung ke dalam URL Viewer
        // =========================================================================
        if ($username && $password) {
            // Mengubah "http://192.168.1.100:8042"
            // Menjadi "http://username:password@192.168.1.100:8042"
            $authenticatedBaseUrl = preg_replace(
                '#^https?://#',
                '$0' . rawurlencode($username) . ':' . rawurlencode($password) . '@',
                $baseUrl
            );
            $viewerUrl = "{$baseUrl}/ohif/viewer?StudyInstanceUIDs={$studyInstanceUID}";
        } else {
            $viewerUrl = "{$baseUrl}/ohif/viewer?StudyInstanceUIDs={$studyInstanceUID}";
        }

        // ATAU Jika OHIF berdiri sendiri (standalone server/docker/app terpisah):
        // $ohifUrl = "http://192.168.1.100:3000/viewer?StudyInstanceUIDs={$studyInstanceUID}";

        return view('application.radiologi.pacs-server.studies-show', compact('viewerUrl', 'studyId', 'studyDetail'));
    }
    public function proxy(Request $request, $path = null)
    {
        $baseUrl  = config('services.orthanc.url');
        $username = config('services.orthanc.username');
        $password = config('services.orthanc.password');

        // Susun target URL ke Orthanc
        $targetUrl = "{$baseUrl}/{$path}";
        if ($request->getQueryString()) {
            $targetUrl .= '?' . $request->getQueryString();
        }

        // Kirim request dari Laravel ke Orthanc membawa Basic Auth
        $http = Http::timeout(15);
        if ($username && $password) {
            $http->withBasicAuth($username, $password);
        }

        // Meneruskan method (GET, POST, dll) beserta body jika ada
        $response = $http->send($request->method(), $targetUrl, [
            'body' => $request->getContent(),
            'headers' => [
                'Content-Type' => $request->header('Content-Type', 'application/json'),
            ]
        ]);

        // Kembalikan response Orthanc langsung ke browser pengguna
        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'))
            ->header('Access-Control-Allow-Origin', '*');
    }
}
