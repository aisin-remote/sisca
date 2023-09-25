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

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-indoor.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $hydrantNumber = $request->input('hydrant_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetHydrantIndoor::with('hydrants')
            ->select('tanggal_pengecekan', 'hydrant_number', 'pintu', 'lampu', 'emergency', 'nozzle', 'selang', 'valve', 'coupling', 'pressure', 'kupla')
            ->whereYear('tanggal_pengecekan', $selectedYear)
            ->where('hydrant_number', $hydrantNumber) // Gunakan nilai tag_number yang diambil dari form
            ->get();

        // Array asosiatif untuk mencocokkan nama bulan dengan kolom
        $bulanKolom = [
            1 => 'H',  // Januari -> Kolom H
            2 => 'I',  // Februari -> Kolom I
            3 => 'J',  // Maret -> Kolom J
            4 => 'K',  // April -> Kolom K
            5 => 'L',  // Mei -> Kolom L
            6 => 'M',  // Juni -> Kolom M
            7 => 'N',  // Juli -> Kolom N
            8 => 'O',  // Agustus -> Kolom O
            9 => 'P',  // September -> Kolom P
            10 => 'Q', // Oktober -> Kolom Q
            11 => 'R', // November -> Kolom R
            12 => 'S', // December -> Kolom Si
        ];

        $worksheet->setCellValue('R' . 1, ': ' . $data[0]->hydrant_number);
        $worksheet->setCellValue('R' . 2, ': ' . $data[0]->hydrants->locations->location_name);
        $worksheet->setCellValue('R' . 3, ': ' . $data[0]->hydrants->zona);


        foreach ($data as $item) {

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $bulan = Carbon::parse($item->tanggal_pengecekan)->format('n');

            // Tentukan kolom berdasarkan bulan
            $col = $bulanKolom[$bulan];

            // Set value based on $item->pressure
            if ($item->pintu === 'OK') {
                $worksheet->setCellValue($col . 8, '√');
            } else if ($item->pintu === 'NG') {
                $worksheet->setCellValue($col . 8, 'X');
            }

            // Set value based on $item->hose
            if ($item->lampu === 'OK') {
                $worksheet->setCellValue($col . 10, '√');
            } else if ($item->lampu === 'NG') {
                $worksheet->setCellValue($col . 10, 'X');
            }

            // Set value based on $item->corong
            if ($item->emergency === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->emergency === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->tabung
            if ($item->nozzle === 'OK') {
                $worksheet->setCellValue($col . 14, '√');
            } else if ($item->nozzle === 'NG') {
                $worksheet->setCellValue($col . 14, 'X');
            }

            // Set value based on $item->regulator
            if ($item->selang === 'OK') {
                $worksheet->setCellValue($col . 16, '√');
            } else if ($item->selang === 'NG') {
                $worksheet->setCellValue($col . 16, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->valve === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->valve === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->coupling === 'OK') {
                $worksheet->setCellValue($col . 20, '√');
            } else if ($item->coupling === 'NG') {
                $worksheet->setCellValue($col . 20, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->pressure === 'OK') {
                $worksheet->setCellValue($col . 22, '√');
            } else if ($item->pressure === 'NG') {
                $worksheet->setCellValue($col . 22, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->kupla === 'OK') {
                $worksheet->setCellValue($col . 24, '√');
            } else if ($item->kupla === 'NG') {
                $worksheet->setCellValue($col . 24, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-indoor.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
