<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHydrantIndoor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckSheetHydrantIndoorController extends Controller
{

    public function showForm($hydrantNumber)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetHydrantIndoor::where('hydrant_number', $hydrantNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('hydrant.checksheetindoor.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Indoor sudah ada untuk Hydrant ' . $hydrantNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetIndoors = CheckSheetHydrantIndoor::all();
            return view('dashboard.hydrant.checkSheet.checkIndoor', compact('checkSheetIndoors', 'hydrantNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetHydrantIndoor::where('hydrant_number', $request->hydrant_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'hydrant_number' => 'required',
                'pintu' => 'required',
                'photo_pintu' => 'required|image|file|max:3072',
                'emergency' => 'required',
                'photo_emergency' => 'required|image|file|max:3072',
                'nozzle' => 'required',
                'photo_nozzle' => 'required|image|file|max:3072',
                'selang' => 'required',
                'photo_selang' => 'required|image|file|max:3072',
                'valve' => 'required',
                'photo_valve' => 'required|image|file|max:3072',
                'coupling' => 'required',
                'photo_coupling' => 'required|image|file|max:3072',
                'pressure' => 'required',
                'photo_pressure' => 'required|image|file|max:3072',
                'kupla' => 'required',
                'photo_kupla' => 'required|image|file|max:3072',
                'description' => 'nullable|string|max:255',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_pintu') && $request->file('photo_emergency') && $request->file('photo_nozzle') && $request->file('photo_selang') && $request->file('photo_valve') && $request->file('photo_coupling') && $request->file('photo_pressure') && $request->file('photo_kupla')) {
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-hydrant-indoor');
                $validatedData['photo_emergency'] = $request->file('photo_emergency')->store('checksheet-hydrant-indoor');
                $validatedData['photo_nozzle'] = $request->file('photo_nozzle')->store('checksheet-hydrant-indoor');
                $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-hydrant-indoor');
                $validatedData['photo_valve'] = $request->file('photo_valve')->store('checksheet-hydrant-indoor');
                $validatedData['photo_coupling'] = $request->file('photo_coupling')->store('checksheet-hydrant-indoor');
                $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-hydrant-indoor');
                $validatedData['photo_kupla'] = $request->file('photo_kupla')->store('checksheet-hydrant-indoor');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'hydrant_number' => 'required',
                'pintu' => 'required',
                'photo_pintu' => 'required|image|file|max:3072',
                'emergency' => 'required',
                'photo_emergency' => 'required|image|file|max:3072',
                'nozzle' => 'required',
                'photo_nozzle' => 'required|image|file|max:3072',
                'selang' => 'required',
                'photo_selang' => 'required|image|file|max:3072',
                'valve' => 'required',
                'photo_valve' => 'required|image|file|max:3072',
                'coupling' => 'required',
                'photo_coupling' => 'required|image|file|max:3072',
                'pressure' => 'required',
                'photo_pressure' => 'required|image|file|max:3072',
                'kupla' => 'required',
                'photo_kupla' => 'required|image|file|max:3072',
                'description' => 'nullable|string|max:255',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_pintu') && $request->file('photo_emergency') && $request->file('photo_nozzle') && $request->file('photo_selang') && $request->file('photo_valve') && $request->file('photo_coupling') && $request->file('photo_pressure') && $request->file('photo_kupla')) {
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-hydrant-indoor');
                $validatedData['photo_emergency'] = $request->file('photo_emergency')->store('checksheet-hydrant-indoor');
                $validatedData['photo_nozzle'] = $request->file('photo_nozzle')->store('checksheet-hydrant-indoor');
                $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-hydrant-indoor');
                $validatedData['photo_valve'] = $request->file('photo_valve')->store('checksheet-hydrant-indoor');
                $validatedData['photo_coupling'] = $request->file('photo_coupling')->store('checksheet-hydrant-indoor');
                $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-hydrant-indoor');
                $validatedData['photo_kupla'] = $request->file('photo_kupla')->store('checksheet-hydrant-indoor');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetHydrantIndoor::create($validatedData);

            return redirect()->route('hydrant.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }
}
