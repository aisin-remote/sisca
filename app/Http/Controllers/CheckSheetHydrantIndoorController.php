<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHydrantIndoor;
use Illuminate\Http\Request;

class CheckSheetHydrantIndoorController extends Controller
{
    public function showForm($tagNumber)
    {
        $checkSheetHydrantIndoor = CheckSheetHydrantIndoor::all();
        return view('dashboard.checkSheet.checkHydraCheckSheetHydrantIndoor', compact('checkSheetHydrantIndoor', 'tagNumber'));
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal_pengecekan' => 'required|date',
            'npk' => 'required|string',
            'hydrant_number' => 'required|string',
            'pintu' => 'required|string',
            'emergency' => 'required|string',
            'nozzle' => 'required|string',
            'selang' => 'required|string',
            'valve' => 'required|string',
            'coupling' => 'required|string',
            'pressure' => 'required|string',
            'kupla' => 'required|string',
        ]);

        // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
        $validatedData['npk'] = auth()->user()->npk;

        // Simpan data ke database menggunakan metode create
        CheckSheetHydrantIndoor::create($validatedData);

        return redirect()->route('checksheet.hydrantindoor')->with('success', 'Data berhasil disimpan.');
    }
}
