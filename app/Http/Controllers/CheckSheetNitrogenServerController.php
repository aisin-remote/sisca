<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetNitrogenServer;
use App\Models\Nitrogen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetNitrogenServerController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetNitrogens = CheckSheetNitrogenServer::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.nitrogen.checksheet.check', compact('latestCheckSheetNitrogens'));
    }

    public function processForm(Request $request)
    {
        $nitrogenNumber = $request->input('tabung_number');

        $nitrogenNumber = strtoupper($nitrogenNumber);

        $nitrogen = Nitrogen::where('no_tabung', $nitrogenNumber)->first();

        if (!$nitrogen) {
            return back()->with('error', 'Nitrogen Number tidak ditemukan.');
        }

        return redirect()->route('checksheetnitrogen', compact('nitrogenNumber'));
    }

    public function createForm($tabungNumber)
    {
        $latestCheckSheetNitrogens = CheckSheetNitrogenServer::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $nitrogen = Nitrogen::where('no_tabung', $tabungNumber)->first();

        if (!$nitrogen) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('nitrogen.show.form', compact('latestCheckSheetNitrogens'))->with('error', 'Tabung Number tidak ditemukan.');
        }

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetNitrogenServer::where('tabung_number', $tabungNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        $tabungNumber = strtoupper($tabungNumber);

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('nitrogen.checksheetnitrogen.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Nitrogen sudah ada untuk Nitrogen ' . $tabungNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetNitrogens = CheckSheetNitrogenServer::all();
            return view('dashboard.nitrogen.checksheet.checkNitrogen', compact('checkSheetNitrogens', 'tabungNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetNitrogenServer::where('tabung_number', $request->tabung_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tabung_number' => 'required',
                'operasional' => 'required',
                'catatan_operasional' => 'nullable|string|max:255',
                'photo_operasional' => 'required|image|file|max:3072',
                'selector_mode' => 'required',
                'catatan_selector_mode' => 'nullable|string|max:255',
                'photo_selector_mode' => 'required|image|file|max:3072',
                'pintu_tabung' => 'required',
                'catatan_pintu_tabung' => 'nullable|string|max:255',
                'photo_pintu_tabung' => 'required|image|file|max:3072',
                'pressure_pilot' => 'required',
                'catatan_pressure_pilot' => 'nullable|string|max:255',
                'photo_pressure_pilot' => 'required|image|file|max:3072',
                'pressure_no1' => 'required',
                'catatan_pressure_no1' => 'nullable|string|max:255',
                'photo_pressure_no1' => 'required|image|file|max:3072',
                'pressure_no2' => 'required',
                'catatan_pressure_no2' => 'nullable|string|max:255',
                'photo_pressure_no2' => 'required|image|file|max:3072',
                'pressure_no3' => 'required',
                'catatan_pressure_no3' => 'nullable|string|max:255',
                'photo_pressure_no3' => 'required|image|file|max:3072',
                'pressure_no4' => 'required',
                'catatan_pressure_no4' => 'nullable|string|max:255',
                'photo_pressure_no4' => 'required|image|file|max:3072',
                'pressure_no5' => 'required',
                'catatan_pressure_no5' => 'nullable|string|max:255',
                'photo_pressure_no5' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['tabung_number'] = strtoupper($validatedData['tabung_number']);

            if ($request->file('photo_operasional') && $request->file('photo_selector_mode') && $request->file('photo_pintu_tabung') && $request->file('photo_pressure_pilot') && $request->file('photo_pressure_no1') && $request->file('photo_pressure_no2') && $request->file('photo_pressure_no3') && $request->file('photo_pressure_no4') && $request->file('photo_pressure_no5')) {
                $validatedData['photo_operasional'] = $request->file('photo_operasional')->store('checksheet-nitrogen');
                $validatedData['photo_selector_mode'] = $request->file('photo_selector_mode')->store('checksheet-nitrogen');
                $validatedData['photo_pintu_tabung'] = $request->file('photo_pintu_tabung')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_pilot'] = $request->file('photo_pressure_pilot')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no1'] = $request->file('photo_pressure_no1')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no2'] = $request->file('photo_pressure_no2')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no3'] = $request->file('photo_pressure_no3')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no4'] = $request->file('photo_pressure_no4')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no5'] = $request->file('photo_pressure_no5')->store('checksheet-nitrogen');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('nitrogen.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tabung_number' => 'required',
                'operasional' => 'required',
                'catatan_operasional' => 'nullable|string|max:255',
                'photo_operasional' => 'required|image|file|max:3072',
                'selector_mode' => 'required',
                'catatan_selector_mode' => 'nullable|string|max:255',
                'photo_selector_mode' => 'required|image|file|max:3072',
                'pintu_tabung' => 'required',
                'catatan_pintu_tabung' => 'nullable|string|max:255',
                'photo_pintu_tabung' => 'required|image|file|max:3072',
                'pressure_pilot' => 'required',
                'catatan_pressure_pilot' => 'nullable|string|max:255',
                'photo_pressure_pilot' => 'required|image|file|max:3072',
                'pressure_no1' => 'required',
                'catatan_pressure_no1' => 'nullable|string|max:255',
                'photo_pressure_no1' => 'required|image|file|max:3072',
                'pressure_no2' => 'required',
                'catatan_pressure_no2' => 'nullable|string|max:255',
                'photo_pressure_no2' => 'required|image|file|max:3072',
                'pressure_no3' => 'required',
                'catatan_pressure_no3' => 'nullable|string|max:255',
                'photo_pressure_no3' => 'required|image|file|max:3072',
                'pressure_no4' => 'required',
                'catatan_pressure_no4' => 'nullable|string|max:255',
                'photo_pressure_no4' => 'required|image|file|max:3072',
                'pressure_no5' => 'required',
                'catatan_pressure_no5' => 'nullable|string|max:255',
                'photo_pressure_no5' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['tabung_number'] = strtoupper($validatedData['tabung_number']);

            if ($request->file('photo_operasional') && $request->file('photo_selector_mode') && $request->file('photo_pintu_tabung') && $request->file('photo_pressure_pilot') && $request->file('photo_pressure_no1') && $request->file('photo_pressure_no2') && $request->file('photo_pressure_no3') && $request->file('photo_pressure_no4') && $request->file('photo_pressure_no5')) {
                $validatedData['photo_operasional'] = $request->file('photo_operasional')->store('checksheet-nitrogen');
                $validatedData['photo_selector_mode'] = $request->file('photo_selector_mode')->store('checksheet-nitrogen');
                $validatedData['photo_pintu_tabung'] = $request->file('photo_pintu_tabung')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_pilot'] = $request->file('photo_pressure_pilot')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no1'] = $request->file('photo_pressure_no1')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no2'] = $request->file('photo_pressure_no2')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no3'] = $request->file('photo_pressure_no3')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no4'] = $request->file('photo_pressure_no4')->store('checksheet-nitrogen');
                $validatedData['photo_pressure_no5'] = $request->file('photo_pressure_no5')->store('checksheet-nitrogen');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetNitrogenServer::create($validatedData);

            return redirect()->route('nitrogen.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetNitrogenServer::findOrFail($id);

        return view('dashboard.nitrogen.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheetnitrogen = CheckSheetNitrogenServer::findOrFail($id);
        return view('dashboard.nitrogen.checksheet.edit', compact('checkSheetnitrogen'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetnitrogen = CheckSheetNitrogenServer::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'operasional' => 'required',
            'catatan_operasional' => 'nullable|string|max:255',
            'photo_operasional' => 'image|file|max:3072',
            'selector_mode' => 'required',
            'catatan_selector_mode' => 'nullable|string|max:255',
            'photo_selector_mode' => 'image|file|max:3072',
            'pintu_tabung' => 'required',
            'catatan_pintu_tabung' => 'nullable|string|max:255',
            'photo_pintu_tabung' => 'image|file|max:3072',
            'pressure_pilot' => 'required',
            'catatan_pressure_pilot' => 'nullable|string|max:255',
            'photo_pressure_pilot' => 'image|file|max:3072',
            'pressure_no1' => 'required',
            'catatan_pressure_no1' => 'nullable|string|max:255',
            'photo_pressure_no1' => 'image|file|max:3072',
            'pressure_no2' => 'required',
            'catatan_pressure_no2' => 'nullable|string|max:255',
            'photo_pressure_no2' => 'image|file|max:3072',
            'pressure_no3' => 'required',
            'catatan_pressure_no3' => 'nullable|string|max:255',
            'photo_pressure_no3' => 'image|file|max:3072',
            'pressure_no4' => 'required',
            'catatan_pressure_no4' => 'nullable|string|max:255',
            'photo_pressure_no4' => 'image|file|max:3072',
            'pressure_no5' => 'required',
            'catatan_pressure_no5' => 'nullable|string|max:255',
            'photo_pressure_no5' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_operasional')) {
            if ($request->oldImage_operasional) {
                Storage::delete($request->oldImage_operasional);
            }
            $validatedData['photo_operasional'] = $request->file('photo_operasional')->store('checksheet-nitrogen');
        }

        if ($request->file('photo_selector_mode')) {
            if ($request->oldImage_selector_mode) {
                Storage::delete($request->oldImage_selector_mode);
            }
            $validatedData['photo_selector_mode'] = $request->file('photo_selector_mode')->store('checksheet-nitrogen');
        }

        if ($request->file('photo_pintu_tabung')) {
            if ($request->oldImage_pintu_tabung) {
                Storage::delete($request->oldImage_pintu_tabung);
            }
            $validatedData['photo_pintu_tabung'] = $request->file('photo_pintu_tabung')->store('checksheet-nitrogen');
        }

        if ($request->file('photo_pressure_pilot')) {
            if ($request->oldImage_pressure_pilot) {
                Storage::delete($request->oldImage_pressure_pilot);
            }
            $validatedData['photo_pressure_pilot'] = $request->file('photo_pressure_pilot')->store('checksheet-nitrogen');
        }

        if ($request->file('photo_pressure_no1')) {
            if ($request->oldImage_pressure_no1) {
                Storage::delete($request->oldImage_pressure_no1);
            }
            $validatedData['photo_pressure_no1'] = $request->file('photo_pressure_no1')->store('checksheet-nitrogen');
        }

        if ($request->file('photo_pressure_no2')) {
            if ($request->oldImage_pressure_no2) {
                Storage::delete($request->oldImage_pressure_no2);
            }
            $validatedData['photo_pressure_no2'] = $request->file('photo_pressure_no2')->store('checksheet-nitrogen');
        }

        if ($request->file('photo_pressure_no3')) {
            if ($request->oldImage_pressure_no3) {
                Storage::delete($request->oldImage_pressure_no3);
            }
            $validatedData['photo_pressure_no3'] = $request->file('photo_pressure_no3')->store('checksheet-nitrogen');
        }

        if ($request->file('photo_pressure_no4')) {
            if ($request->oldImage_pressure_no4) {
                Storage::delete($request->oldImage_pressure_no4);
            }
            $validatedData['photo_pressure_no4'] = $request->file('photo_pressure_no4')->store('checksheet-nitrogen');
        }

        if ($request->file('photo_pressure_no5')) {
            if ($request->oldImage_pressure_no5) {
                Storage::delete($request->oldImage_pressure_no5);
            }
            $validatedData['photo_pressure_no5'] = $request->file('photo_pressure_no5')->store('checksheet-nitrogen');
        }

        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheetnitrogen->update($validatedData);

        $nitrogen = Nitrogen::where('no_tabung', $checkSheetnitrogen->tabung_number)->first();

        if (!$nitrogen) {
            return back()->with('error', 'Nitrogen tidak ditemukan.');
        }

        return redirect()->route('nitrogen.show', $nitrogen->id)->with('success1', 'Data Check Sheet Nitrogen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheetnitrogen = CheckSheetNitrogenServer::find($id);

        if ($checkSheetnitrogen->photo_operasional || $checkSheetnitrogen->photo_selector_mode || $checkSheetnitrogen->photo_pintu_tabung || $checkSheetnitrogen->photo_pressure_pilot || $checkSheetnitrogen->photo_pressure_no1 || $checkSheetnitrogen->photo_pressure_no2 || $checkSheetnitrogen->photo_pressure_no3 || $checkSheetnitrogen->photo_pressure_no4 || $checkSheetnitrogen->photo_pressure_no5) {
            Storage::delete($checkSheetnitrogen->photo_operasional);
            Storage::delete($checkSheetnitrogen->photo_selector_mode);
            Storage::delete($checkSheetnitrogen->photo_pintu_tabung);
            Storage::delete($checkSheetnitrogen->photo_pressure_pilot);
            Storage::delete($checkSheetnitrogen->photo_pressure_no1);
            Storage::delete($checkSheetnitrogen->photo_pressure_no2);
            Storage::delete($checkSheetnitrogen->photo_pressure_no3);
            Storage::delete($checkSheetnitrogen->photo_pressure_no3);
            Storage::delete($checkSheetnitrogen->photo_pressure_no3);
        }

        $checkSheetnitrogen->delete();

        return back()->with('success1', 'Data Check Sheet Nitrogen berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheetnitrogen = CheckSheetNitrogenServer::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.nitrogen.checksheet.index', compact('checksheetnitrogen'));
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-nitrogen.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $tabungNumber = $request->input('tabung_number');


        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetNitrogenServer::with('nitrogens')
            ->select('tanggal_pengecekan', 'tabung_number', 'operasional', 'selector_mode', 'pintu_tabung', 'pressure_pilot', 'pressure_no1', 'pressure_no2', 'pressure_no3', 'pressure_no4', 'pressure_no5')
            ->whereYear('tanggal_pengecekan', $selectedYear)
            ->where('tabung_number', $tabungNumber) // Gunakan nilai tag_number yang diambil dari form
            ->get();

        // Array asosiatif untuk mencocokkan nama bulan dengan kolom
        $bulanKolom = [
            1 => 'G',  // Januari -> Kolom H
            2 => 'H',  // Februari -> Kolom I
            3 => 'I',  // Maret -> Kolom J
            4 => 'J',  // April -> Kolom K
            5 => 'K',  // Mei -> Kolom L
            6 => 'L',  // Juni -> Kolom M
            7 => 'M',  // Juli -> Kolom N
            8 => 'N',  // Agustus -> Kolom O
            9 => 'O',  // September -> Kolom P
            10 => 'P', // Oktober -> Kolom Q
            11 => 'Q', // November -> Kolom R
            12 => 'R', // Desember -> Kolom S
        ];

        $worksheet->setCellValue('Q' . 1, ': ' . $data[0]->tabung_number);
        $worksheet->setCellValue('Q' . 2, ': ' . $data[0]->nitrogens->locations->location_name);
        $worksheet->setCellValue('Q' . 3, ': ' . $data[0]->nitrogens->plant);


        foreach ($data as $item) {

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $bulan = Carbon::parse($item->tanggal_pengecekan)->format('n');

            // Tentukan kolom berdasarkan bulan
            $col = $bulanKolom[$bulan];

            // Set value based on $item->pressure
            if ($item->operasional === 'OK') {
                $worksheet->setCellValue($col . 8, '√');
            } else if ($item->operasional === 'NG') {
                $worksheet->setCellValue($col . 8, 'X');
            }

            // Set value based on $item->hose
            if ($item->selector_mode === 'OK') {
                $worksheet->setCellValue($col . 10, '√');
            } else if ($item->selector_mode === 'NG') {
                $worksheet->setCellValue($col . 10, 'X');
            }

            // Set value based on $item->corong
            if ($item->pintu_tabung === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->pintu_tabung === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->tabung
            if ($item->pressure_pilot === 'OK') {
                $worksheet->setCellValue($col . 14, '√');
            } else if ($item->pressure_pilot === 'NG') {
                $worksheet->setCellValue($col . 14, 'X');
            }

            // Set value based on $item->regulator
            if ($item->pressure_no1 === 'OK') {
                $worksheet->setCellValue($col . 16, '√');
            } else if ($item->pressure_no1 === 'NG') {
                $worksheet->setCellValue($col . 16, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->pressure_no2 === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->pressure_no2 === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->pressure_no3 === 'OK') {
                $worksheet->setCellValue($col . 20, '√');
            } else if ($item->pressure_no3 === 'NG') {
                $worksheet->setCellValue($col . 20, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->pressure_no4 === 'OK') {
                $worksheet->setCellValue($col . 22, '√');
            } else if ($item->pressure_no4 === 'NG') {
                $worksheet->setCellValue($col . 22, 'X');
            }

            // Set value based on $item->berat_tabung
            if ($item->pressure_no5 === 'OK') {
                $worksheet->setCellValue($col . 24, '√');
            } else if ($item->pressure_no5 === 'NG') {
                $worksheet->setCellValue($col . 24, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-nitrogen.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $nitrogenData = Nitrogen::leftJoin('tm_locations', 'tm_nitrogens.location_id', '=', 'tm_locations.id')
            ->leftJoin('tt_check_sheet_nitrogen_servers', 'tm_nitrogens.no_tabung', '=', 'tt_check_sheet_nitrogen_servers.tabung_number')
            ->select(
                'tm_nitrogens.no_tabung as tabung_number',
                'tm_nitrogens.plant',
                'tm_locations.location_name',
                'tt_check_sheet_nitrogen_servers.tanggal_pengecekan',
                'tt_check_sheet_nitrogen_servers.operasional',
                'tt_check_sheet_nitrogen_servers.selector_mode',
                'tt_check_sheet_nitrogen_servers.pintu_tabung',
                'tt_check_sheet_nitrogen_servers.pressure_pilot',
                'tt_check_sheet_nitrogen_servers.pressure_no1',
                'tt_check_sheet_nitrogen_servers.pressure_no2',
                'tt_check_sheet_nitrogen_servers.pressure_no3',
                'tt_check_sheet_nitrogen_servers.pressure_no4',
                'tt_check_sheet_nitrogen_servers.pressure_no5',
            )
            ->get();

        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredNitrogenData = $nitrogenData->filter(function ($nitrogen) use ($selectedYear) {
            return $nitrogen->tanggal_pengecekan !== null &&
                date('Y', strtotime($nitrogen->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedNitrogenData = $filteredNitrogenData->groupBy('tabung_number')->map(function ($nitrogenGroup) {
            $nitrogenNumber = $nitrogenGroup[0]['tabung_number'];
            $location_name = $nitrogenGroup[0]['location_name'];
            $nitrogenPlant = $nitrogenGroup[0]['plant'];
            $nitrogenPengecekan = $nitrogenGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($nitrogenGroup as $nitrogen) {
                $month = date('n', strtotime($nitrogen['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($nitrogen['operasional'] === 'NG') $issueCodes[] = 'a';
                if ($nitrogen['selector_mode'] === 'NG') $issueCodes[] = 'b';
                if ($nitrogen['pintu_tabung'] === 'NG') $issueCodes[] = 'c';
                if ($nitrogen['pressure_pilot'] === 'NG') $issueCodes[] = 'd';
                if ($nitrogen['pressure_no1'] === 'NG') $issueCodes[] = 'e';
                if ($nitrogen['pressure_no2'] === 'NG') $issueCodes[] = 'f';
                if ($nitrogen['pressure_no3'] === 'NG') $issueCodes[] = 'g';
                if ($nitrogen['pressure_no4'] === 'NG') $issueCodes[] = 'h';
                if ($nitrogen['pressure_no5'] === 'NG') $issueCodes[] = 'i';


                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }

                $months[$month] = $issueCodes;
            }

            return [
                'tabung_number' => $nitrogenNumber,
                'location_name' => $location_name,
                'plant' => $nitrogenPlant,
                'tanggal_pengecekan' => $nitrogenPengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedNitrogenData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('nitrogen_data.json', $jsonString);

        return view('dashboard.nitrogen_report', [
            'nitrogenData' => $mappedNitrogenData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
