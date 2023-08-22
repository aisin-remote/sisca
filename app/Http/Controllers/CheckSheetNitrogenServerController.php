<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetNitrogenServer;
use Illuminate\Http\Request;

class CheckSheetNitrogenServerController extends Controller
{
    public function showForm($tagNumber)
    {
        $checkSheetNitrogenServer = CheckSheetNitrogenServer::all();
        return view('dashboard.checkSheet.checkNitrogenServer', compact('checkSheetNitrogenServer', 'tagNumber'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal_pengecekan' => 'required|date',
            'npk' => 'required|string',
            'tabung_number' => 'required|string',
            'operasional' => 'required|string',
            'selector_mode' => 'required|string',
            'pintu_tabung' => 'required|string',
            'pressure_pilot' => 'required|string',
            'pressure_no1' => 'required|string',
            'pressure_no2' => 'required|string',
            'pressure_no3' => 'required|string',
            'pressure_no4' => 'required|string',
            'pressure_no5' => 'required|string',
        ]);

        // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
        $validatedData['npk'] = auth()->user()->npk;

        // Simpan data ke database menggunakan metode create
        CheckSheetNitrogenServer::create($validatedData);

        return redirect()->route('checksheet.nitrogen.server')->with('success', 'Data berhasil disimpan.');
    }
}
