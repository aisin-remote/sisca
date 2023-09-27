<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetEyewasher;
use App\Models\CheckSheetEyewasherShower;
use App\Models\Eyewasher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

            if ($request->file('photo_instalation_base') && $request->file('photo_pipa_saluran_air') && $request->file('photo_wastafel_eye_wash') && $request->file('photo_tuas_eye_wash') && $request->file('photo_kran_eye_wash') && $request->file('photo_tuas_shower') && $request->file('photo_sign') && $request->file('photo_shower_head')) {
                $validatedData['photo_instalation_base'] = $request->file('photo_instalation_base')->store('checksheet-eyewasher-shower');
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

            if ($request->file('photo_instalation_base') && $request->file('photo_pipa_saluran_air') && $request->file('photo_wastafel_eye_wash') && $request->file('photo_tuas_eye_wash') && $request->file('photo_kran_eye_wash') && $request->file('photo_tuas_shower') && $request->file('photo_sign') && $request->file('photo_shower_head')) {
                $validatedData['photo_instalation_base'] = $request->file('photo_instalation_base')->store('checksheet-eyewasher-shower');
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

    public function update(Request $request, $id)
    {
        $checkSheetshower = CheckSheetEyewasherShower::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'instalation_base' => 'required',
            'catatan_instalation_base' => 'nullable|string|max:255',
            'photo_instalation_base' => 'image|file|max:3072',
            'pipa_saluran_air' => 'required',
            'catatan_pipa_saluran_air' => 'nullable|string|max:255',
            'photo_pipa_saluran_air' => 'image|file|max:3072',
            'wastafel_eye_wash' => 'required',
            'catatan_wastafel_eye_wash' => 'nullable|string|max:255',
            'photo_wastafel_eye_wash' => 'image|file|max:3072',
            'tuas_eye_wash' => 'required',
            'catatan_tuas_eye_wash' => 'nullable|string|max:255',
            'photo_tuas_eye_wash' => 'image|file|max:3072',
            'kran_eye_wash' => 'required',
            'catatan_kran_eye_wash' => 'nullable|string|max:255',
            'photo_kran_eye_wash' => 'image|file|max:3072',
            'tuas_shower' => 'required',
            'catatan_tuas_shower' => 'nullable|string|max:255',
            'photo_tuas_shower' => 'image|file|max:3072',
            'sign' => 'required',
            'catatan_sign' => 'nullable|string|max:255',
            'photo_sign' => 'image|file|max:3072',
            'shower_head' => 'required',
            'catatan_shower_head' => 'nullable|string|max:255',
            'photo_shower_head' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_instalation_base')) {
            if ($request->oldImage_instalation_base) {
                Storage::delete($request->oldImage_instalation_base);
            }
            $validatedData['photo_instalation_base'] = $request->file('photo_instalation_base')->store('checksheet-eyewasher-shower');
        }

        if ($request->file('photo_pipa_saluran_air')) {
            if ($request->oldImage_pipa_saluran_air) {
                Storage::delete($request->oldImage_pipa_saluran_air);
            }
            $validatedData['photo_pipa_saluran_air'] = $request->file('photo_pipa_saluran_air')->store('checksheet-eyewasher-shower');
        }

        if ($request->file('photo_wastafel_eye_wash')) {
            if ($request->oldImage_wastafel_eye_wash) {
                Storage::delete($request->oldImage_wastafel_eye_wash);
            }
            $validatedData['photo_wastafel_eye_wash'] = $request->file('photo_wastafel_eye_wash')->store('checksheet-eyewasher-shower');
        }

        if ($request->file('photo_kran_eye_wash')) {
            if ($request->oldImage_kran_eye_wash) {
                Storage::delete($request->oldImage_kran_eye_wash);
            }
            $validatedData['photo_kran_eye_wash'] = $request->file('photo_kran_eye_wash')->store('checksheet-eyewasher-shower');
        }

        if ($request->file('photo_tuas_eye_wash')) {
            if ($request->oldImage_tuas_eye_wash) {
                Storage::delete($request->oldImage_tuas_eye_wash);
            }
            $validatedData['photo_tuas_eye_wash'] = $request->file('photo_tuas_eye_wash')->store('checksheet-eyewasher-shower');
        }

        if ($request->file('photo_tuas_shower')) {
            if ($request->oldImage_tuas_shower) {
                Storage::delete($request->oldImage_tuas_shower);
            }
            $validatedData['photo_tuas_shower'] = $request->file('photo_tuas_shower')->store('checksheet-eyewasher-shower');
        }

        if ($request->file('photo_sign')) {
            if ($request->oldImage_sign) {
                Storage::delete($request->oldImage_sign);
            }
            $validatedData['photo_sign'] = $request->file('photo_sign')->store('checksheet-eyewasher-shower');
        }

        if ($request->file('photo_shower_head')) {
            if ($request->oldImage_shower_head) {
                Storage::delete($request->oldImage_shower_head);
            }
            $validatedData['photo_shower_head'] = $request->file('photo_shower_head')->store('checksheet-eyewasher-shower');
        }


        // Update data CheckSheetIndoor dengan data baru dari form
        $checkSheetshower->update($validatedData);

        $eyewasher = Eyewasher::where('no_eyewasher', $checkSheetshower->eyewasher_number)->first();

        if (!$eyewasher) {
            return back()->with('error', 'Eyewasher tidak ditemukan.');
        }

        return redirect()->route('eye-washer.show', $eyewasher->id)->with('success1', 'Data Check Sheet Eyewasher berhasil diperbarui.');
    }

    public function show($id)
    {
        $checksheet = CheckSheetEyewasherShower::findOrFail($id);

        return view('dashboard.eyewasher.checksheet.show', compact('checksheet'));
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

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-shower.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $eyewasherNumber = $request->input('eyewasher_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetEyewasherShower::with('eyewashers')
            ->select('tanggal_pengecekan', 'eyewasher_number', 'instalation_base', 'pipa_saluran_air', 'wastafel_eye_wash', 'kran_eye_wash', 'tuas_eye_wash', 'tuas_shower', 'sign', 'shower_head')
            ->whereYear('tanggal_pengecekan', $selectedYear)
            ->where('eyewasher_number', $eyewasherNumber) // Gunakan nilai tag_number yang diambil dari form
            ->get();

        // Array asosiatif untuk mencocokkan nama bulan dengan kolom
        $bulanKolom = [
            1 => 'F',  // Januari -> Kolom H
            2 => 'G',  // Februari -> Kolom I
            3 => 'H',  // Maret -> Kolom J
            4 => 'I',  // April -> Kolom K
            5 => 'J',  // Mei -> Kolom L
            6 => 'K',  // Juni -> Kolom M
            7 => 'L',  // Juli -> Kolom N
            8 => 'M',  // Agustus -> Kolom O
            9 => 'N',  // September -> Kolom P
            10 => 'O', // Oktober -> Kolom Q
            11 => 'P', // November -> Kolom R
            12 => 'Q', // December -> Kolom S
        ];

        $worksheet->setCellValue('O' . 2, $data[0]->eyewasher_number);
        $worksheet->setCellValue('O' . 3, $data[0]->eyewashers->plant);
        $worksheet->setCellValue('O' . 4, $data[0]->eyewashers->locations->location_name);
        $worksheet->setCellValue('O' . 5, $data[0]->eyewashers->type);

        foreach ($data as $item) {

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $bulan = Carbon::parse($item->tanggal_pengecekan)->format('n');

            // Tentukan kolom berdasarkan bulan
            $col = $bulanKolom[$bulan];

            // Set value based on $item->pressure
            if ($item->instalation_base === 'OK') {
                $worksheet->setCellValue($col . 9, '√');
            } else if ($item->instalation_base === 'NG') {
                $worksheet->setCellValue($col . 9, 'X');
            }

            // Set value based on $item->hose
            if ($item->pipa_saluran_air === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->pipa_saluran_air === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->corong
            if ($item->wastafel_eye_wash === 'OK') {
                $worksheet->setCellValue($col . 15, '√');
            } else if ($item->wastafel_eye_wash === 'NG') {
                $worksheet->setCellValue($col . 15, 'X');
            }

            // Set value based on $item->tabung
            if ($item->kran_eye_wash === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->kran_eye_wash === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->regulator
            if ($item->tuas_eye_wash === 'OK') {
                $worksheet->setCellValue($col . 21, '√');
            } else if ($item->tuas_eye_wash === 'NG') {
                $worksheet->setCellValue($col . 21, 'X');
            }

            if ($item->tuas_shower === 'OK') {
                $worksheet->setCellValue($col . 24, '√');
            } else if ($item->tuas_shower === 'NG') {
                $worksheet->setCellValue($col . 24, 'X');
            }

            if ($item->sign === 'OK') {
                $worksheet->setCellValue($col . 27, '√');
            } else if ($item->sign === 'NG') {
                $worksheet->setCellValue($col . 27, 'X');
            }

            if ($item->shower_head === 'OK') {
                $worksheet->setCellValue($col . 30, '√');
            } else if ($item->shower_head === 'NG') {
                $worksheet->setCellValue($col . 30, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-eyewasher-shower.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
