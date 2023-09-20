<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHydrantIndoor;
use App\Models\CheckSheetHydrantOutdoor;
use App\Models\Hydrant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetHydrantIndoorController extends Controller
{

    public function showForm($hydrantNumber)
    {
        $latestCheckSheetOutdoors = CheckSheetHydrantOutdoor::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetIndoor = CheckSheetHydrantIndoor::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetOutdoors->merge($latestCheckSheetIndoor);

        // Mencari entri Co2 berdasarkan no_tabung
        $hydrant = Hydrant::where('no_hydrant', $hydrantNumber)->first();

        if (!$hydrant) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('hydrant.show.form', compact('combinedLatestCheckSheets'))->with('error', 'Hydrant Number tidak ditemukan.');
        }

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetHydrantIndoor::where('hydrant_number', $hydrantNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        $hydrantNumber = strtoupper($hydrantNumber);

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

            $validatedData['hydrant_number'] = strtoupper($validatedData['hydrant_number']);

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

            $validatedData['hydrant_number'] = strtoupper($validatedData['hydrant_number']);

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

        return redirect()->route('hydrant.show', $hydrant->id)->with('success1', 'Data Check Sheet Hydrant Indoor berhasil diperbarui.');
    }

    public function show($id)
    {
        $checksheet = CheckSheetHydrantIndoor::findOrFail($id);

        return view('dashboard.hydrant.checksheet.show', compact('checksheet'));
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
            12 => 'S', // Desember -> Kolom S
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
