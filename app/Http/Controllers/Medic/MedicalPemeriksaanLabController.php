<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use App\Models\medical\MedicalPemeriksaanLab;
use Illuminate\Http\Request;

class MedicalPemeriksaanLabController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data'   => MedicalPemeriksaanLab::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pemeriksaan'     => 'required|unique:medical_pemeriksaan_labs,kode_pemeriksaan',
            'nama_pemeriksaan'     => 'required|string',
            'kategori'             => 'required|string',
            'harga'                => 'required|numeric',
            'satuan'               => 'nullable|string',
            'nilai_rujukan_pria'   => 'nullable|string',
            'nilai_rujukan_wanita' => 'nullable|string',
        ]);

        $item = MedicalPemeriksaanLab::create($validated);

        return response()->json(['status' => 'success', 'data' => $item], 201);
    }
}
