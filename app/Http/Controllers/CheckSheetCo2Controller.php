<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckSheetCo2;

class CheckSheetCo2Controller extends Controller
{
    public function index()
    {
        $checkSheetCo2s = CheckSheetCo2::all();
        return view('dashboard.checkCo2', compact('checkSheetCo2s'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal_pengecekan' => 'required|date',
            'npk' => 'required',
            'apar_number' => 'required',
            'pressure' => 'required',
            'hose' => 'required',
            'corong' => 'required',
            'tabung' => 'required',
            'regulator' => 'required',
            'lock_pin' => 'required',
            'berat_tabung' => 'required',
            // tambahkan validasi untuk atribut lainnya
        ]);

        // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
        $validatedData['npk'] = auth()->user()->npk;

        // Simpan data ke database menggunakan metode create
        CheckSheetCo2::create($validatedData);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }
}
