<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use Illuminate\Http\Request;
use App\Models\CheckSheetCo2;
use App\Models\CheckSheetPowder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CheckSheetCo2Controller extends Controller
{
    public function showForm($tagNumber)
    {
        $latestCheckSheetPowders = CheckSheetPowder::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetCo2 = CheckSheetCo2::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetPowders->merge($latestCheckSheetCo2);

        // Mencari entri Co2 berdasarkan no_tabung
        $apar = Apar::where('tag_number', $tagNumber)->first();

        if (!$apar) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('show.form', compact('combinedLatestCheckSheets'))->with('error', 'Apar Number tidak ditemukan.');
        }

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetCo2 untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetCo2::where('apar_number', $tagNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        $tagNumber = strtoupper($tagNumber);

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('apar.checksheetco2.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Co2 sudah ada untuk Apar ' . $tagNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetCo2s = CheckSheetCo2::all();
            return view('dashboard.checkSheet.checkCo2', compact('checkSheetCo2s', 'tagNumber'));
        }
    }


    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetCo2 untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetCo2::where('apar_number', $request->apar_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'apar_number' => 'required',
                'pressure' => 'required',
                'catatan_pressure' => 'nullable|string|max:255',
                'photo_pressure' => 'required|image|file|max:3072',
                'hose' => 'required',
                'catatan_hose' => 'nullable|string|max:255',
                'photo_hose' => 'required|image|file|max:3072',
                'corong' => 'required',
                'catatan_corong' => 'nullable|string|max:255',
                'photo_corong' => 'required|image|file|max:3072',
                'tabung' => 'required',
                'catatan_tabung' => 'nullable|string|max:255',
                'photo_tabung' => 'required|image|file|max:3072',
                'regulator' => 'required',
                'catatan_regulator' => 'nullable|string|max:255',
                'photo_regulator' => 'required|image|file|max:3072',
                'lock_pin' => 'required',
                'catatan_lock_pin' => 'nullable|string|max:255',
                'photo_lock_pin' => 'required|image|file|max:3072',
                'berat_tabung' => 'required',
                'catatan_berat_tabung' => 'nullable|string|max:255',
                'photo_berat_tabung' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['apar_number'] = strtoupper($validatedData['apar_number']);

            if ($request->file('photo_pressure') && $request->file('photo_hose') && $request->file('photo_corong') && $request->file('photo_tabung') && $request->file('photo_regulator') && $request->file('photo_lock_pin') && $request->file('photo_berat_tabung')) {
                $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_hose'] = $request->file('photo_hose')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_corong'] = $request->file('photo_corong')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_regulator'] = $request->file('photo_regulator')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_berat_tabung'] = $request->file('photo_berat_tabung')->store('checksheet-apar-co2-af11e');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika belum ada entri, buat entri baru
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'apar_number' => 'required',
                'pressure' => 'required',
                'catatan_pressure' => 'nullable|string|max:255',
                'photo_pressure' => 'required|image|file|max:3072',
                'hose' => 'required',
                'catatan_hose' => 'nullable|string|max:255',
                'photo_hose' => 'required|image|file|max:3072',
                'corong' => 'required',
                'catatan_corong' => 'nullable|string|max:255',
                'photo_corong' => 'required|image|file|max:3072',
                'tabung' => 'required',
                'catatan_tabung' => 'nullable|string|max:255',
                'photo_tabung' => 'required|image|file|max:3072',
                'regulator' => 'required',
                'catatan_regulator' => 'nullable|string|max:255',
                'photo_regulator' => 'required|image|file|max:3072',
                'lock_pin' => 'required',
                'catatan_lock_pin' => 'nullable|string|max:255',
                'photo_lock_pin' => 'required|image|file|max:3072',
                'berat_tabung' => 'required',
                'catatan_berat_tabung' => 'nullable|string|max:255',
                'photo_berat_tabung' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['apar_number'] = strtoupper($validatedData['apar_number']);

            if ($request->file('photo_pressure') && $request->file('photo_hose') && $request->file('photo_corong') && $request->file('photo_tabung') && $request->file('photo_regulator') && $request->file('photo_lock_pin') && $request->file('photo_berat_tabung')) {
                $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_hose'] = $request->file('photo_hose')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_corong'] = $request->file('photo_corong')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_regulator'] = $request->file('photo_regulator')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-apar-co2-af11e');
                $validatedData['photo_berat_tabung'] = $request->file('photo_berat_tabung')->store('checksheet-apar-co2-af11e');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetCo2::create($validatedData);

            return redirect()->route('show.form')->with('success', 'Data berhasil disimpan.');
        }
    }


    public function edit($id)
    {
        $checkSheetco2 = CheckSheetCo2::findOrFail($id);
        return view('dashboard.apar.checksheetco2.edit', compact('checkSheetco2'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetco2 = CheckSheetCo2::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'pressure' => 'required',
            'catatan_pressure' => 'nullable|string|max:255',
            'photo_pressure' => 'image|file|max:3072',
            'hose' => 'required',
            'catatan_hose' => 'nullable|string|max:255',
            'photo_hose' => 'image|file|max:3072',
            'corong' => 'required',
            'catatan_corong' => 'nullable|string|max:255',
            'photo_corong' => 'image|file|max:3072',
            'tabung' => 'required',
            'catatan_tabung' => 'nullable|string|max:255',
            'photo_tabung' => 'image|file|max:3072',
            'regulator' => 'required',
            'catatan_regulator' => 'nullable|string|max:255',
            'photo_regulator' => 'image|file|max:3072',
            'lock_pin' => 'required',
            'catatan_lock_pin' => 'nullable|string|max:255',
            'photo_lock_pin' => 'image|file|max:3072',
            'berat_tabung' => 'required',
            'catatan_berat_tabung' => 'nullable|string|max:255',
            'photo_berat_tabung' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_pressure')) {
            if ($request->oldImage_pressure) {
                Storage::delete($request->oldImage_pressure);
            }
            $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-apar-co2-af11e');
        }

        if ($request->file('photo_hose')) {
            if ($request->oldImage_hose) {
                Storage::delete($request->oldImage_hose);
            }
            $validatedData['photo_hose'] = $request->file('photo_hose')->store('checksheet-apar-co2-af11e');
        }

        if ($request->file('photo_corong')) {
            if ($request->oldImage_corong) {
                Storage::delete($request->oldImage_corong);
            }
            $validatedData['photo_corong'] = $request->file('photo_corong')->store('checksheet-apar-co2-af11e');
        }

        if ($request->file('photo_tabung')) {
            if ($request->oldImage_tabung) {
                Storage::delete($request->oldImage_tabung);
            }
            $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-apar-co2-af11e');
        }

        if ($request->file('photo_regulator')) {
            if ($request->oldImage_regulator) {
                Storage::delete($request->oldImage_regulator);
            }
            $validatedData['photo_regulator'] = $request->file('photo_regulator')->store('checksheet-apar-co2-af11e');
        }

        if ($request->file('photo_lock_pin')) {
            if ($request->oldImage_lock_pin) {
                Storage::delete($request->oldImage_lock_pin);
            }
            $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-apar-co2-af11e');
        }

        if ($request->file('photo_berat_tabung')) {
            if ($request->oldImage_berat_tabung) {
                Storage::delete($request->oldImage_berat_tabung);
            }
            $validatedData['photo_berat_tabung'] = $request->file('photo_berat_tabung')->store('checksheet-apar-co2-af11e');
        }

        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheetco2->update($validatedData);

        $apar = Apar::where('tag_number', $checkSheetco2->apar_number)->first();

        if (!$apar) {
            return back()->with('error', 'Apar tidak ditemukan.');
        }

        return redirect()->route('apar.show', $apar->id)->with('success1', 'Data Check Sheet Co2 berhasil diperbarui.');
    }

    public function show($id)
    {
        $checksheet = CheckSheetCo2::findOrFail($id);

        return view('dashboard.apar.checksheet.show', compact('checksheet'));
    }

    public function destroy($id)
    {
        $checkSheetco2 = CheckSheetCo2::find($id);

        if ($checkSheetco2->photo_pressure || $checkSheetco2->photo_hose || $checkSheetco2->photo_corong || $checkSheetco2->photo_tabung || $checkSheetco2->photo_regulator || $checkSheetco2->photo_lock_pin || $checkSheetco2->photo_berat_tabung) {
            Storage::delete($checkSheetco2->photo_pressure);
            Storage::delete($checkSheetco2->photo_hose);
            Storage::delete($checkSheetco2->photo_corong);
            Storage::delete($checkSheetco2->photo_tabung);
            Storage::delete($checkSheetco2->photo_regulator);
            Storage::delete($checkSheetco2->photo_lock_pin);
            Storage::delete($checkSheetco2->photo_berat_tabung);
        }

        $checkSheetco2->delete();

        return back()->with('success1', 'Data Check Sheet Apar Co2 berhasil dihapus');
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-co.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $tagNumber = $request->input('tag_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetCo2::select('tanggal_pengecekan', 'pressure', 'hose', 'corong', 'tabung', 'regulator', 'lock_pin', 'berat_tabung')
            ->whereYear('tanggal_pengecekan', $selectedYear)
            ->where('apar_number', $tagNumber) // Gunakan nilai tag_number yang diambil dari form
            ->get();

        // Start row to populate data in Excel
        $row = 11;

        foreach ($data as $item) {
            $worksheet->setCellValue('B' . $row, $item->tanggal_pengecekan);
            $worksheet->setCellValue('V' . $row, $item->tanggal_pengecekan);

            // Set value based on $item->pressure
            if ($item->pressure === 'OK') {
                $worksheet->setCellValue('F' . $row, '√');
                $worksheet->setCellValue('Z' . $row, '√');
            } else if ($item->pressure === 'NG') {
                $worksheet->setCellValue('F' . $row, 'X');
                $worksheet->setCellValue('Z' . $row, 'X');
            }

            // Set value based on $item->hose
            if ($item->hose === 'OK') {
                $worksheet->setCellValue('H' . $row, '√');
                $worksheet->setCellValue('AB' . $row, '√');
            } else if ($item->hose === 'NG') {
                $worksheet->setCellValue('H' . $row, 'X');
                $worksheet->setCellValue('AB' . $row, 'X');
            }

            // Set value based on $item->corong
            if ($item->corong === 'OK') {
                $worksheet->setCellValue('J' . $row, '√');
                $worksheet->setCellValue('AD' . $row, '√');
            } else if ($item->corong === 'NG') {
                $worksheet->setCellValue('J' . $row, 'X');
                $worksheet->setCellValue('AD' . $row, 'X');
            }

            // Set value based on $item->tabung
            if ($item->tabung === 'OK') {
                $worksheet->setCellValue('K' . $row, '√');
                $worksheet->setCellValue('AE' . $row, '√');
            } else if ($item->tabung === 'NG') {
                $worksheet->setCellValue('K' . $row, 'X');
                $worksheet->setCellValue('AE' . $row, 'X');
            }

            // Set value based on $item->regulator
            if ($item->regulator === 'OK') {
                $worksheet->setCellValue('L' . $row, '√');
                $worksheet->setCellValue('AF' . $row, '√');
            } else if ($item->regulator === 'NG') {
                $worksheet->setCellValue('L' . $row, 'X');
                $worksheet->setCellValue('AF' . $row, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->lock_pin === 'OK') {
                $worksheet->setCellValue('N' . $row, '√');
                $worksheet->setCellValue('AH' . $row, '√');
            } else if ($item->lock_pin === 'NG') {
                $worksheet->setCellValue('N' . $row, 'X');
                $worksheet->setCellValue('AH' . $row, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->berat_tabung === 'OK') {
                $worksheet->setCellValue('P' . $row, '√');
                $worksheet->setCellValue('AJ' . $row, '√');
            } else if ($item->berat_tabung === 'NG') {
                $worksheet->setCellValue('P' . $row, 'X');
                $worksheet->setCellValue('AJ' . $row, 'X');
            }

            // Increment row for the next data
            $row++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-co.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
