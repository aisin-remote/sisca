<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetEyewasher;
use App\Models\CheckSheetEyewasherShower;
use App\Models\Eyewasher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckSheetEyewasherOnlyController extends Controller
{
    public function showForm($eyewasherNumber)
    {
        $latestCheckSheetShowers = CheckSheetEyewasherShower::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetEyewasher = CheckSheetEyewasher::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetShowers->merge($latestCheckSheetEyewasher);

        // Mencari entri Co2 berdasarkan no_tabung
        $eyewasher = Eyewasher::where('no_eyewasher', $eyewasherNumber)->first();

        if (!$eyewasher) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('eyewasher.show.form', compact('combinedLatestCheckSheets'))->with('error', 'Eyewasher Number tidak ditemukan.');
        }

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetEyewasher::where('eyewasher_number', $eyewasherNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        $eyewasherNumber = strtoupper($eyewasherNumber);

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('eyewasher.checksheeteyewasher.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet sudah ada untuk Eyewasher ' . $eyewasherNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetEyewashers = CheckSheetEyewasher::all();
            return view('dashboard.eyewasher.checksheet.checkEyewasher', compact('checkSheetEyewashers', 'eyewasherNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetEyewasher::where('eyewasher_number', $request->eyewasher_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'eyewasher_number' => 'required',
                'pijakan' => 'required',
                'catatan_pijakan' => 'nullable|string|max:255',
                'photo_pijakan' => 'required|image|file|max:3072',
                'pipa_saluran_air' => 'required',
                'catatan_pipa_saluran_air' => 'nullable|string|max:255',
                'photo_pipa_saluran_air' => 'required|image|file|max:3072',
                'wastafel' => 'required',
                'catatan_wastafel' => 'nullable|string|max:255',
                'photo_wastafel' => 'required|image|file|max:3072',
                'kran_air' => 'required',
                'catatan_kran_air' => 'nullable|string|max:255',
                'photo_kran_air' => 'required|image|file|max:3072',
                'tuas' => 'required',
                'catatan_tuas' => 'nullable|string|max:255',
                'photo_tuas' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['eyewasher_number'] = strtoupper($validatedData['eyewasher_number']);

            if ($request->file('photo_pijakan') && $request->file('photo_pipa_saluran_air') && $request->file('photo_wastafel') && $request->file('photo_kran_air') && $request->file('photo_tuas')) {
                $validatedData['photo_pijakan'] = $request->file('photo_pijakan')->store('checksheet-eyewasher');
                $validatedData['photo_pipa_saluran_air'] = $request->file('photo_pipa_saluran_air')->store('checksheet-eyewasher');
                $validatedData['photo_wastafel'] = $request->file('photo_wastafel')->store('checksheet-eyewasher');
                $validatedData['photo_kran_air'] = $request->file('photo_kran_air')->store('checksheet-eyewasher');
                $validatedData['photo_tuas'] = $request->file('photo_tuas')->store('checksheet-eyewasher');


                // Perbarui data entri yang sudah ada
                $existingCheckSheet->update($validatedData);

                return redirect()->route('eyewasher.show.form')->with('success', 'Data berhasil diperbarui.');
            }
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'eyewasher_number' => 'required',
                'pijakan' => 'required',
                'catatan_pijakan' => 'nullable|string|max:255',
                'photo_pijakan' => 'required|image|file|max:3072',
                'pipa_saluran_air' => 'required',
                'catatan_pipa_saluran_air' => 'nullable|string|max:255',
                'photo_pipa_saluran_air' => 'required|image|file|max:3072',
                'wastafel' => 'required',
                'catatan_wastafel' => 'nullable|string|max:255',
                'photo_wastafel' => 'required|image|file|max:3072',
                'kran_air' => 'required',
                'catatan_kran_air' => 'nullable|string|max:255',
                'photo_kran_air' => 'required|image|file|max:3072',
                'tuas' => 'required',
                'catatan_tuas' => 'nullable|string|max:255',
                'photo_tuas' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['eyewasher_number'] = strtoupper($validatedData['eyewasher_number']);

            if ($request->file('photo_pijakan') && $request->file('photo_pipa_saluran_air') && $request->file('photo_wastafel') && $request->file('photo_kran_air') && $request->file('photo_tuas')) {
                $validatedData['photo_pijakan'] = $request->file('photo_pijakan')->store('checksheet-eyewasher');
                $validatedData['photo_pipa_saluran_air'] = $request->file('photo_pipa_saluran_air')->store('checksheet-eyewasher');
                $validatedData['photo_wastafel'] = $request->file('photo_wastafel')->store('checksheet-eyewasher');
                $validatedData['photo_kran_air'] = $request->file('photo_kran_air')->store('checksheet-eyewasher');
                $validatedData['photo_tuas'] = $request->file('photo_tuas')->store('checksheet-eyewasher');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetEyewasher::create($validatedData);

            return redirect()->route('eyewasher.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function edit($id)
    {
        $checkSheeteyewasher = CheckSheetEyewasher::findOrFail($id);
        return view('dashboard.eyewasher.checksheeteyewasher.edit', compact('checkSheeteyewasher'));
    }

    public function update(Request $request, $id)
    {
        $checkSheeteyewasher = CheckSheetEyewasher::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'pijakan' => 'required',
            'catatan_pijakan' => 'nullable|string|max:255',
            'photo_pijakan' => 'image|file|max:3072',
            'pipa_saluran_air' => 'required',
            'catatan_pipa_saluran_air' => 'nullable|string|max:255',
            'photo_pipa_saluran_air' => 'image|file|max:3072',
            'wastafel' => 'required',
            'catatan_wastafel' => 'nullable|string|max:255',
            'photo_wastafel' => 'image|file|max:3072',
            'kran_air' => 'required',
            'catatan_kran_air' => 'nullable|string|max:255',
            'photo_kran_air' => 'image|file|max:3072',
            'tuas' => 'required',
            'catatan_tuas' => 'nullable|string|max:255',
            'photo_tuas' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_pijakan')) {
            if ($request->oldImage_pijakan) {
                Storage::delete($request->oldImage_pijakan);
            }
            $validatedData['photo_pijakan'] = $request->file('photo_pijakan')->store('checksheet-eyewasher');
        }

        if ($request->file('photo_pipa_saluran_air')) {
            if ($request->oldImage_pipa_saluran_air) {
                Storage::delete($request->oldImage_pipa_saluran_air);
            }
            $validatedData['photo_pipa_saluran_air'] = $request->file('photo_pipa_saluran_air')->store('checksheet-eyewasher');
        }

        if ($request->file('photo_wastafel')) {
            if ($request->oldImage_wastafel) {
                Storage::delete($request->oldImage_wastafel);
            }
            $validatedData['photo_wastafel'] = $request->file('photo_wastafel')->store('checksheet-eyewasher');
        }

        if ($request->file('photo_kran_air')) {
            if ($request->oldImage_kran_air) {
                Storage::delete($request->oldImage_kran_air);
            }
            $validatedData['photo_kran_air'] = $request->file('photo_kran_air')->store('checksheet-eyewasher');
        }

        if ($request->file('photo_tuas')) {
            if ($request->oldImage_tuas) {
                Storage::delete($request->oldImage_tuas);
            }
            $validatedData['photo_tuas'] = $request->file('photo_tuas')->store('checksheet-eyewasher');
        }


        // Update data CheckSheetIndoor dengan data baru dari form
        $checkSheeteyewasher->update($validatedData);

        $eyewasher = Eyewasher::where('no_eyewasher', $checkSheeteyewasher->eyewasher_number)->first();

        if (!$eyewasher) {
            return back()->with('error', 'Hydrant tidak ditemukan.');
        }

        return redirect()->route('eyewasher.show', $eyewasher->id)->with('success1', 'Data Check Sheet Eyewasher berhasil diperbarui.');
    }

    public function show($id)
    {
        $checksheet = CheckSheetEyewasher::findOrFail($id);

        return view('dashboard.eyewasher.checksheet.show', compact('checksheet'));
    }
}
