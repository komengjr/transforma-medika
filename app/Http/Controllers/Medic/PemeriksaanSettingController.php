<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PemeriksaanSettingController extends Controller
{
    public function index()
    {
        return view('pemeriksaan.setting');
    }

    // Datatable Master Pemeriksaan List
    public function getDatatable(Request $request)
    {
        $query = DB::table('t_pemeriksaan_list');

        if ($searchValue = $request->input('search.value')) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('t_pemeriksaan_list_code', 'like', "%{$searchValue}%")
                    ->orWhere('t_pemeriksaan_list_name', 'like', "%{$searchValue}%");
            });
        }

        $totalData = DB::table('t_pemeriksaan_list')->count();
        $totalFiltered = $query->count();

        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);

        $data = $query->offset($start)->limit($length)->get();

        $formattedData = [];
        $no = $start + 1;

        foreach ($data as $item) {
            // Hitung berapa parameter yang sudah diset
            $paramCount = DB::table('t_pemeriksaan_list_val')
                ->where('t_pemeriksaan_list_code', $item->t_pemeriksaan_list_code)
                ->count();

            $formattedData[] = [
                'no' => '<span class="fw-semibold text-muted" style="font-size:0.75rem;">' . $no++ . '</span>',
                'code' => '<span class="badge bg-light text-primary border border-primary-subtle fw-bold">' . e($item->t_pemeriksaan_list_code) . '</span>',
                'name' => '<div class="fw-bold text-dark" style="font-size:0.8rem;">' . e($item->t_pemeriksaan_list_name) . '</div>',
                'type' => '<span class="badge bg-info-subtle text-info border border-info-subtle style="font-size:0.68rem;">' . e($item->t_pemeriksaan_list_type) . '</span>',
                'total_param' => '<span class="badge bg-secondary-subtle text-secondary rounded-pill px-2">' . $paramCount . ' Parameter</span>',
                'action' => '<button class="btn btn-xs btn-primary shadow-sm rounded-2 px-2 py-1 btn-setting-param" data-code="' . e($item->t_pemeriksaan_list_code) . '" data-name="' . e($item->t_pemeriksaan_list_name) . '">
                                <i class="fas fa-cog me-1"></i> Setting Parameter
                            </button>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }

    // Get Data Parameter Berdasarkan Kode Pemeriksaan
    public function getParameters(Request $request)
    {
        $params = DB::table('t_pemeriksaan_list_val')
            ->where('t_pemeriksaan_list_code', $request->code)
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $params
        ]);
    }

    // Simpan / Update Parameter Pemeriksaan
    public function storeParameters(Request $request)
    {
        $pemeriksaanCode = $request->t_pemeriksaan_list_code;
        $items = $request->items;

        DB::beginTransaction();
        try {
            // 1. Hapus parameter lama untuk pemeriksaan ini
            DB::table('t_pemeriksaan_list_val')
                ->where('t_pemeriksaan_list_code', $pemeriksaanCode)
                ->delete();

            // 2. Insert Parameter Baru
            if (!empty($items) && is_array($items)) {
                $insertData = [];

                foreach ($items as $item) {
                    // Generasi kode Unik menggunakan Kombinasi Waktu + Random String (Atau Str::uuid())
                    $parentCode = 'VAL-' . date('YmdHis') . '-' . Str::upper(Str::random(4));

                    // Simpan Data Induk (Parent)
                    $insertData[] = [
                        't_pem_list_val_code'     => $parentCode,
                        't_pemeriksaan_list_code' => $pemeriksaanCode,
                        't_pem_list_val_name'     => $item['name'] ?? '',
                        't_pem_list_val_nilai'    => $item['nilai'] ?? '',
                        't_pem_list_val_rujukan'  => $item['rujukan'] ?? '',
                        't_pem_list_val_satuan'   => $item['satuan'] ?? '',
                        't_pem_list_val_instrumen' => $item['instrumen'] ?? '',
                        't_pem_list_val_param'    => $item['param'] ?? '',
                        't_pem_list_val_metode'   => $item['metode'] ?? '',
                        't_pem_list_val_kali'     => $item['kali'] ?? '1',
                        't_pem_list_val_opt'      => $item['opt'] ?? 'N',
                        't_pem_list_val_opt_code' => null,
                        'created_at'              => now(),
                        'updated_at'              => now(),
                    ];

                    // Simpan Data Sub-Anakan (Child)
                    if (($item['opt'] ?? 'N') === 'Y' && isset($item['children']) && is_array($item['children'])) {
                        foreach ($item['children'] as $child) {
                            $childCode = 'VAL-' . date('YmdHis') . '-' . Str::upper(Str::random(4));

                            $insertData[] = [
                                't_pem_list_val_code'     => $childCode,
                                't_pemeriksaan_list_code' => $pemeriksaanCode,
                                't_pem_list_val_name'     => $child['name'] ?? '',
                                't_pem_list_val_nilai'    => $child['nilai'] ?? '',
                                't_pem_list_val_rujukan'  => $child['rujukan'] ?? '',
                                't_pem_list_val_satuan'   => $child['satuan'] ?? '',
                                't_pem_list_val_instrumen' => $child['instrumen'] ?? '',
                                't_pem_list_val_param'    => $child['param'] ?? '',
                                't_pem_list_val_metode'   => $child['metode'] ?? '',
                                't_pem_list_val_kali'     => $child['kali'] ?? '1',
                                't_pem_list_val_opt'      => 'N',
                                't_pem_list_val_opt_code' => $parentCode, // Tetap merujuk ke parentCode
                                'created_at'              => now(),
                                'updated_at'              => now(),
                            ];
                        }
                    }
                }

                DB::table('t_pemeriksaan_list_val')->insert($insertData);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Parameter pemeriksaan berhasil disimpan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
