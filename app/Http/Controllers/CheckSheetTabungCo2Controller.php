<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetTabungCo2;
use App\Models\Co2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetTabungCo2Controller extends Controller
{
    public function showForm()
    {
        $latestCheckSheetTabungCo2s = CheckSheetTabungCo2::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.co2.checksheet.check', compact('latestCheckSheetTabungCo2s'));
    }

    public function processForm(Request $request)
    {
        $co2Number = $request->input('tabung_number');

        $co2 = Co2::where('no_tabung', $co2Number)->first();

        if (!$co2) {
            return back()->with('error', 'Co2 Number tidak ditemukan.');
        }

        $co2Number = strtoupper($co2Number);

        return redirect()->route('checksheettabungco2', compact('co2Number'));
    }

    public function createForm($tabungNumber)
    {
        $latestCheckSheetTabungCo2s = CheckSheetTabungCo2::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $co2 = Co2::where('no_tabung', $tabungNumber)->first();

        if (!$co2) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('co2.show.form', compact('latestCheckSheetTabungCo2s'))->with('error', 'Co2 Number tidak ditemukan.');
        }

        $tabungNumber = strtoupper($tabungNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTabungCo2::where('tabung_number', $tabungNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('co2.checksheetco2.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Co2 sudah ada untuk Co2 ' . $tabungNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetTabungCo2s = CheckSheetTabungCo2::all();
            return view('dashboard.co2.checksheet.checkCo2', compact('checkSheetTabungCo2s', 'tabungNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTabungCo2::where('tabung_number', $request->tabung_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tabung_number' => 'required',
                'cover' => 'required',
                'catatan_cover' => 'nullable|string|max:255',
                'photo_cover' => 'required|image|file|max:3072',
                'tabung' => 'required',
                'catatan_tabung' => 'nullable|string|max:255',
                'photo_tabung' => 'required|image|file|max:3072',
                'lock_pin' => 'required',
                'catatan_lock_pin' => 'nullable|string|max:255',
                'photo_lock_pin' => 'required|image|file|max:3072',
                'segel_lock_pin' => 'required',
                'catatan_segel_lock_pin' => 'nullable|string|max:255',
                'photo_segel_lock_pin' => 'required|image|file|max:3072',
                'kebocoran_regulator_tabung' => 'required',
                'catatan_kebocoran_regulator_tabung' => 'nullable|string|max:255',
                'photo_kebocoran_regulator_tabung' => 'required|image|file|max:3072',
                'selang' => 'required',
                'catatan_selang' => 'nullable|string|max:255',
                'photo_selang' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_cover') && $request->file('photo_tabung') && $request->file('photo_lock_pin') && $request->file('photo_segel_lock_pin') && $request->file('photo_kebocoran_regulator_tabung') && $request->file('photo_selang')) {
                $validatedData['photo_cover'] = $request->file('photo_cover')->store('checksheet-tabung-co2');
                $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-tabung-co2');
                $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-tabung-co2');
                $validatedData['photo_segel_lock_pin'] = $request->file('photo_segel_lock_pin')->store('checksheet-tabung-co2');
                $validatedData['photo_kebocoran_regulator_tabung'] = $request->file('photo_kebocoran_regulator_tabung')->store('checksheet-tabung-co2');
                $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-tabung-co2');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('co2.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tabung_number' => 'required',
                'cover' => 'required',
                'catatan_cover' => 'nullable|string|max:255',
                'photo_cover' => 'required|image|file|max:3072',
                'tabung' => 'required',
                'catatan_tabung' => 'nullable|string|max:255',
                'photo_tabung' => 'required|image|file|max:3072',
                'lock_pin' => 'required',
                'catatan_lock_pin' => 'nullable|string|max:255',
                'photo_lock_pin' => 'required|image|file|max:3072',
                'segel_lock_pin' => 'required',
                'catatan_segel_lock_pin' => 'nullable|string|max:255',
                'photo_segel_lock_pin' => 'required|image|file|max:3072',
                'kebocoran_regulator_tabung' => 'required',
                'catatan_kebocoran_regulator_tabung' => 'nullable|string|max:255',
                'photo_kebocoran_regulator_tabung' => 'required|image|file|max:3072',
                'selang' => 'required',
                'catatan_selang' => 'nullable|string|max:255',
                'photo_selang' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            if ($request->file('photo_cover') && $request->file('photo_tabung') && $request->file('photo_lock_pin') && $request->file('photo_segel_lock_pin') && $request->file('photo_kebocoran_regulator_tabung') && $request->file('photo_selang')) {
                $validatedData['photo_cover'] = $request->file('photo_cover')->store('checksheet-tabung-co2');
                $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-tabung-co2');
                $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-tabung-co2');
                $validatedData['photo_segel_lock_pin'] = $request->file('photo_segel_lock_pin')->store('checksheet-tabung-co2');
                $validatedData['photo_kebocoran_regulator_tabung'] = $request->file('photo_kebocoran_regulator_tabung')->store('checksheet-tabung-co2');
                $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-tabung-co2');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetTabungCo2::create($validatedData);

            return redirect()->route('co2.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetTabungCo2::findOrFail($id);

        return view('dashboard.co2.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheettabungco2 = CheckSheetTabungCo2::findOrFail($id);
        return view('dashboard.co2.checksheet.edit', compact('checkSheettabungco2'));
    }

    public function update(Request $request, $id)
    {
        $checkSheettabungco2 = CheckSheetTabungCo2::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'cover' => 'required',
            'catatan_cover' => 'nullable|string|max:255',
            'photo_cover' => 'image|file|max:3072',
            'tabung' => 'required',
            'catatan_tabung' => 'nullable|string|max:255',
            'photo_tabung' => 'image|file|max:3072',
            'lock_pin' => 'required',
            'catatan_lock_pin' => 'nullable|string|max:255',
            'photo_lock_pin' => 'image|file|max:3072',
            'segel_lock_pin' => 'required',
            'catatan_segel_lock_pin' => 'nullable|string|max:255',
            'photo_segel_lock_pin' => 'image|file|max:3072',
            'kebocoran_regulator_tabung' => 'required',
            'catatan_kebocoran_regulator_tabung' => 'nullable|string|max:255',
            'photo_kebocoran_regulator_tabung' => 'image|file|max:3072',
            'selang' => 'required',
            'catatan_selang' => 'nullable|string|max:255',
            'photo_selang' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_cover')) {
            if ($request->oldImage_cover) {
                Storage::delete($request->oldImage_cover);
            }
            $validatedData['photo_cover'] = $request->file('photo_cover')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_tabung')) {
            if ($request->oldImage_tabung) {
                Storage::delete($request->oldImage_tabung);
            }
            $validatedData['photo_tabung'] = $request->file('photo_tabung')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_lock_pin')) {
            if ($request->oldImage_lock_pin) {
                Storage::delete($request->oldImage_lock_pin);
            }
            $validatedData['photo_lock_pin'] = $request->file('photo_lock_pin')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_segel_lock_pin')) {
            if ($request->oldImage_segel_lock_pin) {
                Storage::delete($request->oldImage_segel_lock_pin);
            }
            $validatedData['photo_segel_lock_pin'] = $request->file('photo_segel_lock_pin')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_kebocoran_regulator_tabung')) {
            if ($request->oldImage_kebocoran_regulator_tabung) {
                Storage::delete($request->oldImage_kebocoran_regulator_tabung);
            }
            $validatedData['photo_kebocoran_regulator_tabung'] = $request->file('photo_kebocoran_regulator_tabung')->store('checksheet-tabung-co2');
        }

        if ($request->file('photo_selang')) {
            if ($request->oldImage_selang) {
                Storage::delete($request->oldImage_selang);
            }
            $validatedData['photo_selang'] = $request->file('photo_selang')->store('checksheet-tabung-co2');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheettabungco2->update($validatedData);

        $co2 = Co2::where('no_tabung', $checkSheettabungco2->tabung_number)->first();

        if (!$co2) {
            return back()->with('error', 'Co2 tidak ditemukan.');
        }

        return redirect()->route('co2.show', $co2->id)->with('success1', 'Data Check Sheet Co2 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheettabungco2 = CheckSheetTabungCo2::find($id);

        if ($checkSheettabungco2->photo_cover || $checkSheettabungco2->photo_tabung || $checkSheettabungco2->photo_lock_pin || $checkSheettabungco2->photo_segel_lock_pin || $checkSheettabungco2->photo_kebocoran_regulator_tabung || $checkSheettabungco2->photo_selang) {
            Storage::delete($checkSheettabungco2->photo_cover);
            Storage::delete($checkSheettabungco2->photo_tabung);
            Storage::delete($checkSheettabungco2->photo_lock_pin);
            Storage::delete($checkSheettabungco2->photo_segel_lock_pin);
            Storage::delete($checkSheettabungco2->photo_kebocoran_regulator_tabung);
            Storage::delete($checkSheettabungco2->photo_selang);
        }

        $checkSheettabungco2->delete();

        return back()->with('success1', 'Data Check Sheet Co2 berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheettabungco2 = CheckSheetTabungCo2::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.co2.checksheet.index', compact('checksheettabungco2'));
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-tabungco2.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $tabungNumber = $request->input('tabung_number');


        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetTabungCo2::with('co2s')
            ->select('tanggal_pengecekan', 'tabung_number', 'cover', 'tabung', 'lock_pin', 'segel_lock_pin', 'kebocoran_regulator_tabung', 'selang')
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
        $worksheet->setCellValue('Q' . 2, ': ' . $data[0]->co2s->locations->location_name);
        $worksheet->setCellValue('Q' . 3, ': ' . $data[0]->co2s->plant);

        foreach ($data as $item) {

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $bulan = Carbon::parse($item->tanggal_pengecekan)->format('n');

            // Tentukan kolom berdasarkan bulan
            $col = $bulanKolom[$bulan];

            // Set value based on $item->pressure
            if ($item->cover === 'OK') {
                $worksheet->setCellValue($col . 8, '√');
            } else if ($item->cover === 'NG') {
                $worksheet->setCellValue($col . 8, 'X');
            }

            // Set value based on $item->hose
            if ($item->tabung === 'OK') {
                $worksheet->setCellValue($col . 10, '√');
            } else if ($item->tabung === 'NG') {
                $worksheet->setCellValue($col . 10, 'X');
            }

            // Set value based on $item->corong
            if ($item->lock_pin === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->lock_pin === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->tabung
            if ($item->segel_lock_pin === 'OK') {
                $worksheet->setCellValue($col . 14, '√');
            } else if ($item->segel_lock_pin === 'NG') {
                $worksheet->setCellValue($col . 14, 'X');
            }

            // Set value based on $item->regulator
            if ($item->kebocoran_regulator_tabung === 'OK') {
                $worksheet->setCellValue($col . 16, '√');
            } else if ($item->kebocoran_regulator_tabung === 'NG') {
                $worksheet->setCellValue($col . 16, 'X');
            }

            // Set value based on $item->lock_pin
            if ($item->selang === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->selang === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-tabungco2.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
