<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHydrantIndoor;
use App\Models\Hydrant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                'catatan_pintu' => 'nullable|string|max:255',
                'photo_pintu' => 'required|image|file|max:3072',
                'lampu' => 'required',
                'catatan_lampu' => 'nullable|string|max:255',
                'photo_lampu' => 'required|image|file|max:3072',
                'emergency' => 'required',
                'catatan_emergency' => 'nullable|string|max:255',
                'photo_emergency' => 'required|image|file|max:3072',
                'nozzle' => 'required',
                'catatan_nozzle' => 'nullable|string|max:255',
                'photo_nozzle' => 'required|image|file|max:3072',
                'selang' => 'required',
                'catatan_selang' => 'nullable|string|max:255',
                'photo_selang' => 'required|image|file|max:3072',
                'valve' => 'required',
                'catatan_valve' => 'nullable|string|max:255',
                'photo_valve' => 'required|image|file|max:3072',
                'coupling' => 'required',
                'catatan_coupling' => 'nullable|string|max:255',
                'photo_coupling' => 'required|image|file|max:3072',
                'pressure' => 'required',
                'catatan_pressure' => 'nullable|string|max:255',
                'photo_pressure' => 'required|image|file|max:3072',
                'kupla' => 'required',
                'catatan_kupla' => 'nullable|string|max:255',
                'photo_kupla' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_pintu') && $request->file('photo_lampu') && $request->file('photo_emergency') && $request->file('photo_nozzle') && $request->file('photo_selang') && $request->file('photo_valve') && $request->file('photo_coupling') && $request->file('photo_pressure') && $request->file('photo_kupla')) {
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-hydrant-indoor');
                $validatedData['photo_lampu'] = $request->file('photo_lampu')->store('checksheet-hydrant-indoor');
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

            return redirect()->route('hydrant.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'hydrant_number' => 'required',
                'pintu' => 'required',
                'catatan_pintu' => 'nullable|string|max:255',
                'photo_pintu' => 'required|image|file|max:3072',
                'lampu' => 'required',
                'catatan_lampu' => 'nullable|string|max:255',
                'photo_lampu' => 'required|image|file|max:3072',
                'emergency' => 'required',
                'catatan_emergency' => 'nullable|string|max:255',
                'photo_emergency' => 'required|image|file|max:3072',
                'nozzle' => 'required',
                'catatan_nozzle' => 'nullable|string|max:255',
                'photo_nozzle' => 'required|image|file|max:3072',
                'selang' => 'required',
                'catatan_selang' => 'nullable|string|max:255',
                'photo_selang' => 'required|image|file|max:3072',
                'valve' => 'required',
                'catatan_valve' => 'nullable|string|max:255',
                'photo_valve' => 'required|image|file|max:3072',
                'coupling' => 'required',
                'catatan_coupling' => 'nullable|string|max:255',
                'photo_coupling' => 'required|image|file|max:3072',
                'pressure' => 'required',
                'catatan_pressure' => 'nullable|string|max:255',
                'photo_pressure' => 'required|image|file|max:3072',
                'kupla' => 'required',
                'catatan_kupla' => 'nullable|string|max:255',
                'photo_kupla' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_pintu') && $request->file('photo_lampu') && $request->file('photo_emergency') && $request->file('photo_nozzle') && $request->file('photo_selang') && $request->file('photo_valve') && $request->file('photo_coupling') && $request->file('photo_pressure') && $request->file('photo_kupla')) {
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-hydrant-indoor');
                $validatedData['photo_lampu'] = $request->file('photo_lampu')->store('checksheet-hydrant-indoor');
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

    public function edit($id)
    {
        $checkSheetindoor = CheckSheetHydrantIndoor::findOrFail($id);
        return view('dashboard.hydrant.checksheetindoor.edit', compact('checkSheetindoor'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetindoor = CheckSheetHydrantIndoor::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'pintu' => 'required',
            'catatan_pintu' => 'nullable|string|max:255',
            'photo_pintu' => 'image|file|max:3072',
            'lampu' => 'required',
            'catatan_lampu' => 'nullable|string|max:255',
            'photo_lampu' => 'image|file|max:3072',
            'emergency' => 'required',
            'catatan_emergency' => 'nullable|string|max:255',
            'photo_emergency' => 'image|file|max:3072',
            'nozzle' => 'required',
            'catatan_nozzle' => 'nullable|string|max:255',
            'photo_nozzle' => 'image|file|max:3072',
            'selang' => 'required',
            'catatan_selang' => 'nullable|string|max:255',
            'photo_selang' => 'image|file|max:3072',
            'valve' => 'required',
            'catatan_valve' => 'nullable|string|max:255',
            'photo_valve' => 'image|file|max:3072',
            'coupling' => 'required',
            'catatan_coupling' => 'nullable|string|max:255',
            'photo_coupling' => 'image|file|max:3072',
            'pressure' => 'required',
            'catatan_pressure' => 'nullable|string|max:255',
            'photo_pressure' => 'image|file|max:3072',
            'kupla' => 'required',
            'catatan_kupla' => 'nullable|string|max:255',
            'photo_kupla' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_pintu')) {
            if ($request->oldImage_pintu) {
                Storage::delete($request->oldImage_pintu);
            }
            $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-hydrant-indoor');
        }

        if ($request->file('photo_lampu')) {
            if ($request->oldImage_lampu) {
                Storage::delete($request->oldImage_lampu);
            }
            $validatedData['photo_lampu'] = $request->file('photo_lampu')->store('checksheet-hydrant-indoor');
        }

        if ($request->file('photo_emergency')) {
            if ($request->oldImage_emergency) {
                Storage::delete($request->oldImage_emergency);
            }
            $validatedData['photo_emergency'] = $request->file('photo_emergency')->store('checksheet-hydrant-indoor');
        }

        if ($request->file('photo_nozzle')) {
            if ($request->oldImage_nozzle) {
                Storage::delete($request->oldImage_nozzle);
            }
            $validatedData['photo_nozzle'] = $request->file('photo_nozzle')->store('checksheet-hydrant-indoor');
        }

        if ($request->file('photo_selang')) {
            if ($request->oldImage_selang) {
                Storage::delete($request->oldImage_selang);
            }
            $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-hydrant-indoor');
        }

        if ($request->file('photo_valve')) {
            if ($request->oldImage_valve) {
                Storage::delete($request->oldImage_valve);
            }
            $validatedData['photo_valve'] = $request->file('photo_valve')->store('checksheet-hydrant-indoor');
        }

        if ($request->file('photo_coupling')) {
            if ($request->oldImage_coupling) {
                Storage::delete($request->oldImage_coupling);
            }
            $validatedData['photo_coupling'] = $request->file('photo_coupling')->store('checksheet-hydrant-indoor');
        }

        if ($request->file('photo_pressure')) {
            if ($request->oldImage_pressure) {
                Storage::delete($request->oldImage_pressure);
            }
            $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-hydrant-indoor');
        }

        if ($request->file('photo_kupla')) {
            if ($request->oldImage_kupla) {
                Storage::delete($request->oldImage_kupla);
            }
            $validatedData['photo_kupla'] = $request->file('photo_kupla')->store('checksheet-hydrant-indoor');
        }

        // Update data CheckSheetIndoor dengan data baru dari form
        $checkSheetindoor->update($validatedData);

        $hydrant = Hydrant::where('no_hydrant', $checkSheetindoor->hydrant_number)->first();

        if (!$hydrant) {
            return back()->with('error', 'Hydrant tidak ditemukan.');
        }

        return redirect()->route('hydrant.checksheetindoor.show', $hydrant->id)->with('success1', 'Data Check Sheet Hydrant Indoor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheetindoor = CheckSheetHydrantIndoor::find($id);

        if ($checkSheetindoor->photo_pintu || $checkSheetindoor->photo_lampu || $checkSheetindoor->photo_emergency || $checkSheetindoor->photo_nozzle || $checkSheetindoor->photo_selang || $checkSheetindoor->photo_valve || $checkSheetindoor->photo_coupling || $checkSheetindoor->photo_pressure || $checkSheetindoor->photo_kupla) {
            Storage::delete($checkSheetindoor->photo_pintu);
            Storage::delete($checkSheetindoor->photo_lampu);
            Storage::delete($checkSheetindoor->photo_emergency);
            Storage::delete($checkSheetindoor->photo_nozzle);
            Storage::delete($checkSheetindoor->photo_selang);
            Storage::delete($checkSheetindoor->photo_valve);
            Storage::delete($checkSheetindoor->photo_coupling);
            Storage::delete($checkSheetindoor->photo_pressure);
            Storage::delete($checkSheetindoor->photo_kupla);
        }

        $checkSheetindoor->delete();

        return back()->with('success1', 'Data Check Sheet Hydrant Indoor berhasil dihapus');
    }
}
