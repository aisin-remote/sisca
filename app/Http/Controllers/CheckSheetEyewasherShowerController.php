<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetEyewasher;
use App\Models\CheckSheetEyewasherShower;
use App\Models\Eyewasher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckSheetEyewasherShowerController extends Controller
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
        $existingCheckSheet = CheckSheetEyewasherShower::where('eyewasher_number', $eyewasherNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        $eyewasherNumber = strtoupper($eyewasherNumber);

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('eyewasher.checksheetshower.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet sudah ada untuk Eyewasher Shower ' . $eyewasherNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetShowers = CheckSheetEyewasherShower::all();
            return view('dashboard.eyewasher.checksheet.checkShower', compact('checkSheetShowers', 'eyewasherNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetEyewasherShower::where('eyewasher_number', $request->eyewasher_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'eyewasher_number' => 'required',
                'instalation_base' => 'required',
                'catatan_instalation_base' => 'nullable|string|max:255',
                'photo_instalation_base' => 'required|image|file|max:3072',
                'pipa_saluran_air' => 'required',
                'catatan_pipa_saluran_air' => 'nullable|string|max:255',
                'photo_pipa_saluran_air' => 'required|image|file|max:3072',
                'wastafel_eye_wash' => 'required',
                'catatan_wastafel_eye_wash' => 'nullable|string|max:255',
                'photo_wastafel_eye_wash' => 'required|image|file|max:3072',
                'tuas_eye_wash' => 'required',
                'catatan_tuas_eye_wash' => 'nullable|string|max:255',
                'photo_tuas_eye_wash' => 'required|image|file|max:3072',
                'kran_eye_wash' => 'required',
                'catatan_kran_eye_wash' => 'nullable|string|max:255',
                'photo_kran_eye_wash' => 'required|image|file|max:3072',
                'tuas_shower' => 'required',
                'catatan_tuas_shower' => 'nullable|string|max:255',
                'photo_tuas_shower' => 'required|image|file|max:3072',
                'sign' => 'required',
                'catatan_sign' => 'nullable|string|max:255',
                'photo_sign' => 'required|image|file|max:3072',
                'shower_head' => 'required',
                'catatan_shower_head' => 'nullable|string|max:255',
                'photo_shower_head' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['eyewasher_number'] = strtoupper($validatedData['eyewasher_number']);

            if ($request->file('instalation_base') && $request->file('photo_pipa_saluran_air') && $request->file('photo_wastafel_eye_wash') && $request->file('photo_tuas_eye_wash') && $request->file('photo_kran_eye_wash') && $request->file('photo_tuas_shower') && $request->file('photo_sign') && $request->file('photo_shower_head')) {
                $validatedData['instalation_base'] = $request->file('instalation_base')->store('checksheet-eyewasher-shower');
                $validatedData['photo_pipa_saluran_air'] = $request->file('photo_pipa_saluran_air')->store('checksheet-eyewasher-shower');
                $validatedData['photo_wastafel_eye_wash'] = $request->file('photo_wastafel_eye_wash')->store('checksheet-eyewasher-shower');
                $validatedData['photo_tuas_eye_wash'] = $request->file('photo_tuas_eye_wash')->store('checksheet-eyewasher-shower');
                $validatedData['photo_kran_eye_wash'] = $request->file('photo_kran_eye_wash')->store('checksheet-eyewasher-shower');
                $validatedData['photo_tuas_shower'] = $request->file('photo_tuas_shower')->store('checksheet-eyewasher-shower');
                $validatedData['photo_sign'] = $request->file('photo_sign')->store('checksheet-eyewasher-shower');
                $validatedData['photo_shower_head'] = $request->file('photo_shower_head')->store('checksheet-eyewasher-shower');


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
                'instalation_base' => 'required',
                'catatan_instalation_base' => 'nullable|string|max:255',
                'photo_instalation_base' => 'required|image|file|max:3072',
                'pipa_saluran_air' => 'required',
                'catatan_pipa_saluran_air' => 'nullable|string|max:255',
                'photo_pipa_saluran_air' => 'required|image|file|max:3072',
                'wastafel_eye_wash' => 'required',
                'catatan_wastafel_eye_wash' => 'nullable|string|max:255',
                'photo_wastafel_eye_wash' => 'required|image|file|max:3072',
                'tuas_eye_wash' => 'required',
                'catatan_tuas_eye_wash' => 'nullable|string|max:255',
                'photo_tuas_eye_wash' => 'required|image|file|max:3072',
                'kran_eye_wash' => 'required',
                'catatan_kran_eye_wash' => 'nullable|string|max:255',
                'photo_kran_eye_wash' => 'required|image|file|max:3072',
                'tuas_shower' => 'required',
                'catatan_tuas_shower' => 'nullable|string|max:255',
                'photo_tuas_shower' => 'required|image|file|max:3072',
                'sign' => 'required',
                'catatan_sign' => 'nullable|string|max:255',
                'photo_sign' => 'required|image|file|max:3072',
                'shower_head' => 'required',
                'catatan_shower_head' => 'nullable|string|max:255',
                'photo_shower_head' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['eyewasher_number'] = strtoupper($validatedData['eyewasher_number']);

            if ($request->file('instalation_base') && $request->file('photo_pipa_saluran_air') && $request->file('photo_wastafel_eye_wash') && $request->file('photo_tuas_eye_wash') && $request->file('photo_kran_eye_wash') && $request->file('photo_tuas_shower') && $request->file('photo_sign') && $request->file('photo_shower_head')) {
                $validatedData['instalation_base'] = $request->file('instalation_base')->store('checksheet-eyewasher-shower');
                $validatedData['photo_pipa_saluran_air'] = $request->file('photo_pipa_saluran_air')->store('checksheet-eyewasher-shower');
                $validatedData['photo_wastafel_eye_wash'] = $request->file('photo_wastafel_eye_wash')->store('checksheet-eyewasher-shower');
                $validatedData['photo_tuas_eye_wash'] = $request->file('photo_tuas_eye_wash')->store('checksheet-eyewasher-shower');
                $validatedData['photo_kran_eye_wash'] = $request->file('photo_kran_eye_wash')->store('checksheet-eyewasher-shower');
                $validatedData['photo_tuas_shower'] = $request->file('photo_tuas_shower')->store('checksheet-eyewasher-shower');
                $validatedData['photo_sign'] = $request->file('photo_sign')->store('checksheet-eyewasher-shower');
                $validatedData['photo_shower_head'] = $request->file('photo_shower_head')->store('checksheet-eyewasher-shower');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetEyewasherShower::create($validatedData);

            return redirect()->route('eyewasher.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function edit($id)
    {
        $checkSheetshower = CheckSheetEyewasherShower::findOrFail($id);
        return view('dashboard.eyewasher.checksheetshower.edit', compact('checkSheetshower'));
    }

    public function destroy($id)
    {
        $checkSheetshower = CheckSheetEyewasherShower::find($id);

        if ($checkSheetshower->photo_instalation_base || $checkSheetshower->photo_pipa_saluran_air || $checkSheetshower->photo_wastafel_eye_wash || $checkSheetshower->photo_kran_eye_wash || $checkSheetshower->photo_tuas_eye_wash || $checkSheetshower->photo_tuas_shower || $checkSheetshower->photo_sign || $checkSheetshower->photo_shower_head) {
            Storage::delete($checkSheetshower->photo_instalation_base);
            Storage::delete($checkSheetshower->photo_pipa_saluran_air);
            Storage::delete($checkSheetshower->photo_wastafel_eye_wash);
            Storage::delete($checkSheetshower->photo_kran_eye_wash);
            Storage::delete($checkSheetshower->photo_tuas_eye_wash);
            Storage::delete($checkSheetshower->photo_tuas_shower);
            Storage::delete($checkSheetshower->photo_sign);
            Storage::delete($checkSheetshower->photo_shower_head);

        }

        $checkSheetshower->delete();

        return back()->with('success1', 'Data Check Sheet Eyewasher berhasil dihapus');
    }
}
