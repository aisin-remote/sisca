<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Apar;
use Illuminate\Http\Request;
use App\Models\CheckSheetPowder;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetPowderController extends Controller
{
    public function showForm($tagNumber)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetPowder untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetPowder::where('apar_number', $tagNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('apar.checksheetpowder.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Powder sudah ada untuk Apar ' . $tagNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetPowders = CheckSheetPowder::all();
            return view('dashboard.checkSheet.checkPowder', compact('checkSheetPowders', 'tagNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetPowder untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetPowder::where('apar_number', $request->apar_number)
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
                'tabung' => 'required',
                'catatan_tabung' => 'nullable|string|max:255',
                'photo_tabung' => 'required|image|file|max:3072',
                'regulator' => 'required',
                'catatan_regulator' => 'nullable|string|max:255',
                'photo_regulator' => 'required|image|file|max:3072',
                'lock_pin' => 'required',
                'catatan_lock_pin' => 'nullable|string|max:255',
                'photo_lock_pin' => 'required|image|file|max:3072',
                'powder' => 'required',
                'catatan_powder' => 'nullable|string|max:255',
                'photo_powder' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_pressure') && $request->file('photo_hose') && $request->file('photo_tabung') && $request->file('photo_regulator') && $request->file('photo_lock_pin') && $request->file('photo_powder')) {
                $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-apar-powder');
                $validatedData['photo_hose'] = $request->file('photo_hose')->store('checksheet-apar-powder');
                $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-apar-powder');
                $validatedData['photo_regulator'] = $request->file('photo_regulator')->store('checksheet-apar-powder');
                $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-apar-powder');
                $validatedData['photo_powder'] = $request->file('photo_powder')->store('checksheet-apar-powder');
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
                'tabung' => 'required',
                'catatan_tabung' => 'nullable|string|max:255',
                'photo_tabung' => 'required|image|file|max:3072',
                'regulator' => 'required',
                'catatan_regulator' => 'nullable|string|max:255',
                'photo_regulator' => 'required|image|file|max:3072',
                'lock_pin' => 'required',
                'catatan_lock_pin' => 'nullable|string|max:255',
                'photo_lock_pin' => 'required|image|file|max:3072',
                'powder' => 'required',
                'catatan_powder' => 'nullable|string|max:255',
                'photo_powder' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_pressure') && $request->file('photo_hose') && $request->file('photo_tabung') && $request->file('photo_regulator') && $request->file('photo_lock_pin') && $request->file('photo_powder')) {
                $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-apar-powder');
                $validatedData['photo_hose'] = $request->file('photo_hose')->store('checksheet-apar-powder');
                $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-apar-powder');
                $validatedData['photo_regulator'] = $request->file('photo_regulator')->store('checksheet-apar-powder');
                $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-apar-powder');
                $validatedData['photo_powder'] = $request->file('photo_powder')->store('checksheet-apar-powder');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;


            // Simpan data baru ke database menggunakan metode create
            CheckSheetPowder::create($validatedData);

            return redirect()->route('show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function edit($id)
    {
        $checkSheetpowder = CheckSheetPowder::findOrFail($id);
        return view('dashboard.apar.checksheetpowder.edit', compact('checkSheetpowder'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetpowder = CheckSheetPowder::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'pressure' => 'required',
            'catatan_pressure' => 'nullable|string|max:255',
            'photo_pressure' => 'image|file|max:3072',
            'hose' => 'required',
            'catatan_hose' => 'nullable|string|max:255',
            'photo_hose' => 'image|file|max:3072',
            'tabung' => 'required',
            'catatan_tabung' => 'nullable|string|max:255',
            'photo_tabung' => 'image|file|max:3072',
            'regulator' => 'required',
            'catatan_regulator' => 'nullable|string|max:255',
            'photo_regulator' => 'image|file|max:3072',
            'lock_pin' => 'required',
            'catatan_lock_pin' => 'nullable|string|max:255',
            'photo_lock_pin' => 'image|file|max:3072',
            'powder' => 'required',
            'catatan_powder' => 'nullable|string|max:255',
            'photo_powder' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_pressure')) {
            if ($request->oldImage_pressure) {
                Storage::delete($request->oldImage_pressure);
            }
            $validatedData['photo_pressure'] = $request->file('photo_pressure')->store('checksheet-apar-powder');
        }

        if ($request->file('photo_hose')) {
            if ($request->oldImage_hose) {
                Storage::delete($request->oldImage_hose);
            }
            $validatedData['photo_hose'] = $request->file('photo_hose')->store('checksheet-apar-powder');
        }

        if ($request->file('photo_tabung')) {
            if ($request->oldImage_tabung) {
                Storage::delete($request->oldImage_tabung);
            }
            $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-apar-powder');
        }

        if ($request->file('photo_regulator')) {
            if ($request->oldImage_regulator) {
                Storage::delete($request->oldImage_regulator);
            }
            $validatedData['photo_regulator'] = $request->file('photo_regulator')->store('checksheet-apar-powder');
        }

        if ($request->file('photo_lock_pin')) {
            if ($request->oldImage_lock_pin) {
                Storage::delete($request->oldImage_lock_pin);
            }
            $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-apar-powder');
        }

        if ($request->file('photo_powder')) {
            if ($request->oldImage_powder) {
                Storage::delete($request->oldImage_powder);
            }
            $validatedData['photo_powder'] = $request->file('photo_powder')->store('checksheet-apar-powder');
        }

        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheetpowder->update($validatedData);

        $apar = Apar::where('tag_number', $checkSheetpowder->apar_number)->first();

        if (!$apar) {
            return back()->with('error', 'Apar tidak ditemukan.');
        }

        return redirect()->route('apar.show', $apar->id)->with('success1', 'Data Check Sheet Powder berhasil diperbarui.');
    }

    public function show($id)
    {
        $checksheet = CheckSheetPowder::findOrFail($id);

        return view('dashboard.apar.checksheet.show', compact('checksheet'));
    }

    public function destroy($id)
    {
        $checkSheetpowder = CheckSheetPowder::find($id);

        if ($checkSheetpowder->photo_pressure || $checkSheetpowder->photo_hose || $checkSheetpowder->photo_tabung || $checkSheetpowder->photo_regulator || $checkSheetpowder->photo_lock_pin || $checkSheetpowder->photo_powder) {
            Storage::delete($checkSheetpowder->photo_pressure);
            Storage::delete($checkSheetpowder->photo_hose);
            Storage::delete($checkSheetpowder->photo_tabung);
            Storage::delete($checkSheetpowder->photo_regulator);
            Storage::delete($checkSheetpowder->photo_lock_pin);
            Storage::delete($checkSheetpowder->photo_powder);
        }

        $checkSheetpowder->delete();

        return back()->with('success1', 'Data Check Sheet Apar Powder berhasil dihapus');
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-powder.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $tagNumber = $request->input('tag_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetPowder::select('tanggal_pengecekan', 'pressure', 'hose', 'tabung', 'regulator', 'lock_pin', 'powder')
            ->whereYear('tanggal_pengecekan', $selectedYear)
            ->where('apar_number', $tagNumber) // Gunakan nilai tag_number yang diambil dari form
            ->get();

        // Start row to populate data in Excel
        $row = 10;

        foreach ($data as $item) {
            $worksheet->setCellValue('B' . $row, $item->tanggal_pengecekan);

            // Set value based on $item->pressure
            if ($item->pressure === 'OK') {
                $worksheet->setCellValue('F' . $row, '√');
            } else if ($item->pressure === 'NG') {
                $worksheet->setCellValue('F' . $row, 'X');
            }

            // Set value based on $item->hose
            if ($item->hose === 'OK') {
                $worksheet->setCellValue('I' . $row, '√');
            } else if ($item->hose === 'NG') {
                $worksheet->setCellValue('I' . $row, 'X');
            }

            // Set value based on $item->regulator
            if ($item->regulator === 'OK') {
                $worksheet->setCellValue('K' . $row, '√');
            } else if ($item->regulator === 'NG') {
                $worksheet->setCellValue('K' . $row, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->lock_pin === 'OK') {
                $worksheet->setCellValue('L' . $row, '√');
            } else if ($item->lock_pin === 'NG') {
                $worksheet->setCellValue('L' . $row, 'X');
            }

            // Set value based on $item->tabung
            if ($item->tabung === 'OK') {
                $worksheet->setCellValue('N' . $row, '√');
            } else if ($item->tabung === 'NG') {
                $worksheet->setCellValue('N' . $row, 'X');
            }

            // Set value based on $item->powder
            if ($item->powder === 'OK') {
                $worksheet->setCellValue('Q' . $row, '√');
            } else if ($item->powder === 'NG') {
                $worksheet->setCellValue('Q' . $row, 'X');
            }

            // Increment row for the next data
            $row++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-powder.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
