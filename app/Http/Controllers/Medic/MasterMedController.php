<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use App\Imports\ItemsImport;
use App\Imports\ProductImport;
use App\Models\InterfaceAlatArchitectCi4100;
use App\Models\InterfaceAlatXn500;
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
use Yajra\DataTables\Facades\DataTables;

class MasterMedController extends Controller
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
    public function master_data_patient($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('master_patient')->orderBy('id_master_patient', 'DESC')->get();
            return view('app-medical.master-data-patient', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_member_patient($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('master_patient')->orderBy('id_master_patient', 'DESC')->get();
            return view('app-medical.master-member-patient', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER INTERFACE
    public function master_medical_interface_architec($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('master_patient')->orderBy('id_master_patient', 'DESC')->get();
            return view('app-medical.interface.master-interface-architec', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    public function master_medical_interface_architec_get_data(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $searchValue = $request->input('search.value');

        // Total data tanpa filter
        $totalRecords = InterfaceAlatArchitectCi4100::count();

        // Query Dasar
        $query = InterfaceAlatArchitectCi4100::query();

        // Filtering / Searching
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('nolab', 'like', "%{$searchValue}%")
                    ->orWhere('instrument_id', 'like', "%{$searchValue}%")
                    ->orWhere('flag_qc', 'like', "%{$searchValue}%")
                    ->orWhere('flag_query', 'like', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // Sorting / Ordering
        $columns = ['id', 'nolab', 'tanggal', 'instrument_id', 'flag_qc', 'flag_query'];
        $orderColumnIndex = $request->input('order.0.column', 2); // Default order kolom tanggal
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'tanggal';

        // Fetching Data dengan Pagination
        $data = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Format Data untuk Response JSON DataTables
        $formattedData = [];
        foreach ($data as $index => $row) {
            $resultsStr = htmlspecialchars(json_encode($row->results ?? []), ENT_QUOTES, 'UTF-8');
            $rawStr = htmlspecialchars(json_encode($row->raw_payload ?? []), ENT_QUOTES, 'UTF-8');

            $formattedData[] = [
                'DT_RowIndex'   => $start + $index + 1,
                'nolab'         => $row->nolab,
                'tanggal'       => $row->tanggal ? date('Y-m-d H:i:s', strtotime($row->tanggal)) : '-',
                'instrument_id' => $row->instrument_id,
                'flag_qc'       => $row->flag_qc,
                'flag_query'    => $row->flag_query,
                'action'        => '<button class="btn btn-xs btn-outline-info" onclick="showDetail(\'' . $row->nolab . '\', ' . $resultsStr . ', ' . $rawStr . ')"><i class="bi bi-eye"></i> Detail</button>',
            ];
        }

        // Return format standar DataTables
        return response()->json([
            'draw'            => intval($draw),
            'recordsTotal'    => intval($totalRecords),
            'recordsFiltered' => intval($totalFiltered),
            'data'            => $formattedData,
        ]);
    }
    // MASTER INTERFACE XN 500
    public function master_medical_interface_xn_500($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('master_patient')->orderBy('id_master_patient', 'DESC')->get();
            return view('app-medical.interface.master-interface-xn-500', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_medical_interface_xn_500_get_data(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $searchValue = $request->input('search.value');

        // Total records
        $totalRecords = InterfaceAlatXn500::count();
        $query = InterfaceAlatXn500::query();

        // Global Search
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('nolab', 'like', "%{$searchValue}%")
                    ->orWhere('instrument_id', 'like', "%{$searchValue}%")
                    ->orWhere('flag_qc', 'like', "%{$searchValue}%")
                    ->orWhere('flag_query', 'like', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // Sorting
        $columns = ['id', 'nolab', 'tanggal', 'instrument_id', 'flag_qc', 'flag_query'];
        $orderColumnIndex = $request->input('order.0.column', 2);
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'tanggal';

        $data = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        $formattedData = [];
        foreach ($data as $index => $row) {
            $resultsStr = htmlspecialchars(json_encode($row->results ?? []), ENT_QUOTES, 'UTF-8');
            $rawStr = htmlspecialchars(json_encode($row->raw_payload ?? []), ENT_QUOTES, 'UTF-8');

            $formattedData[] = [
                'DT_RowIndex'   => $start + $index + 1,
                'nolab'         => $row->nolab,
                'tanggal'       => $row->tanggal ? $row->tanggal->format('Y-m-d H:i:s') : '-',
                'instrument_id' => $row->instrument_id ?? 500,
                'flag_qc'       => $row->flag_qc,
                'flag_query'    => $row->flag_query,
                'action'        => '<button class="btn btn-xs btn-outline-primary" onclick="showDetail(\'' . $row->nolab . '\', ' . $resultsStr . ', ' . $rawStr . ')"><i class="bi bi-eye"></i> Detail</button>',
            ];
        }

        return response()->json([
            'draw'            => intval($draw),
            'recordsTotal'    => intval($totalRecords),
            'recordsFiltered' => intval($totalFiltered),
            'data'            => $formattedData,
        ]);
    }
    // MASTER UPDATE TAT
    public function master_medical_update_tat($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-medical.update-tat.update', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
}
