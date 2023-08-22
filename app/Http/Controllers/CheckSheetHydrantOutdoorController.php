<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckSheetHydrantOutdoor;

class CheckSheetHydrantOutdoorController extends Controller
{
    public function showForm($tagNumber)
    {
        $checkSheetHydrantOutdoor = CheckSheetHydrantOutdoor::all();
        return view('dashboard.checkSheet.checkHydrantOutdoor', compact('checkSheetHydrantOutdoor', 'tagNumber'));
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal_pengecekan' => 'required|date',
            'npk' => 'required|string',
            'hydrant_number' => 'required|string',
            'pintu' => 'required|string',
            'nozzle' => 'required|string',
            'selang' => 'required|string',
            'tuas' => 'required|string',
            'pilar' => 'required|string',
            'penutup' => 'required|string',
            'rantai' => 'required|string',
            'kupla' => 'required|string',
        ]);

        // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
        $validatedData['npk'] = auth()->user()->npk;

        // Simpan data ke database menggunakan metode create
        CheckSheetHydrantOutdoor::create($validatedData);

        return redirect()->route('checksheet.hydrantoutdoor')->with('success', 'Data berhasil disimpan.');
    }
}
