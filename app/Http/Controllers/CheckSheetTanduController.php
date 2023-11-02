<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetTandu;
use App\Models\Tandu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetTanduController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetTandus = CheckSheetTandu::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.tandu.checksheet.check', compact('latestCheckSheetTandus'));
    }

    public function processForm(Request $request)
    {
        if (auth()->user()->role != 'Admin') {
            return back()->with('error', 'Hanya admin yang dapat melakukan check');
        }

        $tanduNumber = $request->input('tandu_number');

        $tandu = Tandu::where('no_tandu', $tanduNumber)->first();

        if (!$tandu) {
            return back()->with('error', 'Tandu Number tidak ditemukan.');
        }

        $tanduNumber = strtoupper($tanduNumber);

        return redirect()->route('checksheettandu', compact('tanduNumber'));
    }

    public function createForm($tanduNumber)
    {
        $latestCheckSheetTandus = CheckSheetTandu::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $tandu = Tandu::where('no_tandu', $tanduNumber)->first();

        if (!$tandu) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('tandu.show.form', compact('latestCheckSheetTandus'))->with('error', 'Tandu Number tidak ditemukan.');
        }

        $tanduNumber = strtoupper($tanduNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTandu::where('tandu_number', $tanduNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('tandu.checksheettandu.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Tandu sudah ada untuk Tandu ' . $tanduNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetTandus = CheckSheetTandu::all();
            return view('dashboard.tandu.checksheet.checkTandu', compact('checkSheetTandus', 'tanduNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTandu::where('tandu_number', $request->tandu_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tandu_number' => 'required',
                'kunci_pintu' => 'required',
                'catatan_kunci_pintu' => 'nullable|string|max:255',
                'photo_kunci_pintu' => 'required|image|file|max:3072',
                'pintu' => 'required',
                'catatan_pintu' => 'nullable|string|max:255',
                'photo_pintu' => 'required|image|file|max:3072',
                'sign' => 'required',
                'catatan_sign' => 'nullable|string|max:255',
                'photo_sign' => 'required|image|file|max:3072',
                'hand_grip' => 'required',
                'catatan_hand_grip' => 'nullable|string|max:255',
                'photo_hand_grip' => 'required|image|file|max:3072',
                'body' => 'required',
                'catatan_body' => 'nullable|string|max:255',
                'photo_body' => 'required|image|file|max:3072',
                'engsel' => 'required',
                'catatan_engsel' => 'nullable|string|max:255',
                'photo_engsel' => 'required|image|file|max:3072',
                'kaki' => 'required',
                'catatan_kaki' => 'nullable|string|max:255',
                'photo_kaki' => 'required|image|file|max:3072',
                'belt' => 'required',
                'catatan_belt' => 'nullable|string|max:255',
                'photo_belt' => 'required|image|file|max:3072',
                'rangka' => 'required',
                'catatan_rangka' => 'nullable|string|max:255',
                'photo_rangka' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['tandu_number'] = strtoupper($validatedData['tandu_number']);

            if ($request->file('photo_kunci_pintu') && $request->file('photo_pintu') && $request->file('photo_sign') && $request->file('photo_hand_grip') && $request->file('photo_body') && $request->file('photo_engsel') && $request->file('photo_kaki') && $request->file('photo_belt') && $request->file('photo_rangka')) {
                $validatedData['photo_kunci_pintu'] = $request->file('photo_kunci_pintu')->store('checksheet-tandu');
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-tandu');
                $validatedData['photo_sign'] = $request->file('photo_sign')->store('checksheet-tandu');
                $validatedData['photo_hand_grip'] = $request->file('photo_hand_grip')->store('checksheet-tandu');
                $validatedData['photo_body'] = $request->file('photo_body')->store('checksheet-tandu');
                $validatedData['photo_engsel'] = $request->file('photo_engsel')->store('checksheet-tandu');
                $validatedData['photo_kaki'] = $request->file('photo_kaki')->store('checksheet-tandu');
                $validatedData['photo_belt'] = $request->file('photo_belt')->store('checksheet-tandu');
                $validatedData['photo_rangka'] = $request->file('photo_rangka')->store('checksheet-tandu');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('tandu.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tandu_number' => 'required',
                'kunci_pintu' => 'required',
                'catatan_kunci_pintu' => 'nullable|string|max:255',
                'photo_kunci_pintu' => 'required|image|file|max:3072',
                'pintu' => 'required',
                'catatan_pintu' => 'nullable|string|max:255',
                'photo_pintu' => 'required|image|file|max:3072',
                'sign' => 'required',
                'catatan_sign' => 'nullable|string|max:255',
                'photo_sign' => 'required|image|file|max:3072',
                'hand_grip' => 'required',
                'catatan_hand_grip' => 'nullable|string|max:255',
                'photo_hand_grip' => 'required|image|file|max:3072',
                'body' => 'required',
                'catatan_body' => 'nullable|string|max:255',
                'photo_body' => 'required|image|file|max:3072',
                'engsel' => 'required',
                'catatan_engsel' => 'nullable|string|max:255',
                'photo_engsel' => 'required|image|file|max:3072',
                'kaki' => 'required',
                'catatan_kaki' => 'nullable|string|max:255',
                'photo_kaki' => 'required|image|file|max:3072',
                'belt' => 'required',
                'catatan_belt' => 'nullable|string|max:255',
                'photo_belt' => 'required|image|file|max:3072',
                'rangka' => 'required',
                'catatan_rangka' => 'nullable|string|max:255',
                'photo_rangka' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['tandu_number'] = strtoupper($validatedData['tandu_number']);

            if ($request->file('photo_kunci_pintu') && $request->file('photo_pintu') && $request->file('photo_sign') && $request->file('photo_hand_grip') && $request->file('photo_body') && $request->file('photo_engsel') && $request->file('photo_kaki') && $request->file('photo_belt') && $request->file('photo_rangka')) {
                $validatedData['photo_kunci_pintu'] = $request->file('photo_kunci_pintu')->store('checksheet-tandu');
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-tandu');
                $validatedData['photo_sign'] = $request->file('photo_sign')->store('checksheet-tandu');
                $validatedData['photo_hand_grip'] = $request->file('photo_hand_grip')->store('checksheet-tandu');
                $validatedData['photo_body'] = $request->file('photo_body')->store('checksheet-tandu');
                $validatedData['photo_engsel'] = $request->file('photo_engsel')->store('checksheet-tandu');
                $validatedData['photo_kaki'] = $request->file('photo_kaki')->store('checksheet-tandu');
                $validatedData['photo_belt'] = $request->file('photo_belt')->store('checksheet-tandu');
                $validatedData['photo_rangka'] = $request->file('photo_rangka')->store('checksheet-tandu');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetTandu::create($validatedData);

            return redirect()->route('tandu.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetTandu::findOrFail($id);

        return view('dashboard.tandu.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheettandu = CheckSheetTandu::findOrFail($id);
        return view('dashboard.tandu.checksheet.edit', compact('checkSheettandu'));
    }

    public function update(Request $request, $id)
    {
        $checkSheettandu = CheckSheetTandu::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'kunci_pintu' => 'required',
            'catatan_kunci_pintu' => 'nullable|string|max:255',
            'photo_kunci_pintu' => 'image|file|max:3072',
            'pintu' => 'required',
            'catatan_pintu' => 'nullable|string|max:255',
            'photo_pintu' => 'image|file|max:3072',
            'sign' => 'required',
            'catatan_sign' => 'nullable|string|max:255',
            'photo_sign' => 'image|file|max:3072',
            'hand_grip' => 'required',
            'catatan_hand_grip' => 'nullable|string|max:255',
            'photo_hand_grip' => 'image|file|max:3072',
            'body' => 'required',
            'catatan_body' => 'nullable|string|max:255',
            'photo_body' => 'image|file|max:3072',
            'engsel' => 'required',
            'catatan_engsel' => 'nullable|string|max:255',
            'photo_engsel' => 'image|file|max:3072',
            'kaki' => 'required',
            'catatan_kaki' => 'nullable|string|max:255',
            'photo_kaki' => 'image|file|max:3072',
            'belt' => 'required',
            'catatan_belt' => 'nullable|string|max:255',
            'photo_belt' => 'image|file|max:3072',
            'rangka' => 'required',
            'catatan_rangka' => 'nullable|string|max:255',
            'photo_rangka' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_kunci_pintu')) {
            if ($request->oldImage_kunci_pintu) {
                Storage::delete($request->oldImage_kunci_pintu);
            }
            $validatedData['photo_kunci_pintu'] = $request->file('photo_kunci_pintu')->store('checksheet-tandu');
        }

        if ($request->file('photo_pintu')) {
            if ($request->oldImage_pintu) {
                Storage::delete($request->oldImage_pintu);
            }
            $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-tandu');
        }

        if ($request->file('photo_sign')) {
            if ($request->oldImage_sign) {
                Storage::delete($request->oldImage_sign);
            }
            $validatedData['photo_sign'] = $request->file('photo_sign')->store('checksheet-tandu');
        }

        if ($request->file('photo_hand_grip')) {
            if ($request->oldImage_hand_grip) {
                Storage::delete($request->oldImage_hand_grip);
            }
            $validatedData['photo_hand_grip'] = $request->file('photo_hand_grip')->store('checksheet-tandu');
        }

        if ($request->file('photo_body')) {
            if ($request->oldImage_body) {
                Storage::delete($request->oldImage_body);
            }
            $validatedData['photo_body'] = $request->file('photo_body')->store('checksheet-tandu');
        }

        if ($request->file('photo_engsel')) {
            if ($request->oldImage_engsel) {
                Storage::delete($request->oldImage_engsel);
            }
            $validatedData['photo_engsel'] = $request->file('photo_engsel')->store('checksheet-tandu');
        }

        if ($request->file('photo_kaki')) {
            if ($request->oldImage_kaki) {
                Storage::delete($request->oldImage_kaki);
            }
            $validatedData['photo_kaki'] = $request->file('photo_kaki')->store('checksheet-tandu');
        }

        if ($request->file('photo_belt')) {
            if ($request->oldImage_belt) {
                Storage::delete($request->oldImage_belt);
            }
            $validatedData['photo_belt'] = $request->file('photo_belt')->store('checksheet-tandu');
        }

        if ($request->file('photo_rangka')) {
            if ($request->oldImage_rangka) {
                Storage::delete($request->oldImage_rangka);
            }
            $validatedData['photo_rangka'] = $request->file('photo_rangka')->store('checksheet-tandu');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheettandu->update($validatedData);

        $tandu = Tandu::where('no_tandu', $checkSheettandu->tandu_number)->first();

        if (!$tandu) {
            return back()->with('error', 'Tandu tidak ditemukan.');
        }

        return redirect()->route('tandu.show', $tandu->id)->with('success1', 'Data Check Sheet Tandu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheettandu = CheckSheetTandu::find($id);

        if ($checkSheettandu->photo_kunci_pintu || $checkSheettandu->photo_pintu || $checkSheettandu->photo_sign || $checkSheettandu->photo_hand_grip || $checkSheettandu->photo_body || $checkSheettandu->photo_engsel || $checkSheettandu->photo_kaki || $checkSheettandu->photo_belt || $checkSheettandu->photo_rangka) {
            Storage::delete($checkSheettandu->photo_kunci_pintu);
            Storage::delete($checkSheettandu->photo_pintu);
            Storage::delete($checkSheettandu->photo_sign);
            Storage::delete($checkSheettandu->photo_hand_grip);
            Storage::delete($checkSheettandu->photo_body);
            Storage::delete($checkSheettandu->photo_engsel);
            Storage::delete($checkSheettandu->photo_kaki);
            Storage::delete($checkSheettandu->photo_belt);
            Storage::delete($checkSheettandu->photo_rangka);
        }

        $checkSheettandu->delete();

        return back()->with('success1', 'Data Check Sheet Tandu berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheettandu = CheckSheetTandu::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.tandu.checksheet.index', compact('checksheettandu'));
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-tandu.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $tanduNumber = $request->input('tandu_number');


        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetTandu::with('tandus')
            ->select('tanggal_pengecekan', 'tandu_number', 'kunci_pintu', 'pintu', 'sign', 'hand_grip', 'body', 'engsel', 'kaki', 'belt', 'rangka')
            ->whereYear('tanggal_pengecekan', $selectedYear)
            ->where('tandu_number', $tanduNumber) // Gunakan nilai tag_number yang diambil dari form
            ->get();

        // Array asosiatif untuk mencocokkan nama bulan dengan kolom
        $bulanKolom = [
            1 => 'AK',  // Januari -> Kolom H
            2 => 'AM',  // Februari -> Kolom I
            3 => 'AO',  // Maret -> Kolom J
            4 => 'AQ',  // April -> Kolom K
            5 => 'AS',  // Mei -> Kolom L
            6 => 'AU',  // Juni -> Kolom M
            7 => 'AW',  // Juli -> Kolom N
            8 => 'AY',  // Agustus -> Kolom O
            9 => 'BA',  // September -> Kolom P
            10 => 'BC', // Oktober -> Kolom Q
            11 => 'BE', // November -> Kolom R
            12 => 'BG', // Desember -> Kolom S
        ];

        $worksheet->setCellValue('BF' . 4, $data[0]->tandus->locations->location_name);

        foreach ($data as $item) {

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $bulan = Carbon::parse($item->tanggal_pengecekan)->format('n');

            // Tentukan kolom berdasarkan bulan
            $col = $bulanKolom[$bulan];

            // Set value based on $item->pressure
            if ($item->kunci_pintu === 'OK') {
                $worksheet->setCellValue($col . 8, '√');
            } else if ($item->kunci_pintu === 'NG') {
                $worksheet->setCellValue($col . 8, 'X');
            }

            // Set value based on $item->hose
            if ($item->pintu === 'OK') {
                $worksheet->setCellValue($col . 11, '√');
            } else if ($item->pintu === 'NG') {
                $worksheet->setCellValue($col . 11, 'X');
            }

            // Set value based on $item->corong
            if ($item->sign === 'OK') {
                $worksheet->setCellValue($col . 14, '√');
            } else if ($item->sign === 'NG') {
                $worksheet->setCellValue($col . 14, 'X');
            }

            // Set value based on $item->tabung
            if ($item->hand_grip === 'OK') {
                $worksheet->setCellValue($col . 17, '√');
            } else if ($item->hand_grip === 'NG') {
                $worksheet->setCellValue($col . 17, 'X');
            }

            // Set value based on $item->regulator
            if ($item->body === 'OK') {
                $worksheet->setCellValue($col . 20, '√');
            } else if ($item->body === 'NG') {
                $worksheet->setCellValue($col . 20, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->engsel === 'OK') {
                $worksheet->setCellValue($col . 23, '√');
            } else if ($item->engsel === 'NG') {
                $worksheet->setCellValue($col . 23, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->kaki === 'OK') {
                $worksheet->setCellValue($col . 26, '√');
            } else if ($item->kaki === 'NG') {
                $worksheet->setCellValue($col . 26, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->belt === 'OK') {
                $worksheet->setCellValue($col . 29, '√');
            } else if ($item->belt === 'NG') {
                $worksheet->setCellValue($col . 29, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->rangka === 'OK') {
                $worksheet->setCellValue($col . 32, '√');
            } else if ($item->rangka === 'NG') {
                $worksheet->setCellValue($col . 32, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-tandu.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $tanduData = Tandu::leftJoin('tm_locations', 'tm_tandus.location_id', '=', 'tm_locations.id')
            ->leftJoin('tt_check_sheet_tandus', 'tm_tandus.no_tandu', '=', 'tt_check_sheet_tandus.tandu_number')
            ->select(
                'tm_tandus.no_tandu as tandu_number',
                'tm_locations.location_name',
                'tt_check_sheet_tandus.tanggal_pengecekan',
                'tt_check_sheet_tandus.kunci_pintu',
                'tt_check_sheet_tandus.pintu',
                'tt_check_sheet_tandus.sign',
                'tt_check_sheet_tandus.hand_grip',
                'tt_check_sheet_tandus.body',
                'tt_check_sheet_tandus.engsel',
                'tt_check_sheet_tandus.kaki',
                'tt_check_sheet_tandus.belt',
                'tt_check_sheet_tandus.rangka',
            )->get();

        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredTanduData = $tanduData->filter(function ($tandu) use ($selectedYear) {
            return $tandu->tanggal_pengecekan !== null &&
                date('Y', strtotime($tandu->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedTanduData = $filteredTanduData->groupBy('tandu_number')->map(function ($tanduGroup) {
            $tanduNumber = $tanduGroup[0]['tandu_number'];
            $location_name = $tanduGroup[0]['location_name'];
            $tanduPengecekan = $tanduGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($tanduGroup as $tandu) {
                $month = date('n', strtotime($tandu['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($tandu['kunci_pintu'] === 'NG') $issueCodes[] = 'a';
                if ($tandu['pintu'] === 'NG') $issueCodes[] = 'b';
                if ($tandu['sign'] === 'NG') $issueCodes[] = 'c';
                if ($tandu['hand_grip'] === 'NG') $issueCodes[] = 'd';
                if ($tandu['body'] === 'NG') $issueCodes[] = 'e';
                if ($tandu['engsel'] === 'NG') $issueCodes[] = 'f';
                if ($tandu['kaki'] === 'NG') $issueCodes[] = 'g';
                if ($tandu['belt'] === 'NG') $issueCodes[] = 'h';
                if ($tandu['rangka'] === 'NG') $issueCodes[] = 'i';

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }

                $months[$month] = $issueCodes;
            }

            return [
                'tandu_number' => $tanduNumber,
                'location_name' => $location_name,
                'tanggal_pengecekan' => $tanduPengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedTanduData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('tandu_data.json', $jsonString);

        return view('dashboard.tandu_report', [
            'tanduData' => $mappedTanduData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
