<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckSheetCo2;

class CheckSheetCo2Controller extends Controller
{
    public function showForm($tagNumber)
    {
        $checkSheetCo2s = CheckSheetCo2::all();
        return view('dashboard.checkSheet.checkCo2', compact('checkSheetCo2s', 'tagNumber'));
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

        return redirect()->route('show.form')->with('success', 'Data berhasil disimpan.');
    }
}
