<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetNitrogenServer;
use App\Models\Nitrogen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckSheetNitrogenServerController extends Controller
{
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

    public function showForm()
    {
        $latestCheckSheetNitrogens = CheckSheetNitrogenServer::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.nitrogen.checksheet.check', compact('latestCheckSheetNitrogens'));
    }

    public function processForm(Request $request)
    {
        $nitrogenNumber = $request->input('tabung_number');

        $nitrogen = Nitrogen::where('no_tabung', $nitrogenNumber)->first();

        if (!$nitrogen) {
            return back()->with('error', 'Nitrogen Number tidak ditemukan.');
        }

        return redirect()->route('checksheetnitrogen', compact('nitrogenNumber'));
    }

    public function createForm($nitrogenNumber)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetNitrogenServer::where('tabung_number', $nitrogenNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('nitrogen.checksheetnitrogen.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Nitrogen sudah ada untuk Nitrogen ' . $nitrogenNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetNitrogens = CheckSheetNitrogenServer::all();
            return view('dashboard.nitrogen.checksheet.checkNitrogen', compact('checkSheetNitrogens', 'nitrogenNumber'));
        }
    }
}
