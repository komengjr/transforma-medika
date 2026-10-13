<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data input dari form
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Simpan ke database
        Consultation::create($validated);

        // Redirect kembali dengan pesan sukses
        return redirect()->to('/#contact')->with('success', 'Pesan konsultasi berhasil dikirim!');
    }
}
