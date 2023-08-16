<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckSheetPowder;

class CheckSheetPowderController extends Controller
{
    public function showForm($tagNumber)
    {
        $checkSheetPowders = CheckSheetPowder::all();
        return view('dashboard.checkSheet.checkPowder', compact('checkSheetPowders', 'tagNumber'));
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
            'tabung' => 'required',
            'regulator' => 'required',
            'lock_pin' => 'required',
            'powder' => 'required',
            // tambahkan validasi untuk atribut lainnya
        ]);

        // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
        $validatedData['npk'] = auth()->user()->npk;

        // Simpan data ke database menggunakan metode create
        CheckSheetPowder::create($validatedData);

        return redirect()->route('show.form')->with('success', 'Data berhasil disimpan.');
    }
}
