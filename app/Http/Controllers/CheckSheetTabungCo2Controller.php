<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetTabungCo2;
use App\Models\Co2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckSheetTabungCo2Controller extends Controller
{
    public function showForm()
    {
        $latestCheckSheetTabungCo2s = CheckSheetTabungCo2::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.co2.checksheet.check', compact('latestCheckSheetTabungCo2s'));
    }

    public function processForm(Request $request)
    {
        $co2Number = $request->input('tabung_number');

        $co2 = Co2::where('no_tabung', $co2Number)->first();

        if (!$co2) {
            return back()->with('error', 'Co2 Number tidak ditemukan.');
        }

        return redirect()->route('checksheettabungco2', compact('co2Number'));
    }

    public function createForm($tabungNumber)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTabungCo2::where('tabung_number', $tabungNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('co2.checksheetco2.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Co2 sudah ada untuk Co2 ' . $tabungNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetTabungCo2s = CheckSheetTabungCo2::all();
            return view('dashboard.co2.checksheet.checkCo2', compact('checkSheetTabungCo2s', 'tabungNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTabungCo2::where('tabung_number', $request->tabung_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tabung_number' => 'required',
                'cover' => 'required',
                'catatan_cover' => 'nullable|string|max:255',
                'photo_cover' => 'required|image|file|max:3072',
                'tabung' => 'required',
                'catatan_tabung' => 'nullable|string|max:255',
                'photo_tabung' => 'required|image|file|max:3072',
                'lock_pin' => 'required',
                'catatan_lock_pin' => 'nullable|string|max:255',
                'photo_lock_pin' => 'required|image|file|max:3072',
                'segel_lock_pin' => 'required',
                'catatan_segel_lock_pin' => 'nullable|string|max:255',
                'photo_segel_lock_pin' => 'required|image|file|max:3072',
                'kebocoran_regulator_tabung' => 'required',
                'catatan_kebocoran_regulator_tabung' => 'nullable|string|max:255',
                'photo_kebocoran_regulator_tabung' => 'required|image|file|max:3072',
                'selang' => 'required',
                'catatan_selang' => 'nullable|string|max:255',
                'photo_selang' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_cover') && $request->file('photo_tabung') && $request->file('photo_lock_pin') && $request->file('photo_segel_lock_pin') && $request->file('photo_kebocoran_regulator_tabung') && $request->file('photo_selang')) {
                $validatedData['photo_cover'] = $request->file('photo_cover')->store('checksheet-tabung-co2');
                $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-tabung-co2');
                $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-tabung-co2');
                $validatedData['photo_segel_lock_pin'] = $request->file('photo_segel_lock_pin')->store('checksheet-tabung-co2');
                $validatedData['photo_kebocoran_regulator_tabung'] = $request->file('photo_kebocoran_regulator_tabung')->store('checksheet-tabung-co2');
                $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-tabung-co2');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('co2.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tabung_number' => 'required',
                'cover' => 'required',
                'catatan_cover' => 'nullable|string|max:255',
                'photo_cover' => 'required|image|file|max:3072',
                'tabung' => 'required',
                'catatan_tabung' => 'nullable|string|max:255',
                'photo_tabung' => 'required|image|file|max:3072',
                'lock_pin' => 'required',
                'catatan_lock_pin' => 'nullable|string|max:255',
                'photo_lock_pin' => 'required|image|file|max:3072',
                'segel_lock_pin' => 'required',
                'catatan_segel_lock_pin' => 'nullable|string|max:255',
                'photo_segel_lock_pin' => 'required|image|file|max:3072',
                'kebocoran_regulator_tabung' => 'required',
                'catatan_kebocoran_regulator_tabung' => 'nullable|string|max:255',
                'photo_kebocoran_regulator_tabung' => 'required|image|file|max:3072',
                'selang' => 'required',
                'catatan_selang' => 'nullable|string|max:255',
                'photo_selang' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_cover') && $request->file('photo_tabung') && $request->file('photo_lock_pin') && $request->file('photo_segel_lock_pin') && $request->file('photo_kebocoran_regulator_tabung') && $request->file('photo_selang')) {
                $validatedData['photo_cover'] = $request->file('photo_cover')->store('checksheet-tabung-co2');
                $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-tabung-co2');
                $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-tabung-co2');
                $validatedData['photo_segel_lock_pin'] = $request->file('photo_segel_lock_pin')->store('checksheet-tabung-co2');
                $validatedData['photo_kebocoran_regulator_tabung'] = $request->file('photo_kebocoran_regulator_tabung')->store('checksheet-tabung-co2');
                $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-tabung-co2');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetTabungCo2::create($validatedData);

            return redirect()->route('co2.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetTabungCo2::findOrFail($id);

        return view('dashboard.co2.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheettabungco2 = CheckSheetTabungCo2::findOrFail($id);
        return view('dashboard.co2.checksheet.edit', compact('checkSheettabungco2'));
    }

    public function update(Request $request, $id)
    {
        $checkSheettabungco2 = CheckSheetTabungCo2::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'cover' => 'required',
            'catatan_cover' => 'nullable|string|max:255',
            'photo_cover' => 'image|file|max:3072',
            'tabung' => 'required',
            'catatan_tabung' => 'nullable|string|max:255',
            'photo_tabung' => 'image|file|max:3072',
            'lock_pin' => 'required',
            'catatan_lock_pin' => 'nullable|string|max:255',
            'photo_lock_pin' => 'image|file|max:3072',
            'segel_lock_pin' => 'required',
            'catatan_segel_lock_pin' => 'nullable|string|max:255',
            'photo_segel_lock_pin' => 'image|file|max:3072',
            'kebocoran_regulator_tabung' => 'required',
            'catatan_kebocoran_regulator_tabung' => 'nullable|string|max:255',
            'photo_kebocoran_regulator_tabung' => 'image|file|max:3072',
            'selang' => 'required',
            'catatan_selang' => 'nullable|string|max:255',
            'photo_selang' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_cover')) {
            if ($request->oldImage_cover) {
                Storage::delete($request->oldImage_cover);
            }
            $validatedData['photo_cover'] = $request->file('photo_cover')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_tabung')) {
            if ($request->oldImage_tabung) {
                Storage::delete($request->oldImage_tabung);
            }
            $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_lock_pin')) {
            if ($request->oldImage_lock_pin) {
                Storage::delete($request->oldImage_lock_pin);
            }
            $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_segel_lock_pin')) {
            if ($request->oldImage_segel_lock_pin) {
                Storage::delete($request->oldImage_segel_lock_pin);
            }
            $validatedData['photo_segel_lock_pin'] = $request->file('photo_segel_lock_pin')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_kebocoran_regulator_tabung')) {
            if ($request->oldImage_kebocoran_regulator_tabung) {
                Storage::delete($request->oldImage_kebocoran_regulator_tabung);
            }
            $validatedData['photo_kebocoran_regulator_tabung'] = $request->file('photo_kebocoran_regulator_tabung')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_selang')) {
            if ($request->oldImage_selang) {
                Storage::delete($request->oldImage_selang);
            }
            $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-tabung-co2');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheettabungco2->update($validatedData);

        $co2 = Co2::where('no_tabung', $checkSheettabungco2->tabung_number)->first();

        if (!$co2) {
            return back()->with('error', 'Co2 tidak ditemukan.');
        }

        return redirect()->route('co2.show', $co2->id)->with('success1', 'Data Check Sheet Co2 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheettabungco2 = CheckSheetTabungCo2::find($id);

        if ($checkSheettabungco2->photo_cover || $checkSheettabungco2->photo_tabung || $checkSheettabungco2->photo_lock_pin || $checkSheettabungco2->photo_segel_lock_pin || $checkSheettabungco2->photo_kebocoran_regulator_tabung || $checkSheettabungco2->photo_selang) {
            Storage::delete($checkSheettabungco2->photo_cover);
            Storage::delete($checkSheettabungco2->photo_tabung);
            Storage::delete($checkSheettabungco2->photo_lock_pin);
            Storage::delete($checkSheettabungco2->photo_segel_lock_pin);
            Storage::delete($checkSheettabungco2->photo_kebocoran_regulator_tabung);
            Storage::delete($checkSheettabungco2->photo_selang);
        }

        $checkSheettabungco2->delete();

        return back()->with('success1', 'Data Check Sheet Co2 berhasil dihapus');
    }
}
