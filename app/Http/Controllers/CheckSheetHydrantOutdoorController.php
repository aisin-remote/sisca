<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHydrantIndoor;
use Illuminate\Http\Request;
use App\Models\CheckSheetHydrantOutdoor;
use App\Models\Hydrant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetHydrantOutdoorController extends Controller
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

        // Mencari entri CheckSheetOutdoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetHydrantOutdoor::where('hydrant_number', $hydrantNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('hydrant.checksheetoutdoor.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Outdoor sudah ada untuk Hydrant ' . $hydrantNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetOutdoors = CheckSheetHydrantOutdoor::all();
            return view('dashboard.hydrant.checksheet.checkOutdoor', compact('checkSheetOutdoors', 'hydrantNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetHydrantOutdoor::where('hydrant_number', $request->hydrant_number)
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
                'nozzle' => 'required',
                'catatan_nozzle' => 'nullable|string|max:255',
                'photo_nozzle' => 'required|image|file|max:3072',
                'selang' => 'required',
                'catatan_selang' => 'nullable|string|max:255',
                'photo_selang' => 'required|image|file|max:3072',
                'tuas' => 'required',
                'catatan_tuas' => 'nullable|string|max:255',
                'photo_tuas' => 'required|image|file|max:3072',
                'pilar' => 'required',
                'catatan_pilar' => 'nullable|string|max:255',
                'photo_pilar' => 'required|image|file|max:3072',
                'penutup' => 'required',
                'catatan_penutup' => 'nullable|string|max:255',
                'photo_penutup' => 'required|image|file|max:3072',
                'rantai' => 'required',
                'catatan_rantai' => 'nullable|string|max:255',
                'photo_rantai' => 'required|image|file|max:3072',
                'kupla' => 'required',
                'catatan_kupla' => 'nullable|string|max:255',
                'photo_kupla' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['hydrant_number'] = strtoupper($validatedData['hydrant_number']);

            if ($request->file('photo_pintu') && $request->file('photo_nozzle') && $request->file('photo_selang') && $request->file('photo_tuas') && $request->file('photo_pilar') && $request->file('photo_penutup') && $request->file('photo_rantai') && $request->file('photo_kupla')) {
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_nozzle'] = $request->file('photo_nozzle')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_tuas'] = $request->file('photo_tuas')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_pilar'] = $request->file('photo_pilar')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_penutup'] = $request->file('photo_penutup')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_rantai'] = $request->file('photo_rantai')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_kupla'] = $request->file('photo_kupla')->store('checksheet-hydrant-outdoor');
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
                'nozzle' => 'required',
                'catatan_nozzle' => 'nullable|string|max:255',
                'photo_nozzle' => 'required|image|file|max:3072',
                'selang' => 'required',
                'catatan_selang' => 'nullable|string|max:255',
                'photo_selang' => 'required|image|file|max:3072',
                'tuas' => 'required',
                'catatan_tuas' => 'nullable|string|max:255',
                'photo_tuas' => 'required|image|file|max:3072',
                'pilar' => 'required',
                'catatan_pilar' => 'nullable|string|max:255',
                'photo_pilar' => 'required|image|file|max:3072',
                'penutup' => 'required',
                'catatan_penutup' => 'nullable|string|max:255',
                'photo_penutup' => 'required|image|file|max:3072',
                'rantai' => 'required',
                'catatan_rantai' => 'nullable|string|max:255',
                'photo_rantai' => 'required|image|file|max:3072',
                'kupla' => 'required',
                'catatan_kupla' => 'nullable|string|max:255',
                'photo_kupla' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['hydrant_number'] = strtoupper($validatedData['hydrant_number']);

            if ($request->file('photo_pintu') && $request->file('photo_nozzle') && $request->file('photo_selang') && $request->file('photo_tuas') && $request->file('photo_pilar') && $request->file('photo_penutup') && $request->file('photo_rantai') && $request->file('photo_kupla')) {
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_nozzle'] = $request->file('photo_nozzle')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_tuas'] = $request->file('photo_tuas')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_pilar'] = $request->file('photo_pilar')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_penutup'] = $request->file('photo_penutup')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_rantai'] = $request->file('photo_rantai')->store('checksheet-hydrant-outdoor');
                $validatedData['photo_kupla'] = $request->file('photo_kupla')->store('checksheet-hydrant-outdoor');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetHydrantOutdoor::create($validatedData);

            return redirect()->route('hydrant.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function edit($id)
    {
        $checkSheetoutdoor = CheckSheetHydrantOutdoor::findOrFail($id);
        return view('dashboard.hydrant.checksheetoutdoor.edit', compact('checkSheetoutdoor'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetoutdoor = CheckSheetHydrantOutdoor::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'pintu' => 'required',
            'catatan_pintu' => 'nullable|string|max:255',
            'photo_pintu' => 'image|file|max:3072',
            'nozzle' => 'required',
            'catatan_nozzle' => 'nullable|string|max:255',
            'photo_nozzle' => 'image|file|max:3072',
            'selang' => 'required',
            'catatan_selang' => 'nullable|string|max:255',
            'photo_selang' => 'image|file|max:3072',
            'tuas' => 'required',
            'catatan_tuas' => 'nullable|string|max:255',
            'photo_tuas' => 'image|file|max:3072',
            'pilar' => 'required',
            'catatan_pilar' => 'nullable|string|max:255',
            'photo_pilar' => 'image|file|max:3072',
            'penutup' => 'required',
            'catatan_penutup' => 'nullable|string|max:255',
            'photo_penutup' => 'image|file|max:3072',
            'rantai' => 'required',
            'catatan_rantai' => 'nullable|string|max:255',
            'photo_rantai' => 'image|file|max:3072',
            'kupla' => 'required',
            'catatan_kupla' => 'nullable|string|max:255',
            'photo_kupla' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_pintu')) {
            if ($request->oldImage_pintu) {
                Storage::delete($request->oldImage_pintu);
            }
            $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-hydrant-outdoor');
        }

        if ($request->file('photo_nozzle')) {
            if ($request->oldImage_nozzle) {
                Storage::delete($request->oldImage_nozzle);
            }
            $validatedData['photo_nozzle'] = $request->file('photo_nozzle')->store('checksheet-hydrant-outdoor');
        }

        if ($request->file('photo_selang')) {
            if ($request->oldImage_selang) {
                Storage::delete($request->oldImage_selang);
            }
            $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-hydrant-outdoor');
        }

        if ($request->file('photo_tuas')) {
            if ($request->oldImage_tuas) {
                Storage::delete($request->oldImage_tuas);
            }
            $validatedData['photo_tuas'] = $request->file('photo_tuas')->store('checksheet-hydrant-outdoor');
        }

        if ($request->file('photo_pilar')) {
            if ($request->oldImage_pilar) {
                Storage::delete($request->oldImage_pilar);
            }
            $validatedData['photo_pilar'] = $request->file('photo_pilar')->store('checksheet-hydrant-outdoor');
        }

        if ($request->file('photo_penutup')) {
            if ($request->oldImage_penutup) {
                Storage::delete($request->oldImage_penutup);
            }
            $validatedData['photo_penutup'] = $request->file('photo_penutup')->store('checksheet-hydrant-outdoor');
        }

        if ($request->file('photo_rantai')) {
            if ($request->oldImage_rantai) {
                Storage::delete($request->oldImage_rantai);
            }
            $validatedData['photo_rantai'] = $request->file('photo_rantai')->store('checksheet-hydrant-outdoor');
        }

        if ($request->file('photo_kupla')) {
            if ($request->oldImage_kupla) {
                Storage::delete($request->oldImage_kupla);
            }
            $validatedData['photo_kupla'] = $request->file('photo_kupla')->store('checksheet-hydrant-outdoor');
        }

        // Update data CheckSheetoutdoor dengan data baru dari form
        $checkSheetoutdoor->update($validatedData);

        $hydrant = Hydrant::where('no_hydrant', $checkSheetoutdoor->hydrant_number)->first();

        if (!$hydrant) {
            return back()->with('error', 'Hydrant tidak ditemukan.');
        }

        return redirect()->route('hydrant.show', $hydrant->id)->with('success1', 'Data Check Sheet Hydrant Outdoor berhasil diperbarui.');
    }

    public function show($id)
    {
        $checksheet = CheckSheetHydrantOutdoor::findOrFail($id);

        return view('dashboard.hydrant.checksheet.show', compact('checksheet'));
    }

    public function destroy($id)
    {
        $checkSheetoutdoor = CheckSheetHydrantOutdoor::find($id);

        if ($checkSheetoutdoor->photo_pintu || $checkSheetoutdoor->photo_nozzle || $checkSheetoutdoor->photo_selang || $checkSheetoutdoor->photo_tuas || $checkSheetoutdoor->photo_pilar || $checkSheetoutdoor->photo_penutup || $checkSheetoutdoor->photo_rantai || $checkSheetoutdoor->photo_kupla) {
            Storage::delete($checkSheetoutdoor->photo_pintu);
            Storage::delete($checkSheetoutdoor->photo_nozzle);
            Storage::delete($checkSheetoutdoor->photo_selang);
            Storage::delete($checkSheetoutdoor->photo_tuas);
            Storage::delete($checkSheetoutdoor->photo_pilar);
            Storage::delete($checkSheetoutdoor->photo_penutup);
            Storage::delete($checkSheetoutdoor->photo_rantai);
            Storage::delete($checkSheetoutdoor->photo_kupla);
        }

        $checkSheetoutdoor->delete();

        return back()->with('success1', 'Data Check Sheet Hydrant Outdoor berhasil dihapus');
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-outdoor.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $hydrantNumber = $request->input('hydrant_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetHydrantOutdoor::with('hydrants')
            ->select('tanggal_pengecekan', 'hydrant_number', 'pintu', 'nozzle', 'selang', 'tuas', 'pilar', 'penutup', 'rantai', 'kupla')
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
            if ($item->nozzle === 'OK') {
                $worksheet->setCellValue($col . 10, '√');
            } else if ($item->nozzle === 'NG') {
                $worksheet->setCellValue($col . 10, 'X');
            }

            // Set value based on $item->corong
            if ($item->selang === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->selang === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->tabung
            if ($item->tuas === 'OK') {
                $worksheet->setCellValue($col . 14, '√');
            } else if ($item->tuas === 'NG') {
                $worksheet->setCellValue($col . 14, 'X');
            }

            // Set value based on $item->regulator
            if ($item->pilar === 'OK') {
                $worksheet->setCellValue($col . 16, '√');
            } else if ($item->pilar === 'NG') {
                $worksheet->setCellValue($col . 16, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->penutup === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->penutup === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->rantai === 'OK') {
                $worksheet->setCellValue($col . 20, '√');
            } else if ($item->rantai === 'NG') {
                $worksheet->setCellValue($col . 20, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->kupla === 'OK') {
                $worksheet->setCellValue($col . 22, '√');
            } else if ($item->kupla === 'NG') {
                $worksheet->setCellValue($col . 22, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-outdoor.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
