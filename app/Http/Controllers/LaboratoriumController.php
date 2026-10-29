<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\PdfToImage\Pdf;
use App\Services\ZebraPrinterService;

class LaboratoriumController extends Controller
{
    protected $printerService;
    public function __construct(ZebraPrinterService $printerService)
    {
        $this->middleware('auth');
        $this->printerService = $printerService;
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
    // DATA REGISTRASI LAB
    // 1. Render Halaman Utama Lab
    public function data_registrasi_lab($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.laboratorium.data-registrasi-lab', [
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    // 2. Fungsi JSON Server-Side DataTable untuk Lab
    public function data_registrasi_lab_table(Request $request)
    {
        // Base Query mengambil detail transaksi yang masuk kategori Laboratorium
        $query = DB::table('medical_transaksi_detail as td')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
            ->where(function ($q) {
                $q->where('tl.prefix', 'LIKE', '%LAB%')
                    ->orWhere('td.no_pemeriksaan', 'LIKE', 'LAB%')
                    ->orWhere(function ($subQ) {
                        $subQ->where('mp.is_paket', 1)
                            ->whereExists(function ($query) {
                                $query->select(DB::raw(1))
                                    ->from('medical_paket_detail as pd')
                                    ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                                    ->join('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                                    ->whereColumn('pd.paket_id', 'mp.id')
                                    ->where('sub_tl.prefix', 'LIKE', '%LAB%');
                            });
                    });
            });

        // Filter Rentang Tanggal (jika dikirim dari frontend)
        $tglAwal = $request->input('tgl1');
        $tglAkhir = $request->input('tgl2');
        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $tglAwal . ' 00:00:00',
                $tglAkhir . ' 23:59:59'
            ]);
        }

        $totalData = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
            ->count();

        // Global Search DataTables
        $searchValue = $request->input('search.value');
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('reg.no_registrasi', 'like', "%{$searchValue}%")
                    ->orWhere('p.nama', 'like', "%{$searchValue}%")
                    ->orWhere('p.pid', 'like', "%{$searchValue}%")
                    ->orWhere('td.no_pemeriksaan', 'like', "%{$searchValue}%")
                    ->orWhere('mp.nama_layanan', 'like', "%{$searchValue}%");
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
            'reg.dokter as d_reg_order_lab_rujukan',
            'p.pid as d_reg_order_rm',
            'p.title',
            'p.nama as nama_pasien',
            'td.id as detail_id',
            'td.no_pemeriksaan as d_reg_order_lab_code',
            'mp.id as master_pemeriksaan_id',
            'mp.nama_layanan',
            'mp.is_paket',
            'td.status_pemeriksaan'
        ])
            ->orderBy('reg.tanggal_registrasi', 'DESC')
            ->offset($start)
            ->limit($length)
            ->get();

        // Grouping data berdasarkan no_registrasi di tingkat koleksi
        $groupedData = $rawQuery->groupBy('no_registrasi')->map(function ($rows) {
            $first = $rows->first();

            $itemsPemeriksaan = [];
            foreach ($rows as $row) {
                $subPaketItems = [];
                if ($row->is_paket == 1 || $row->is_paket == true) {
                    $subPaketItems = DB::table('medical_paket_detail as pd')
                        ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                        ->leftJoin('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                        ->where('pd.paket_id', $row->master_pemeriksaan_id)
                        ->where('sub_tl.prefix', 'LIKE', '%LAB%')
                        ->select('sub_mp.nama_layanan', 'sub_mp.kode_layanan')
                        ->get();
                }

                $itemsPemeriksaan[] = [
                    'detail_id' => $row->detail_id,
                    'no_pemeriksaan' => $row->d_reg_order_lab_code,
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
                'd_reg_order_lab_rujukan' => $first->d_reg_order_lab_rujukan,
                'd_reg_order_rm' => $first->d_reg_order_rm,
                'title' => $first->title,
                'nama_pasien' => $first->nama_pasien,
                'items' => $itemsPemeriksaan
            ];
        })->values();

        // Format Output untuk DataTables JSON
        $formattedData = [];
        $no = $start + 1;

        foreach ($groupedData as $datas) {
            // HTML Kolom No Registrasi
            $noRegHtml = '<div class="d-flex flex-column">
                            <span class="code-block text-primary">' . e($datas->no_registrasi) . '</span>
                            <span class="text-muted fs--2 mt-1">Reg. Kunjungan</span>
                          </div>';

            // HTML Kolom Nama Pasien
            $pasienHtml = '<div class="fw-bold text-dark">' . e($datas->title) . ' ' . e($datas->nama_pasien) . '</div>
                           <span class="text-muted fs--2">PID: ' . e($datas->d_reg_order_rm) . '</span>';

            // HTML Kolom Tanggal
            $tglHtml = '<div class="text-nowrap text-secondary">
                            <i class="far fa-clock me-1 opacity-50"></i>' . date('d/m/Y H:i', strtotime($datas->tanggal_registrasi)) . '
                        </div>';

            // HTML Kolom Rujukan
            $rujukanHtml = '<span class="text-dark fw-medium">' . e($datas->d_reg_order_lab_rujukan ?? '-') . '</span>';

            // HTML Kolom Pemeriksaan & Paket
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
                                            <i class="fas fa-angle-right text-primary me-1"></i> ' . e($sub->nama_layanan) . ' <span class="text-muted">(' . e($sub->kode_layanan) . ')</span>
                                          </span>';
                    }
                    $subPaketHtml .= '</div>';
                }

                $pemeriksaanHtml .= '<div class="border-bottom pb-2 mb-1">
                                        <div>
                                            <span class="list-pemeriksaan-tag">
                                                <i class="fas fa-flask me-1 text-primary fs--2"></i>' . e($item['nama_layanan']) . $paketBadge . '
                                            </span>
                                            <div class="code-block text-danger fs--2 mt-1">
                                                <i class="fas fa-barcode me-1"></i>' . e($item['no_pemeriksaan']) . '
                                            </div>
                                        </div>
                                        ' . $subPaketHtml . '
                                     </div>';
            }
            $pemeriksaanHtml .= '</div>';

            // HTML Status Badge
            $status = $datas->items[0]['status_pemeriksaan'] ?? 'MENUNGGU';
            if ($status == 'MENUNGGU') {
                $statusHtml = '<span class="badge badge-soft-danger px-2 py-1 rounded-pill"><i class="fas fa-exclamation-circle me-1"></i>Belum</span>';
            } elseif ($status == 'PROSES') {
                $statusHtml = '<span class="badge badge-soft-warning px-2 py-1 rounded-pill"><i class="fas fa-spinner fa-spin me-1"></i>Proses</span>';
            } elseif ($status == 'SELESAI') {
                $statusHtml = '<span class="badge badge-soft-primary px-2 py-1 rounded-pill"><i class="fas fa-award me-1"></i>Selesai</span>';
            } else {
                $statusHtml = '<span class="badge badge-soft-info px-2 py-1 rounded-pill">' . e($status) . '</span>';
            }

            // HTML Kolom Aksi
            $firstNoPemeriksaan = $datas->items[0]['no_pemeriksaan'] ?? '';
            $actionHtml = '<div class="dropdown font-sans-serif position-static">
                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                <span class="fas fa-ellipsis-h fs--1"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end border py-2">
                                <a class="dropdown-item text-warning fw-medium button-proses-handling-lab" href="#" data-bs-toggle="modal" data-bs-target="#modal-lab" data-code="' . e($firstNoPemeriksaan) . '">
                                    <i class="fas fa-dna me-2"></i>Proses Handling Pasien
                                </a>
                            </div>
                           </div>';

            $formattedData[] = [
                'no'           => $no++,
                'no_registrasi' => $noRegHtml,
                'nama_pasien'  => $pasienHtml,
                'tanggal_reg'  => $tglHtml,
                'rujukan'      => $rujukanHtml,
                'pemeriksaan'  => $pemeriksaanHtml,
                'status'       => '<div class="text-center">' . $statusHtml . '</div>',
                'action'       => '<div class="text-center">' . $actionHtml . '</div>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }
    public function data_registrasi_lab_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'd_reg_order_lab.d_reg_order_lab_rujukan')
                ->orderBy('id_d_reg_order_lab', 'DESC')->get();
            // dd($data);
            return view('application.laboratorium.data-registrasi-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_lab_handling(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)
            ->first();
        return view('application.laboratorium.data-registrasi.form-handling', ['data' => $data, 'code' => $request->code]);
    }
    public function data_registrasi_lab_handling_proses(Request $request)
    {
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 1,
            'updated_at' => now()
        ]);
        return 213;
    }
    // SPECIMEN COLLECTION
    public function data_specimen_collection_lab($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Mengambil data registrasi laboratorium yang status pemeriksaannya masih MENUNGGU atau ber-prefix LAB
            $data = DB::table('medical_transaksi_detail as td')
                ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
                ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
                ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
                ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
                ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
                ->where(function ($q) {
                    $q->where('tl.prefix', 'LIKE', '%LAB%')
                        ->orWhere('td.no_pemeriksaan', 'LIKE', 'LAB%');
                })
                ->where('td.status_pemeriksaan', 'MENUNGGU') // Filter status spesimen yang belum diambil/diproses
                ->select([
                    'td.id as id_d_reg_order_lab',
                    'td.no_pemeriksaan as d_reg_order_lab_code',
                    'reg.no_registrasi as d_reg_order_code',
                    'reg.tanggal_registrasi as d_reg_order_date',
                    'p.pid as d_reg_order_rm',
                    'p.title',
                    'p.nama as master_patient_name',
                    'td.status_pemeriksaan as d_reg_order_lab_status'
                ])
                ->orderBy('td.id', 'DESC')
                ->get();

            return view('application.laboratorium.data-specimen-collection', [
                'data' => $data,
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_specimen_collection_lab_cari_data(Request $request)
    {
        $keyword = trim($request->code); // Nomor Registrasi yang di-scan (misal: REG-20261026-0001)

        // 1. Cari data registrasi dan pasien berdasarkan nomor registrasi
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->where('reg.no_registrasi', $keyword)
            ->select([
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'p.id as master_patient_id',
                'p.pid as master_patient_code',
                'p.title',
                'p.nama as master_patient_name',
                'p.no_id as master_patient_nik',
                'p.jk as master_patient_jk',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.tempat_lahir as master_patient_tempat_lahir',
                'p.foto as master_patient_profile',
                'reg.status_kunjungan'
            ])
            ->first();

        if (!$data) {
            return 'false'; // Data registrasi tidak ditemukan
        }

        // 2. Ambil seluruh item pemeriksaan laboratorium berdasarkan registrasi (mendukung paket & item satuan)
        $pemeriksaanRaw = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
            ->where('reg.no_registrasi', $data->no_registrasi)
            ->where(function ($q) {
                $q->where('tl.prefix', 'LIKE', '%LAB%')
                    ->orWhere('td.no_pemeriksaan', 'LIKE', 'LAB%')
                    ->orWhere('mp.is_paket', 1);
            })
            ->select([
                'mp.id as id_t_pemeriksaan_list',
                'mp.kode_layanan as t_pemeriksaan_list_code',
                'mp.nama_layanan as t_pemeriksaan_list_name',
                'mp.is_paket',
                'td.no_pemeriksaan as order_lab_list_code'
            ])
            ->get();

        $finalPemeriksaan = collect();

        // 3. Looping untuk membongkar isi paket jika item berupa paket (`is_paket = 1`)
        foreach ($pemeriksaanRaw as $pem) {
            if ($pem->is_paket == 1 || $pem->is_paket == true) {
                $subItems = DB::table('medical_paket_detail as pd')
                    ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                    ->leftJoin('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                    ->where('pd.paket_id', $pem->id_t_pemeriksaan_list)
                    ->where('sub_tl.prefix', 'LIKE', '%LAB%') // Hanya ambil sub-item yang ber-prefix LAB
                    ->select([
                        'sub_mp.id as id_t_pemeriksaan_list',
                        'sub_mp.kode_layanan as t_pemeriksaan_list_code',
                        'sub_mp.nama_layanan as t_pemeriksaan_list_name',
                        DB::raw("'" . $pem->order_lab_list_code . "' as order_lab_list_code")
                    ])
                    ->get();

                foreach ($subItems as $sub) {
                    $finalPemeriksaan->push($sub);
                }
            } else {
                $finalPemeriksaan->push($pem);
            }
        }

        // Return ke view detail spesimen
        return view('application.laboratorium.speciment-collection.detail-speciment', [
            'data' => $data,
            'pemeriksaan' => $finalPemeriksaan,
            'code' => $keyword
        ]);
    }
    public function data_specimen_collection_lab_proses(Request $request)
    {
        try {
            DB::beginTransaction();

            // Menyesuaikan penangkapan parameter dari request JS
            $pemeriksaanId = $request->code ?? $request->pemeriksaan_id;
            $specimenId    = $request->specimen ?? $request->specimen_id;
            $orderLab      = $request->reg ?? $request->order_lab;

            // 1. Cari transaksi_detail_id berdasarkan no_pemeriksaan (order_lab)
            $transaksiDetail = DB::table('medical_transaksi_detail')
                ->where('no_pemeriksaan', $orderLab)
                ->first();

            $transaksiDetailId = $transaksiDetail ? $transaksiDetail->id : 0;

            // 2. Generate Nomor Barcode Spesimen Unik
            $noBarcode = 'SPL-' . $orderLab . '-' . $specimenId;

            // 3. Pastikan spesimen belum pernah diproses (mencegah error Duplicate Insert)
            $cekCollection = DB::table('medical_specimen_collection')
                ->where('transaksi_detail_id', $transaksiDetailId)
                ->where('specimen_data_id', $specimenId)
                ->first();

            if (!$cekCollection) {
                // Insert ke tabel medical_specimen_collection
                $collectionId = DB::table('medical_specimen_collection')->insertGetId([
                    'transaksi_detail_id' => $transaksiDetailId,
                    'specimen_data_id'    => $specimenId,
                    'no_barcodespesimen'  => $noBarcode,
                    'status_koleksi'      => 'DIPROSES',
                    'waktu_koleksi'       => now(),
                    'petugas_koleksi_id'  => auth()->user()->id ?? 'System',
                    'kondisi_sampel'      => 'Baik',
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);

                // Insert ke tabel log (medical_specimen_log)
                DB::table('medical_specimen_log')->insert([
                    'specimen_collection_id' => $collectionId,
                    'status_log'             => 'DIKOLEKSI',
                    'keterangan'             => 'Waktu pengambilan sampel dimulai',
                    'user_pencatat'          => auth()->user()->name ?? 'System',
                    'waktu_log'              => now(),
                    'created_at'             => now(),
                    'updated_at'             => now(),
                ]);

                // Update status transaksi utama menjadi PROSES jika masih MENUNGGU
                if ($transaksiDetail && $transaksiDetail->status_pemeriksaan == 'MENUNGGU') {
                    DB::table('medical_transaksi_detail')
                        ->where('id', $transaksiDetail->id)
                        ->update([
                            'status_pemeriksaan' => 'PROSES',
                            'updated_at'         => now()
                        ]);
                }
            }

            DB::commit();

            // 4. Ambil data nama spesimen dan tabung untuk ditampilkan di UI
            $specimenData = DB::table('medical_specimen_data')->where('id', $specimenId)->first();
            $specimenName = $specimenData->s_specimen_data_name ?? 'Spesimen';
            $wadahTabung  = $specimenData->wadah_tabung ?? 'Tabung';

            // 5. Kembalikan HTML langsung (Instan Swap UI ke Tombol Print Barcode)
            return '
            <div class="d-inline-flex flex-column align-items-center">
                <button class="btn btn-success btn-sm shadow-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1 btn-print-barcode-satuan"
                    data-barcode="' . $noBarcode . '"
                    title="Klik untuk Cetak Barcode Sampel ke Printer Zebra">
                    <i class="fas fa-barcode"></i> Print (' . $noBarcode . ')
                </button>
                <small class="text-muted fw-semibold mt-1 fs--2">
                    ' . $specimenName . ' (' . $wadahTabung . ')
                </small>
            </div>';
        } catch (\Exception $e) {
            DB::rollBack();
            // Kembalikan pesan error dalam bentuk HTML agar JS tidak hang
            return '<div class="text-danger fs--2 fw-bold"><i class="fas fa-exclamation-triangle"></i> Gagal: ' . $e->getMessage() . '</div>';
        }
    }
    public function data_specimen_collection_lab_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', 1)
                ->get();
            return view('application.laboratorium.data-specimen-collection', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_specimen_collection_lab_cari_data_old(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->code)->get();
        if ($data) {
            if ($data->d_reg_order_lab_status == 0) {
                return 'not';
            } elseif (($data->d_reg_order_lab_status == 1)) {
                return view('application.laboratorium.speciment-collection.detail-speciment', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'code' => $request->code]);
            } elseif (($data->d_reg_order_lab_status >= 2)) {
                return 'done';
            }
        } else {
            return 'false';
        }
    }
    public function data_specimen_collection_lab_detail(Request $request)
    {
        return 123;
    }
    public function data_specimen_collection_lab_print_barcode(Request $request)
    {
        // Parameter query dari frontend
        $detailId   = $request->query('code');     // transaksi_detail_id / no_pemeriksaan
        $registrasiId = $request->query('reg');    // registrasi_id / no_registrasi
        $specimenId = $request->query('specimen'); // ID atau jenis spesimen

        // 1. Ambil data Registrasi, Pasien, & Detail Pemeriksaan dari Database Baru
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
            ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->leftJoin('medical_transaksi_detail as td', 'td.transaksi_id', '=', 't.id')
            ->leftJoin('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->where(function ($q) use ($registrasiId, $detailId) {
                if ($registrasiId) {
                    $q->where('reg.id', $registrasiId)
                        ->orWhere('reg.no_registrasi', $registrasiId);
                }
                if ($detailId) {
                    $q->orWhere('td.id', $detailId)
                        ->orWhere('td.no_pemeriksaan', $detailId);
                }
            })
            ->select(
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'p.pid',
                'p.nama as nama_pasien',
                'p.title',
                'p.jk',
                'p.tgl_lahir',
                'p.umur',
                'td.no_pemeriksaan',
                'mp.nama_layanan'
            )
            ->first();

        // Fallback jika data tidak ditemukan
        if (!$data) {
            return response('
                <div class="alert alert-danger text-center m-0 p-2" style="font-size: 12px;">
                    <i class="fas fa-exclamation-triangle me-1"></i> Data registrasi / spesimen tidak ditemukan.
                </div>
            ', 404);
        }

        // 2. Tentukan Kode yang dijadikan Barcode (Prioritas: No. Pemeriksaan / No. Registrasi)
        $barcodeCode = $data->no_pemeriksaan;

        // 3. Generate Barcode 1D (C128)
        $dns1d = new \Milon\Barcode\DNS1D();
        // Parameter barcode: (code, type, width, height)
        $barcodeHtml = $dns1d->getBarcodeHTML($barcodeCode, 'C128', 1.2, 33);

        // Format Tampilan Data Pasien
        $namaLengkap = strtoupper(($data->title ? $data->title . ' ' : '') . $data->nama_pasien);
        $jenisKelamin = $data->jk == 'L' ? 'L' : ($data->jk == 'P' ? 'P' : '-');
        $tglLahir = $data->tgl_lahir ? date('d/m/Y', strtotime($data->tgl_lahir)) : '-';
        $umur = $data->umur ? $data->umur . ' Thn' : '';

        // 4. Susun HTML Preview Stiker Barcode Laboratorium
        $html = '
        <div style="width: 100%; max-width: 250px; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; color: #000; padding: 4px; box-sizing: border-box; text-align: left;">
            <!-- Header Nama & PID -->
            <div style="font-size: 11px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.2;">
                ' . e($namaLengkap) . '
            </div>

            <div style="font-size: 9.5px; margin-top: 2px; display: flex; justify-content: space-between;">
                <span>PID: <b>' . e($data->pid) . '</b> (' . $jenisKelamin . ')</span>
                <span>' . e($tglLahir) . '</span>
            </div>

            <!-- Area Gambar Barcode -->
            <div style="display: flex; justify-content: center; align-items: center; margin: 4px 0; padding: 2px 0;">
                ' . $barcodeHtml . '
            </div>

            <!-- Text Kode Barcode & Nama Pemeriksaan -->
            <div style="font-size: 10px; font-weight: bold; text-align: center; letter-spacing: 0.5px; line-height: 1.1;">
                ' . e($barcodeCode) . '
            </div>

            <div style="font-size: 8.5px; text-align: center; color: #333; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                ' . e($data->nama_layanan ?? 'Spesimen Lab') . '
            </div>
        </div>
        ';

        return response($html, 200)->header('Content-Type', 'text/html');
    }
    public function data_specimen_collection_lab_print_barcode_proses(Request $request)
    {
        try {
            $code     = $request->input('code');     // id_t_pemeriksaan_list / kode pemeriksaan
            $specimen = $request->input('specimen'); // t_pem_specimen_code / kode spesimen
            $reg      = $request->input('reg');      // order_lab_list_code / no reg yang di-barcode

            // 1. Ambil nama spesimen dari database agar tampilan cetakan lebih informatif
            $specimenData = DB::table('t_pem_specimen as tps')
                ->join('s_specimen_data as ssd', 'ssd.s_specimen_data_code', '=', 'tps.s_specimen_data_code')
                ->where('tps.t_pem_specimen_code', '=', $specimen)
                ->select('ssd.s_specimen_data_name')
                ->first();

            $specimenName = $specimenData->s_specimen_data_name ?? 'Spesimen';

            // 2. Susun Kode ZPL untuk Printer Zebra (Label 5x3 cm @ 203 DPI)
            $zplCode = "^XA";
            $zplCode .= "^CI28"; // Support UTF-8

            // Pengaturan Ukuran Label (400x240 dots)
            $width = 400;
            $zplCode .= "^PW" . $width;
            $zplCode .= "^LL240";
            $zplCode .= "^LS0";

            // Teks Header 1: No. Registrasi / Kode Pemeriksaan
            $zplCode .= "^FO0,20^FB400,1,0,C^A0N,22,22^FDREG: " . $reg . "^FS";

            // Teks Header 2: Nama Spesimen
            $zplCode .= "^FO0,50^FB400,1,0,C^A0N,20,20^FDSAMPEL: " . $specimenName . "^FS";

            // Perhitungan Lebar & Posisi Presisi Barcode (Code 128)
            // Nilai barcode yang dicetak menggunakan $specimen (atau $reg sesuai kebutuhan)
            $barcodeValue = $specimen;
            $skuLength    = strlen($barcodeValue);

            // Modul lebar 2 (BY2) -> estimasi ~11 dots per karakter + quiet zone
            $barcodeWidth = ($skuLength * 11 * 2) + 40;
            $barcodeX     = floor(($width - $barcodeWidth) / 2);

            // Batas aman margin kiri jika teks barcode sangat panjang
            if ($barcodeX < 15) {
                $barcodeX = 15;
            }

            // Cetak Barcode Code128 (^BCN, tinggi 60 dots, print text interpretation below = Y)
            $zplCode .= "^FO" . $barcodeX . ",90^BY2^BCN,60,Y,N,N^FD" . $barcodeValue . "^FS";

            $zplCode .= "^XZ";

            // 3. Eksekusi pengiriman perintah ZPL ke Printer Zebra
            $printResult = $this->printerService->sendToPrinter($zplCode);

            // Periksa status pengiriman printer
            if ($printResult) {
                return response()->json([
                    'success' => true,
                    'message' => 'Label barcode spesimen berhasil dikirim ke printer Zebra.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal terhubung atau mengirim perintah ke printer Zebra.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function data_specimen_collection_lab_proses_old(Request $request)
    {
        DB::table('s_specimen_log')->insert([
            's_specimen_log_code' => $request->reg . '' . Str::upper(Str::random(2)),
            't_pem_specimen_code' => $request->specimen,
            'order_lab_list_code' => $request->reg,
            's_specimen_log_time' => now(),
            's_specimen_log_end_time' => 0,
            's_specimen_log_user' => Auth::user()->userid,
            's_specimen_log_status' => 0,
            'created_at' => now(),
        ]);
        $specimenData = DB::table('t_pem_specimen')
            ->join('s_specimen_data', 's_specimen_data.s_specimen_data_code', '=', 't_pem_specimen.s_specimen_data_code')
            ->where('t_pem_specimen_code', $request->specimen)
            ->first();
        $specimenName = $specimenData->s_specimen_data_name ?? 'Spesimen';
        $codeId     = $request->code;
        $specimenId = $request->specimen;
        $regId      = $request->reg;
        $logTime    = now()->format('H:i');
        return '
        <div class="d-inline-flex flex-column align-items-center">
            <button class="btn btn-warning btn-sm shadow-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                id="button-simpan-specimen' . $codeId . $specimenId . '"
                data-code="' . $codeId . '"
                data-specimen="' . $specimenId . '"
                data-reg="' . $regId . '"
                title="Klik untuk Menyelesaikan Proses Spesimen">
                <i class="fas fa-clock me-1"></i> Proses (' . $logTime . ')
            </button>
            <small class="text-muted fw-semibold mt-1 fs--2">
                ' . $specimenName . '
            </small>
        </div>';
    }
    public function data_specimen_collection_lab_proses_simpan(Request $request)
    {
        DB::table('s_specimen_log')
            ->where('t_pem_specimen_code', $request->specimen)
            ->where('order_lab_list_code', $request->reg)
            ->update([
                's_specimen_log_end_time' => now(),
                's_specimen_log_status'   => 1,
            ]);

        // Ambil data pendukung untuk identifier tombol (jika diperlukan)
        $codeId     = $request->code;
        $specimenId = $request->specimen;
        $regId      = $request->reg;
        // 2. Ambil nama spesimen dari database
        $specimenData = DB::table('t_pem_specimen')
            ->join('s_specimen_data', 's_specimen_data.s_specimen_data_code', '=', 't_pem_specimen.s_specimen_data_code')
            ->where('t_pem_specimen_code', $request->specimen)
            ->first();

        $specimenName = $specimenData->s_specimen_data_name ?? 'Spesimen';
        // Mengembalikan tampilan tombol Selesai + Tombol Print Barcode + Event Handler JS
        return '
        <div class="d-inline-flex flex-column align-items-center">
            <button class="btn btn-success btn-sm shadow-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                id="button-print-barcode-ajax-' . $codeId . '"
                data-code="' . $codeId . '"
                data-specimen="' . $specimenId . '"
                data-reg="' . $regId . '"
                title="Klik untuk Cetak Barcode Sampel">
                <i class="fas fa-barcode"></i> Print Barcode
            </button>
            <small class="text-muted fw-semibold mt-1 fs--2">
                ' . $specimenName . '
            </small>
        </div>

        <script>
            $(document).off("click", "#button-print-barcode-ajax-' . $codeId . '").on("click", "#button-print-barcode-ajax-' . $codeId . '", function(e) {
                e.preventDefault();
                var code = $(this).data("code");
                var specimen = $(this).data("specimen");
                var reg = $(this).data("reg");

                var url = "' . url('data-specimen-collection-lab/print-barcode') . '?code=" + code + "&specimen=" + specimen + "&reg=" + reg;
                window.open(url, "_blank", "width=400,height=500");
            });
        </script>
        ';
    }
    public function data_specimen_collection_lab_proses_simpan_fix(Request $request)
    {
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 2,
            'updated_at' => now(),
        ]);
        return 123;
    }
    // PROSE RESULT
    public function menu_lab_proses_result($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil data detail transaksi lab yang masih proses/menunggu
            $rawQuery = DB::table('medical_transaksi_detail as td')
                ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
                ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
                ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
                ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
                ->whereIn('td.status_pemeriksaan', ['MENUNGGU', 'PROSES'])
                ->select([
                    'reg.id as registrasi_id',
                    'reg.no_registrasi',
                    'reg.tanggal_registrasi as d_reg_order_lab_date',
                    'p.nama as master_patient_name',
                    'p.pid as master_patient_rm',
                    'td.id as detail_id',
                    'td.no_pemeriksaan as d_reg_order_lab_code',
                    'mp.nama_layanan'
                ])
                ->orderBy('reg.tanggal_registrasi', 'ASC')
                ->get();

            // Grouping berdasarkan no_registrasi
            $groupedData = $rawQuery->groupBy('no_registrasi')->map(function ($rows) {
                $first = $rows->first();
                return (object)[
                    'registrasi_id'          => $first->registrasi_id,
                    'no_registrasi'          => $first->no_registrasi,
                    'd_reg_order_lab_date'   => $first->d_reg_order_lab_date,
                    'master_patient_name'    => $first->master_patient_name,
                    'master_patient_rm'      => $first->master_patient_rm,
                    'total_pemeriksaan'      => $rows->count(),
                    'items'                  => $rows // Semua pemeriksaan dalam registrasi ini
                ];
            })->values();

            return view('application.laboratorium.proses-result', [
                'data'  => $groupedData,
                'akses' => $akses,
                'code'  => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_lab_proses_result_detail(Request $request)
    {
        $registrasiId = $request->code;

        // 1. Ambil data registrasi & pasien (sesuaikan kolom yang ada di tabel medical_patient)
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->where('reg.id', $registrasiId)
            ->select(
                'reg.*',
                'p.nama as master_patient_name',
                'p.pid as master_patient_code',
                'p.jk as master_patient_jk',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.tempat_lahir as master_patient_tempat_lahir'
                // Hapus 'p.nik' dan 'p.foto' jika kolom tersebut belum ada di database
            )
            ->first();

        // 2. Ambil daftar pemeriksaan
        $pemeriksaan = [];
        if ($data) {
            $pemeriksaan = DB::table('medical_transaksi_detail as td')
                ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
                ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
                ->where('t.registrasi_id', $data->id)
                ->select(
                    'td.id as detail_id',
                    'td.no_pemeriksaan as order_lab_list_code',
                    'mp.id as t_pemeriksaan_list_code',
                    'mp.nama_layanan as t_pemeriksaan_list_name'
                )
                ->get();
        }

        return view('application.laboratorium.proses-result.proses-result-detail', [
            'data'        => $data,
            'pemeriksaan' => $pemeriksaan,
            'code'        => $data->no_registrasi ?? $registrasiId
        ]);
    }
    public function menu_lab_proses_result_detail_proses_save(Request $request)
    {
        $arrayHasil   = $request->hasil;   // Format: hasil[detail_id][parameter_id] = nilai
        $arrayFlag    = $request->flag;    // Format: flag[detail_id][parameter_id] = nilai
        $arrayCatatan = $request->catatan; // Format: catatan[detail_id][parameter_id] = nilai

        $savedCodes = []; // Array untuk menampung ID parameter yang berhasil disimpan

        if (!empty($arrayHasil)) {
            foreach ($arrayHasil as $detailId => $parameters) {
                foreach ($parameters as $paramId => $nilai) {
                    $flag = $arrayFlag[$detailId][$paramId] ?? null;
                    $catatan = $arrayCatatan[$detailId][$paramId] ?? null;

                    // Simpan atau update ke tabel medical_transaksi_hasil
                    DB::table('medical_transaksi_hasil')->updateOrInsert(
                        [
                            'detail_id'    => $detailId,
                            'parameter_id' => $paramId
                        ],
                        [
                            'hasil'      => $nilai,
                            'flag'       => $flag,
                            'catatan'    => $catatan,
                            'updated_at' => now(),
                            'created_at' => now()
                        ]
                    );

                    // Masukkan kode parameter ke dalam array untuk memberi penanda warna hijau di frontend
                    $savedCodes[] = $paramId;
                }

                // Update status pemeriksaan pada detail transaksi menjadi SELESAI
                DB::table('medical_transaksi_detail')->where('id', $detailId)->update([
                    'status_pemeriksaan' => 'SELESAI',
                    'updated_at'         => now()
                ]);
            }
        }

        // Kembalikan response JSON yang persis diharapkan oleh script AJAX (status, message, dan saved_codes)
        return response()->json([
            'status'      => 'success',
            'message'     => 'Data hasil laboratorium berhasil disimpan.',
            'saved_codes' => $savedCodes
        ]);
    }
    public function menu_lab_proses_result_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', 2)
                ->get();
            return view('application.laboratorium.proses-result', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_lab_proses_result_detail_old(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)
            ->first();

        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->select(
                'd_reg_order_lab_list.order_lab_list_code', // Menambahkan select spesifik untuk order_lab_list_code
                'd_reg_order_lab_list.*',
                'p_sales_data.*',
                't_pemeriksaan_list.*'
            )
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_list.d_reg_order_lab_code', $request->code)
            ->get();

        return view('application.laboratorium.proses-result.detail-proses-result', [
            'data'        => $data,
            'pemeriksaan' => $pemeriksaan,
            'code'        => $request->code
        ]);
    }
    public function menu_lab_proses_result_detail_sinkronisasi(Request $request)
    {
        $d_reg_order_lab_code = $request->input('code'); // Kode Header Order
        $listCodes            = $request->input('list_codes', []); // Array t_pem_list_val_code dari view

        if (empty($listCodes)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada kode parameter yang dikirim dari halaman.'
            ], 400);
        }

        if (empty($d_reg_order_lab_code)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode Header Order Lab tidak boleh kosong.'
            ], 400);
        }

        // 1. Ambil semua item pemeriksaan di bawah header ini
        $labLists = DB::table('d_reg_order_lab_list')
            ->where('d_reg_order_lab_code', $d_reg_order_lab_code)
            ->get();

        if ($labLists->isEmpty()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ditemukan daftar pemeriksaan untuk Kode Order: ' . $d_reg_order_lab_code
            ], 404);
        }

        // 2. Ambil master parameter pemeriksaan berdasarkan list_codes halaman
        $masterParams = DB::table('t_pemeriksaan_list_val')
            ->whereIn('t_pem_list_val_code', $listCodes)
            ->get();

        DB::beginTransaction();
        try {
            $savedCount    = 0;
            $updatedValues = [];
            $foundResult   = false;

            // 3. Loop setiap item pemeriksaan untuk mencari hasil di medical_interface_result
            foreach ($labLists as $labItem) {
                $currentOrderLabListCode = $labItem->order_lab_list_code;

                // Cari data alat berdasarkan nolab = order_lab_list_code
                $interfaceData = DB::table('medical_interface_result')
                    ->where('nolab', $currentOrderLabListCode)
                    ->latest('tanggal')
                    ->first();

                if (!$interfaceData || empty($interfaceData->results)) {
                    continue; // Lanjut ke item pemeriksaan berikutnya jika tidak ada data alat
                }

                $foundResult  = true;
                $instrumentId = $interfaceData->instrument_id ?? $interfaceData->instrumen ?? null;

                // Decode JSON results
                $resultsArray = is_string($interfaceData->results)
                    ? json_decode($interfaceData->results, true)
                    : $interfaceData->results;

                if (!is_array($resultsArray) || empty($resultsArray)) {
                    continue;
                }

                // Loop setiap PX hasil dari alat
                foreach ($resultsArray as $item) {
                    $paramPx   = $item['px'] ?? null;
                    $rawResult = $item['result'] ?? null;
                    $rawFlag   = $item['flag'] ?? null;

                    if ($paramPx === null || $rawResult === null || $rawResult === '') {
                        continue;
                    }

                    // Matching PX ke master parameter
                    $matchedMaster = $masterParams->first(function ($master) use ($paramPx, $instrumentId) {
                        $paramMatches = (string) $master->t_pem_list_val_param === (string) $paramPx;

                        if ($instrumentId && !empty($master->t_pem_list_val_instrumen)) {
                            return $paramMatches && (strcasecmp((string)$master->t_pem_list_val_instrumen, (string)$instrumentId) === 0);
                        }

                        return $paramMatches;
                    });

                    if (!$matchedMaster) {
                        continue;
                    }

                    $testCode = $matchedMaster->t_pem_list_val_code;
                    $metode   = !empty($matchedMaster->t_pem_list_val_metode) ? $matchedMaster->t_pem_list_val_metode : '-';

                    // Parsing Value jika terdapat '^'
                    if (str_contains($rawResult, '^')) {
                        $partsValue = explode('^', $rawResult);
                        $value = !empty($partsValue[1]) ? $partsValue[1] : $partsValue[0];
                    } else {
                        $value = $rawResult;
                    }

                    // Perkalian multiplier
                    $multiplier = $matchedMaster->t_pem_list_val_kali ?? null;
                    if (is_numeric($value) && is_numeric($multiplier) && (float)$multiplier != 0) {
                        $value = (float)$value * (float)$multiplier;
                    }

                    // Parsing Flag
                    $flag = '-';
                    if (!empty($rawFlag)) {
                        if (str_contains($rawFlag, '^')) {
                            $partsFlag = explode('^', $rawFlag);
                            $flag = !empty($partsFlag[1]) ? $partsFlag[1] : $partsFlag[0];
                        } else {
                            $flag = $rawFlag;
                        }
                    }

                    // Cek existing record di h_reg_lab berdasarkan order_lab_list_code aktif
                    $existing = DB::table('h_reg_lab')
                        ->where('order_lab_list_code', $currentOrderLabListCode)
                        ->where('t_pem_list_val_code', $testCode)
                        ->first();

                    // Upsert ke h_reg_lab
                    DB::table('h_reg_lab')->updateOrInsert(
                        [
                            'order_lab_list_code' => $currentOrderLabListCode,
                            't_pem_list_val_code' => $testCode,
                        ],
                        [
                            'h_reg_lab_code'   => $existing ? $existing->h_reg_lab_code : 'LAB-' . strtoupper(Str::random(10)),
                            'h_reg_lab_value'  => $value,
                            'h_reg_lab_flag'   => $flag,
                            'h_reg_lab_metode' => $metode,
                            'updated_at'       => now(),
                            'created_at'       => $existing ? $existing->created_at : now(),
                        ]
                    );

                    $updatedValues[$testCode] = $value;
                    $savedCount++;
                }
            }

            if (!$foundResult && $savedCount === 0) {
                DB::rollBack();
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Tidak ditemukan data hasil alat untuk seluruh daftar pemeriksaan di bawah Kode Order: ' . $d_reg_order_lab_code
                ], 404);
            }

            DB::commit();

            return response()->json([
                'status'         => 'success',
                'message'        => 'Berhasil menyinkronkan ' . $savedCount . ' parameter.',
                'total_item_lab' => $labLists->count(),
                'data'           => $updatedValues
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_lab_proses_result_simpan_sinkronisasi(Request $request)
    {
        $dRegOrderLabCode = $request->input('code'); // Kode Header (d_reg_order_lab_code)
        $hasilData        = $request->input('hasil', []);  // Array [t_pem_list_val_code => value]
        $flagData         = $request->input('flag', []);   // Array [t_pem_list_val_code => flag]
        $metodeData       = $request->input('metode', []); // Array [t_pem_list_val_code => metode]

        $savedCodes = [];

        DB::beginTransaction();
        try {
            foreach ($hasilData as $valCode => $value) {
                // 1. Abaikan jika nilai hasil kosong
                if ($value === null || $value === '') {
                    continue;
                }

                // 2. Ambil data master parameter & proteksi jika Parent Header (opt = 'Y')
                $masterVal = DB::table('t_pemeriksaan_list_val')
                    ->where('t_pem_list_val_code', $valCode)
                    ->first();

                if ($masterVal && $masterVal->t_pem_list_val_opt === 'Y') {
                    continue;
                }

                // 3. Cari order_lab_list_code berdasarkan d_reg_order_lab_code dan t_pemeriksaan_list_code induknya
                $labList = DB::table('d_reg_order_lab_list')
                    ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
                    ->where('d_reg_order_lab_list.d_reg_order_lab_code', $dRegOrderLabCode)
                    ->where('p_sales_data.t_pemeriksaan_list_code', $masterVal->t_pemeriksaan_list_code)
                    ->select('d_reg_order_lab_list.order_lab_list_code')
                    ->first();

                // Jika relasi daftar order lab tidak ditemukan, lewati
                if (!$labList) {
                    continue;
                }

                $orderLabListCode = $labList->order_lab_list_code;
                $flag   = $flagData[$valCode] ?? '*';
                $metode = $metodeData[$valCode] ?? ($masterVal->t_pem_list_val_metode ?? '-');

                // 4. Cek apakah record di h_reg_lab sudah ada berdasarkan order_lab_list_code
                $existing = DB::table('h_reg_lab')
                    ->where('order_lab_list_code', $orderLabListCode)
                    ->where('t_pem_list_val_code', $valCode)
                    ->first();

                if ($existing) {
                    // Update record
                    DB::table('h_reg_lab')
                        ->where('order_lab_list_code', $orderLabListCode)
                        ->where('t_pem_list_val_code', $valCode)
                        ->update([
                            'h_reg_lab_flag'   => $flag,
                            'h_reg_lab_value'  => $value,
                            'h_reg_lab_metode' => $metode,
                            'updated_at'       => now(),
                        ]);
                } else {
                    // Insert record baru
                    DB::table('h_reg_lab')->insert([
                        'h_reg_lab_code'      => 'LAB-' . strtoupper(Str::random(10)),
                        'order_lab_list_code' => $orderLabListCode,
                        't_pem_list_val_code' => $valCode,
                        'h_reg_lab_flag'      => $flag,
                        'h_reg_lab_value'     => $value,
                        'h_reg_lab_metode'    => $metode,
                        'created_at'          => now(),
                        'updated_at'          => now(),
                    ]);
                }

                $savedCodes[] = $valCode;
            }

            DB::commit();

            return response()->json([
                'status'      => 'success',
                'message'     => 'Data hasil pemeriksaan berhasil disimpan!',
                'saved_codes' => $savedCodes
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_lab_proses_result_detail_proses_save_old(Request $request)
    {
        $data = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->join('t_pemeriksaan_list_val', 't_pemeriksaan_list_val.t_pemeriksaan_list_code', '=', 't_pemeriksaan_list.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_list.d_reg_order_lab_code', $request->code)->get();
        foreach ($data as $value) {
            $cek = DB::table('h_reg_lab')->where('d_reg_order_lab_code', $request->code)->where('t_pem_list_val_code', $value->t_pem_list_val_code)->first();
            if ($cek) {
                DB::table('h_reg_lab')
                    ->where('d_reg_order_lab_code', $request->code)
                    ->where('t_pem_list_val_code', $value->t_pem_list_val_code)->update([
                        'h_reg_lab_value' => $request[$value->t_pem_list_val_code],
                        'h_reg_lab_metode' => $request['opt' . $value->t_pem_list_val_code],
                        'created_at' => now()
                    ]);
            } else {
                DB::table('h_reg_lab')->insert([
                    'h_reg_lab_code' => str::uuid(),
                    'd_reg_order_lab_code' => $request->code,
                    't_pem_list_val_code' => $value->t_pem_list_val_code,
                    'h_reg_lab_value' => $request[$value->t_pem_list_val_code],
                    'h_reg_lab_metode' => $request['opt' . $value->t_pem_list_val_code],
                    'created_at' => now()
                ]);
            }
        }
        $datax = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->code)->get();
        return view('application.laboratorium.proses-result.detail-proses-result', ['data' => $datax, 'pemeriksaan' => $pemeriksaan, 'code' => $request->code]);
    }
    // VERIFIKASI LAB
    public function verifikasi_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Mengambil registrasi yang memiliki pemeriksaan lab dengan status 'SELESAI' (Menunggu Verifikasi)
            $rawQuery = DB::table('medical_transaksi_detail as td')
                ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
                ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
                ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
                ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
                ->where('td.status_pemeriksaan', 'SELESAI') // Syarat: Hasil sudah diisi di menu Proses Result
                ->select([
                    'reg.id as registrasi_id',
                    'reg.no_registrasi',
                    'reg.tanggal_registrasi as d_reg_order_date',
                    'reg.dokter as master_doctor_name',
                    'p.nama as master_patient_name',
                    'p.pid as master_patient_rm',
                    'td.id as detail_id',
                    'td.no_pemeriksaan as d_reg_order_lab_code',
                    'td.status_pemeriksaan',
                    'mp.nama_layanan'
                ])
                ->orderBy('reg.tanggal_registrasi', 'DESC')
                ->get();

            // Grouping berdasarkan no_registrasi agar tidak duplikat baris pasien
            $groupedData = $rawQuery->groupBy('no_registrasi')->map(function ($rows) {
                $first = $rows->first();
                return (object)[
                    'registrasi_id'       => $first->registrasi_id,
                    'no_registrasi'       => $first->no_registrasi,
                    'd_reg_order_date'    => $first->d_reg_order_date,
                    'master_doctor_name'  => $first->master_doctor_name,
                    'master_patient_name' => $first->master_patient_name,
                    'master_patient_rm'   => $first->master_patient_rm,
                    'items'               => $rows, // Daftar layanan/pemeriksaan
                    'status'              => $first->status_pemeriksaan
                ];
            })->values();

            return view('application.laboratorium.verifikasi-hasil-lab', [
                'data'  => $groupedData,
                'akses' => $akses,
                'code'  => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function verifikasi_laboratorium_detail(Request $request)
    {
        $registrasiId = $request->code; // ID dari medical_registrasi
        $noReg = $request->reg;         // Nomor Registrasi

        // 1. Ambil data registrasi & pasien (Hanya kolom yang ada di database)
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->where('reg.id', $registrasiId)
            ->select(
                'reg.no_registrasi',
                'p.nama as master_patient_name',
                'p.pid as master_patient_code',
                'p.jk as master_patient_jk',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.tempat_lahir as master_patient_tempat_lahir'
            )
            ->first();

        // 2. Ambil list pemeriksaan lab untuk registrasi tersebut
        $pemeriksaan = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->where('t.registrasi_id', $registrasiId)
            ->select(
                'td.id as detail_id',
                'td.no_pemeriksaan as order_lab_list_code',
                'mp.id as t_pemeriksaan_list_code',
                'mp.nama_layanan as t_pemeriksaan_list_name'
            )
            ->get();

        return view('application.laboratorium.verifikasi-hasil.verifikasi-hasil-detail', [
            'code'        => $registrasiId,
            'reg'         => $noReg,
            'pemeriksaan' => $pemeriksaan,
            'data'        => $data,
        ]);
    }
    public function verifikasi_laboratorium_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'd_reg_order_lab.d_reg_order_lab_rujukan')
                ->where('d_reg_order_lab_status', 2)
                ->get();
            return view('application.laboratorium.verifikasi-hasil-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function verifikasi_laboratorium_detail_old(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->reg)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        return view('application.laboratorium.verifikasi-hasil.verifikasi-hasil-detail', [
            'code' => $request->code,
            'reg' => $request->reg,
            'pemeriksaan' => $pemeriksaan,
            'data' => $data,
        ]);
    }
    public function verifikasi_laboratorium_verifikasi_data(Request $request)
    {
        $registrasiId = $request->code; // ID registrasi (medical_registrasi)
        $noReg        = $request->reg;  // Nomor Registrasi string

        // 1. Ambil Data Registrasi & Pasien
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->where('reg.id', $registrasiId)
            ->select(
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'reg.dokter',
                'p.nama as nama_pasien',
                'p.pid as rm_pasien',
                'p.jk as jk_pasien',
                'p.alamat as alamat_pasien',
                'p.tgl_lahir as tgl_lahir_pasien'
            )
            ->first();

        // 2. Ambil Data Layanan Pemeriksaan
        $pemeriksaan = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->where('t.registrasi_id', $registrasiId)
            ->select(
                'td.id as detail_id',
                'td.no_pemeriksaan',
                'mp.id as master_pemeriksaan_id',
                'mp.nama_layanan'
            )
            ->get();

        $image = base64_encode(file_get_contents(public_path('img/logo.png')));

        // 3. Generate PDF View
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', [
            'code'        => $registrasiId,
            'reg'         => $noReg,
            'data'        => $data,
            'pemeriksaan' => $pemeriksaan,
        ], compact('image'))->setPaper('A4', 'portrait')->setOptions(['defaultFont' => 'Helvetica']);

        $pdf->output();

        // Atur background/cover
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
        ');

        // 4. Enkripsi PDF (Password: Tanggal Lahir Pasien format dmy/dmY)
        $passwordPdf = date('dmY', strtotime($data->tgl_lahir_pasien));
        $pdf->get_canvas()->get_cpdf()->setEncryption("admin", $passwordPdf);

        // 5. Simpan PDF ke Storage
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file;
        list($type, $pdfData) = explode(';', $base64Pdf);
        list(, $pdfData) = explode(',', $pdfData);
        $pdfBinaryData = base64_decode($pdfData);

        // Pastikan direktori tersedia
        $folderPath = storage_path('app/public/hasil/lab/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $tempPdfPath = $folderPath . $noReg . '.pdf';
        file_put_contents($tempPdfPath, $pdfBinaryData);

        // 6. Update Status Pemeriksaan menjadi TERVERIFIKASI
        DB::table('medical_transaksi_detail')
            ->join('medical_transaksi as t', 'medical_transaksi_detail.transaksi_id', '=', 't.id')
            ->where('t.registrasi_id', $registrasiId)
            ->update([
                // Tambahkan prefix nama tabel agar spesifik dan tidak ambigu
                'medical_transaksi_detail.status_pemeriksaan' => 'TERVERIFIKASI',
                'medical_transaksi_detail.updated_at'         => now(),
            ]);

        return 'berhasil';
    }
    public function verifikasi_laboratorium_verifikasi_data_old(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', [
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
        $tempPdfPath = storage_path('app/public/hasil/lab/' . $request->reg . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->update([
            'd_reg_order_lab_status' => 3,
            'updated_at' => now(),
        ]);
        return 'berhasil';
    }
    public function verifikasi_laboratorium_preview_report(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', [
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
    // DOKUMENTASI HASIL
    public function dokumentasi_hasil_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Mengambil registrasi lab yang statusnya 'TERVERIFIKASI' atau setara (> 2)
            $rawQuery = DB::table('medical_transaksi_detail as td')
                ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
                ->join('medical_registrasi as reg', 't.registrasi_id', '=', 'reg.id')
                ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
                ->whereIn('td.status_pemeriksaan', ['TERVERIFIKASI', 'SELESAI']) // Disesuaikan dengan status tahap lanjut
                ->select([
                    'reg.id as registrasi_id',
                    'reg.no_registrasi',
                    'reg.tanggal_registrasi as d_reg_order_lab_date',
                    'p.nama as master_patient_name',
                    'p.pid as master_patient_rm',
                    'td.id as detail_id',
                    'td.no_pemeriksaan as d_reg_order_lab_code',
                    'td.status_pemeriksaan'
                ])
                ->orderBy('reg.tanggal_registrasi', 'DESC')
                ->get();

            // Grouping berdasarkan no_registrasi
            $groupedData = $rawQuery->groupBy('no_registrasi')->map(function ($rows) {
                $first = $rows->first();
                return (object)[
                    'registrasi_id'         => $first->registrasi_id,
                    'no_registrasi'         => $first->no_registrasi,
                    'd_reg_order_lab_date'  => $first->d_reg_order_lab_date,
                    'master_patient_name'   => $first->master_patient_name,
                    'master_patient_rm'     => $first->master_patient_rm,
                    'd_reg_order_lab_code'  => $first->d_reg_order_lab_code, // Kode unik untuk target AJAX detail
                    'total_pemeriksaan'     => $rows->count(),
                    'items'                 => $rows
                ];
            })->values();

            return view('application.laboratorium.dokumentasi-hasil-lab', [
                'data'  => $groupedData,
                'akses' => $akses,
                'code'  => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function dokumentasi_hasil_laboratorium_detail(Request $request)
    {
        $registrasiId = $request->code; // Ini adalah registrasi_id

        // Ambil data registrasi, pasien, dan detail transaksi lab
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->join('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->join('medical_transaksi_detail as td', 'td.transaksi_id', '=', 't.id')
            ->where('reg.id', $registrasiId)
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'p.nama as master_patient_name',
                'p.pid as master_patient_code',
                'td.status_pemeriksaan'
            )
            ->first();

        return view('application.laboratorium.dokumentasi-hasil.form-dokumentasi-hasil', [
            'data' => $data,
            'code' => $data->no_registrasi ?? $registrasiId
        ]);
    }
    public function dokumentasi_hasil_laboratorium_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', '>', 2)
                ->get();
            return view('application.laboratorium.dokumentasi-hasil-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function dokumentasi_hasil_laboratorium_detail_old(Request $request)
    {
        $data = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->first();
        return view('application.laboratorium.dokumentasi-hasil.form-dokumentasi-hasil', ['data' => $data, 'code' => $request->code]);
    }
    public function dokumentasi_hasil_laboratorium_detail_kirim_hasil(Request $request)
    {
        $user = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
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
        $name = storage_path('app/public/hasil/lab/' . $request->code . '.pdf');

        $img = file_get_contents($name);
        // a route is created, (it must already be created in its repository(pdf)).
        // $rute    = "pdf/" . $name;
        $pass = date('dmY', strtotime($user->master_patient_tgl_lahir));
        // decode base64
        $pdf_b64 = base64_encode($img);
        $cek = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->first();
        // you record the file in existing folder
        if ($cek) {
            DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->update([
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Lab Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
            ]);
        } else {
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid() . mt_rand(1000, 9999),
                'd_reg_order_list_code' => $request->code,
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Lab Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
                'created_at' => now(),
            ]);
        }
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 4,
            'updated_at' => now(),
        ]);
        return $pdf_b64;
    }
    public function dokumentasi_hasil_laboratorium_detail_batal_kirim_hasil(Request $request)
    {
        return 123;
    }
    // PENGIRIMAN HASIL
    public function pengiriman_hasil_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')->join('v_log_whatsapp', 'v_log_whatsapp.d_reg_order_list_code', '=', 'd_reg_order_lab.d_reg_order_lab_code')->get();
            return view('application.laboratorium.pengiriman-hasil-lab', ['akses' => $akses, 'data' => $data, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function pengiriman_hasil_laboratorium_add(Request $request)
    {
        return view('application.laboratorium.pengiriman-hasil.form-add-whatsapp');
    }
    public function pengiriman_hasil_laboratorium_save(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.pengiriman-hasil.format-pdf', compact('image'))->setPaper('A5', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file; // Your Base64 encoded PDF string
        list($type, $data) = explode(';', $base64Pdf);
        list(, $data) = explode(',', $data);
        $pdfBinaryData = base64_decode($data);
        $tempPdfPath = storage_path('app/temp_pdf_' . str::uuid() . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);


        // $pdf = new Pdf($tempPdfPath);
        // $outputImagePath = storage_path('app/converted_image_' . str::uuid() . '.jpg');
        // $pdf->saveImage($outputImagePath);
        try {
            $pdf = new Pdf($tempPdfPath);
            $outputImagePath = storage_path('app/converted_image_' . str::uuid() . '.jpg');
            $pdf->saveImage($outputImagePath);
            $qrcode = base64_encode(file_get_contents($outputImagePath));
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid() . mt_rand(1000, 9999),
                'd_reg_order_list_code' => '123132213',
                'v_log_whatsapp_number' => '+6281933770710',
                'v_log_whatsapp_name' => 'Agus Raharjo',
                'v_log_whatsapp_text' => 'Halo',
                'v_log_whatsapp_file' => $file,
                'v_log_whatsapp_picture' => $qrcode,
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Handle any errors during conversion
            echo 'Error converting PDF: ' . $e->getMessage();
        } finally {
            // Clean up the temporary PDF file
            if (file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }
            if (file_exists($outputImagePath)) {
                unlink($outputImagePath);
            }
        }
        // $pdf = new Pdf($tempPdfPath);
        // $pdf->saveImage(storage_path('app/public/test.jpg'));

        // Now $outputImagePath contains the path to your converted JPG image
        // You can then serve this image or store its path in your database.



        // $qrcode = base64_encode(QrCode::format('png')
        //     ->size(500)
        //     // ->merge('/storage/app/public/logo.png')
        //     ->errorCorrection('H')
        //     ->eyeColor(2, 100, 100, 255, 0, 0, 0)
        //     ->style('round')
        //     ->margin(2)
        //     ->generate(str::uuid()));

        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Pengiriman Whatsapp');
    }
    public function pengiriman_hasil_laboratorium_template()
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        return $pdf->stream();
    }
    // PENGIRIMAN HASIL
    public function pendaftaran_lab_registrasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')->join('v_log_whatsapp', 'v_log_whatsapp.d_reg_order_list_code', '=', 'd_reg_order_lab.d_reg_order_lab_code')->get();
            return view('app-medical.laboratorium.pendaftara-lab', ['akses' => $akses, 'data' => $data, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // INTERFACE DATA RESULT
    public function interfave_lab_data_result($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Mengambil daftar alat untuk dropdown filter di frontend
            $alatList = DB::table('medical_master_alat')
                ->where('status', 'aktif')
                ->select('instrument_id', 'kode_alat', 'nama_alat')
                ->get();
            return view('app-medical.laboratorium.interface-lab-data-result', ['akses' => $akses, 'alatList' => $alatList, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function interfave_lab_data_result_get_data(Request $request)
    {
        // 1. Base Query dengan JOIN ke tabel medical_master_alat
        $query = DB::table('medical_interface_result as mir')
            ->leftJoin('medical_master_alat as mma', 'mir.instrument_id', '=', 'mma.instrument_id')
            ->select([
                'mir.id',
                'mir.nolab',
                'mir.tanggal',
                'mir.flag_qc',
                'mir.flag_query',
                'mir.instrument_id',
                'mma.kode_alat',
                'mma.nama_alat',
                'mma.lokasi_ruangan'
            ]);

        $totalData = DB::table('medical_interface_result')->count();

        // 2. Filter No. Lab
        if ($request->filled('nolab')) {
            $query->where('mir.nolab', 'like', '%' . trim($request->nolab) . '%');
        }

        // 3. Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('mir.tanggal', $request->tanggal);
        }

        // 4. Filter Berdasarkan Alat / Instrument ID
        if ($request->filled('instrument_id')) {
            $query->where('mir.instrument_id', $request->instrument_id);
        }

        // 5. Global Search DataTables
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('mir.nolab', 'like', "%{$searchValue}%")
                    ->orWhere('mma.kode_alat', 'like', "%{$searchValue}%")
                    ->orWhere('mma.nama_alat', 'like', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // 6. Pagination & Ordering
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $data = $query->orderBy('mir.tanggal', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        // 7. Format Data Response
        $formattedData = $data->map(function ($row) {
            return [
                'id' => $row->id,
                'nolab' => $row->nolab,
                'nama_instrument' => $row->nama_alat
                    ? "<strong>{$row->nama_alat}</strong> <br><small class='text-muted'>[{$row->kode_alat}] - {$row->lokasi_ruangan}</small>"
                    : "<span class='text-muted'>ID: " . ($row->instrument_id ?? '-') . "</span>",
                'tanggal' => $row->tanggal ? date('d-m-Y H:i:s', strtotime($row->tanggal)) : '-',
                'flag_qc' => $row->flag_qc === 'Y'
                    ? '<span class="badge bg-warning text-dark">QC</span>'
                    : '<span class="badge bg-secondary">N</span>',
                'flag_query' => $row->flag_query === 'Y'
                    ? '<span class="badge bg-danger">Query</span>'
                    : '<span class="badge bg-secondary">N</span>',
                'action' => '
                    <select class="form-select form-select-sm action-select" data-id="' . $row->id . '">
                        <option value="" selected disabled>-- Pilih Aksi --</option>
                        <option value="toggle-detail">👁️ Detail Hasil</option>
                        <option value="raw-payload">📜 Raw Payload</option>
                    </select>
                '
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $formattedData
        ]);
    }
    public function interfave_lab_data_result_show_data_detail($id)
    {
        $result = DB::table('medical_interface_result as mir')
            ->leftJoin('medical_master_alat as mma', 'mir.instrument_id', '=', 'mma.instrument_id')
            ->where('mir.id', $id)
            ->select('mir.*', 'mma.nama_alat', 'mma.kode_alat')
            ->first();

        if (!$result) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        // Decode JSON results ke Array
        $parsedResults = json_decode($result->results, true) ?? [];

        return response()->json([
            'status' => 'success',
            'info' => [
                'nolab' => $result->nolab,
                'nama_alat' => $result->nama_alat ?? 'Unknown Instrument',
                'kode_alat' => $result->kode_alat ?? '-',
                'tanggal' => $result->tanggal ? date('d-m-Y H:i:s', strtotime($result->tanggal)) : '-',
                'flag_qc' => $result->flag_qc,
                'flag_query' => $result->flag_query,
            ],
            'results' => $parsedResults
        ]);
    }
    public function interfave_lab_data_result_show_data_raw($id)
    {
        $result = DB::table('medical_interface_result')->where('id', $id)->first();

        if (!$result) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'nolab' => $result->nolab,
            'raw_payload' => $result->raw_payload ?? 'Tidak ada data raw payload.'
        ]);
    }
}
