<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetTembin;
use App\Models\Tandu;
use App\Models\Tembin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetTembinController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetTembins = CheckSheetTembin::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.tembin.checksheet.check', compact('latestCheckSheetTembins'));
    }

    public function processForm(Request $request)
    {
        $tembinNumber = $request->input('tembin_number');

        $tembin = Tembin::where('no_equip', $tembinNumber)->first();

        if (!$tembin) {
            return back()->with('error', 'Equip Number tidak ditemukan.');
        }

        $tembinNumber = strtoupper($tembinNumber);

        return redirect()->route('checksheettembin', compact('tembinNumber'));
    }

    public function createForm($tembinNumber)
    {
        $latestCheckSheetTembins = CheckSheetTembin::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $tembin = Tembin::where('no_equip', $tembinNumber)->first();

        if (!$tembin) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('tembin.show.form', compact('latestCheckSheetTembins'))->with('error', 'Equip Number tidak ditemukan.');
        }

        $tembinNumber = strtoupper($tembinNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTembin::where('tembin_number', $tembinNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('tembin.checksheettembin.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Tembin sudah ada untuk Tembin ' . $tembinNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetTembins = CheckSheetTembin::all();
            return view('dashboard.tembin.checksheet.checkTembin', compact('checkSheetTembins', 'tembinNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTembin::where('tembin_number', $request->tembin_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tembin_number' => 'required',
                'master_link' => 'required',
                'catatan_master_link' => 'nullable|string|max:255',
                'photo_master_link' => 'required|image|file|max:3072',
                'body_tembin' => 'required',
                'catatan_body_tembin' => 'nullable|string|max:255',
                'photo_body_tembin' => 'required|image|file|max:3072',
                'mur_baut' => 'required',
                'catatan_mur_baut' => 'nullable|string|max:255',
                'photo_mur_baut' => 'required|image|file|max:3072',
                'shackle' => 'required',
                'catatan_shackle' => 'nullable|string|max:255',
                'photo_shackle' => 'required|image|file|max:3072',
                'hook_atas' => 'required',
                'catatan_hook_atas' => 'nullable|string|max:255',
                'photo_hook_atas' => 'required|image|file|max:3072',
                'pengunci_hook_atas' => 'required',
                'catatan_pengunci_hook_atas' => 'nullable|string|max:255',
                'photo_pengunci_hook_atas' => 'required|image|file|max:3072',
                'mata_chain' => 'required',
                'catatan_mata_chain' => 'nullable|string|max:255',
                'photo_mata_chain' => 'required|image|file|max:3072',
                'chain' => 'required',
                'catatan_chain' => 'nullable|string|max:255',
                'photo_chain' => 'required|image|file|max:3072',
                'hook_bawah' => 'required',
                'catatan_hook_bawah' => 'nullable|string|max:255',
                'photo_hook_bawah' => 'required|image|file|max:3072',
                'pengunci_hook_bawah' => 'required',
                'catatan_pengunci_hook_bawah' => 'nullable|string|max:255',
                'photo_pengunci_hook_bawah' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['tembin_number'] = strtoupper($validatedData['tembin_number']);

            if ($request->file('photo_master_link') && $request->file('photo_body_tembin') && $request->file('photo_mur_baut') && $request->file('photo_shackle') && $request->file('photo_hook_atas') && $request->file('photo_pengunci_hook_atas') && $request->file('photo_mata_chain') && $request->file('photo_chain') && $request->file('photo_hook_bawah') && $request->file('photo_pengunci_hook_bawah')) {
                $validatedData['photo_master_link'] = $request->file('photo_master_link')->store('checksheet-tembin');
                $validatedData['photo_body_tembin'] = $request->file('photo_body_tembin')->store('checksheet-tembin');
                $validatedData['photo_mur_baut'] = $request->file('photo_mur_baut')->store('checksheet-tembin');
                $validatedData['photo_shackle'] = $request->file('photo_shackle')->store('checksheet-tembin');
                $validatedData['photo_hook_atas'] = $request->file('photo_hook_atas')->store('checksheet-tembin');
                $validatedData['photo_pengunci_hook_atas'] = $request->file('photo_pengunci_hook_atas')->store('checksheet-tembin');
                $validatedData['photo_mata_chain'] = $request->file('photo_mata_chain')->store('checksheet-tembin');
                $validatedData['photo_chain'] = $request->file('photo_chain')->store('checksheet-tembin');
                $validatedData['photo_hook_bawah'] = $request->file('photo_hook_bawah')->store('checksheet-tembin');
                $validatedData['photo_pengunci_hook_bawah'] = $request->file('photo_pengunci_hook_bawah')->store('checksheet-tembin');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('tembin.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tembin_number' => 'required',
                'master_link' => 'required',
                'catatan_master_link' => 'nullable|string|max:255',
                'photo_master_link' => 'required|image|file|max:3072',
                'body_tembin' => 'required',
                'catatan_body_tembin' => 'nullable|string|max:255',
                'photo_body_tembin' => 'required|image|file|max:3072',
                'mur_baut' => 'required',
                'catatan_mur_baut' => 'nullable|string|max:255',
                'photo_mur_baut' => 'required|image|file|max:3072',
                'shackle' => 'required',
                'catatan_shackle' => 'nullable|string|max:255',
                'photo_shackle' => 'required|image|file|max:3072',
                'hook_atas' => 'required',
                'catatan_hook_atas' => 'nullable|string|max:255',
                'photo_hook_atas' => 'required|image|file|max:3072',
                'pengunci_hook_atas' => 'required',
                'catatan_pengunci_hook_atas' => 'nullable|string|max:255',
                'photo_pengunci_hook_atas' => 'required|image|file|max:3072',
                'mata_chain' => 'required',
                'catatan_mata_chain' => 'nullable|string|max:255',
                'photo_mata_chain' => 'required|image|file|max:3072',
                'chain' => 'required',
                'catatan_chain' => 'nullable|string|max:255',
                'photo_chain' => 'required|image|file|max:3072',
                'hook_bawah' => 'required',
                'catatan_hook_bawah' => 'nullable|string|max:255',
                'photo_hook_bawah' => 'required|image|file|max:3072',
                'pengunci_hook_bawah' => 'required',
                'catatan_pengunci_hook_bawah' => 'nullable|string|max:255',
                'photo_pengunci_hook_bawah' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['tembin_number'] = strtoupper($validatedData['tembin_number']);

            if ($request->file('photo_master_link') && $request->file('photo_body_tembin') && $request->file('photo_mur_baut') && $request->file('photo_shackle') && $request->file('photo_hook_atas') && $request->file('photo_pengunci_hook_atas') && $request->file('photo_mata_chain') && $request->file('photo_chain') && $request->file('photo_hook_bawah') && $request->file('photo_pengunci_hook_bawah')) {
                $validatedData['photo_master_link'] = $request->file('photo_master_link')->store('checksheet-tembin');
                $validatedData['photo_body_tembin'] = $request->file('photo_body_tembin')->store('checksheet-tembin');
                $validatedData['photo_mur_baut'] = $request->file('photo_mur_baut')->store('checksheet-tembin');
                $validatedData['photo_shackle'] = $request->file('photo_shackle')->store('checksheet-tembin');
                $validatedData['photo_hook_atas'] = $request->file('photo_hook_atas')->store('checksheet-tembin');
                $validatedData['photo_pengunci_hook_atas'] = $request->file('photo_pengunci_hook_atas')->store('checksheet-tembin');
                $validatedData['photo_mata_chain'] = $request->file('photo_mata_chain')->store('checksheet-tembin');
                $validatedData['photo_chain'] = $request->file('photo_chain')->store('checksheet-tembin');
                $validatedData['photo_hook_bawah'] = $request->file('photo_hook_bawah')->store('checksheet-tembin');
                $validatedData['photo_pengunci_hook_bawah'] = $request->file('photo_pengunci_hook_bawah')->store('checksheet-tembin');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetTembin::create($validatedData);

            return redirect()->route('tembin.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetTembin::findOrFail($id);

        return view('dashboard.tembin.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheettembin = CheckSheetTembin::findOrFail($id);
        return view('dashboard.tembin.checksheet.edit', compact('checkSheettembin'));
    }

    public function update(Request $request, $id)
    {
        $checkSheettembin = CheckSheetTembin::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'master_link' => 'required',
            'catatan_master_link' => 'nullable|string|max:255',
            'photo_master_link' => 'image|file|max:3072',
            'body_tembin' => 'required',
            'catatan_body_tembin' => 'nullable|string|max:255',
            'photo_body_tembin' => 'image|file|max:3072',
            'mur_baut' => 'required',
            'catatan_mur_baut' => 'nullable|string|max:255',
            'photo_mur_baut' => 'image|file|max:3072',
            'shackle' => 'required',
            'catatan_shackle' => 'nullable|string|max:255',
            'photo_shackle' => 'image|file|max:3072',
            'hook_atas' => 'required',
            'catatan_hook_atas' => 'nullable|string|max:255',
            'photo_hook_atas' => 'image|file|max:3072',
            'pengunci_hook_atas' => 'required',
            'catatan_pengunci_hook_atas' => 'nullable|string|max:255',
            'photo_pengunci_hook_atas' => 'image|file|max:3072',
            'mata_chain' => 'required',
            'catatan_mata_chain' => 'nullable|string|max:255',
            'photo_mata_chain' => 'image|file|max:3072',
            'chain' => 'required',
            'catatan_chain' => 'nullable|string|max:255',
            'photo_chain' => 'image|file|max:3072',
            'hook_bawah' => 'required',
            'catatan_hook_bawah' => 'nullable|string|max:255',
            'photo_hook_bawah' => 'image|file|max:3072',
            'pengunci_hook_bawah' => 'required',
            'catatan_pengunci_hook_bawah' => 'nullable|string|max:255',
            'photo_pengunci_hook_bawah' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_master_link')) {
            if ($request->oldImage_master_link) {
                Storage::delete($request->oldImage_master_link);
            }
            $validatedData['photo_master_link'] = $request->file('photo_master_link')->store('checksheet-tembin');
        }

        if ($request->file('photo_body_tembin')) {
            if ($request->oldImage_body_tembin) {
                Storage::delete($request->oldImage_body_tembin);
            }
            $validatedData['photo_body_tembin'] = $request->file('photo_body_tembin')->store('checksheet-tembin');
        }

        if ($request->file('photo_mur_baut')) {
            if ($request->oldImage_mur_baut) {
                Storage::delete($request->oldImage_mur_baut);
            }
            $validatedData['photo_mur_baut'] = $request->file('photo_mur_baut')->store('checksheet-tembin');
        }

        if ($request->file('photo_shackle')) {
            if ($request->oldImage_shackle) {
                Storage::delete($request->oldImage_shackle);
            }
            $validatedData['photo_shackle'] = $request->file('photo_shackle')->store('checksheet-tembin');
        }

        if ($request->file('photo_hook_atas')) {
            if ($request->oldImage_hook_atas) {
                Storage::delete($request->oldImage_hook_atas);
            }
            $validatedData['photo_hook_atas'] = $request->file('photo_hook_atas')->store('checksheet-tembin');
        }

        if ($request->file('photo_pengunci_hook_atas')) {
            if ($request->oldImage_pengunci_hook_atas) {
                Storage::delete($request->oldImage_pengunci_hook_atas);
            }
            $validatedData['photo_pengunci_hook_atas'] = $request->file('photo_pengunci_hook_atas')->store('checksheet-tembin');
        }

        if ($request->file('photo_mata_chain')) {
            if ($request->oldImage_mata_chain) {
                Storage::delete($request->oldImage_mata_chain);
            }
            $validatedData['photo_mata_chain'] = $request->file('photo_mata_chain')->store('checksheet-tembin');
        }

        if ($request->file('photo_hook_bawah')) {
            if ($request->oldImage_hook_bawah) {
                Storage::delete($request->oldImage_hook_bawah);
            }
            $validatedData['photo_hook_bawah'] = $request->file('photo_hook_bawah')->store('checksheet-tembin');
        }

        if ($request->file('photo_pengunci_hook_bawah')) {
            if ($request->oldImage_pengunci_hook_bawah) {
                Storage::delete($request->oldImage_pengunci_hook_bawah);
            }
            $validatedData['photo_pengunci_hook_bawah'] = $request->file('photo_pengunci_hook_bawah')->store('checksheet-tembin');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheettembin->update($validatedData);

        $tembin = Tembin::where('no_equip', $checkSheettembin->tembin_number)->first();

        if (!$tembin) {
            return back()->with('error', 'Tembin tidak ditemukan.');
        }

        return redirect()->route('tembin.show', $tembin->id)->with('success1', 'Data Check Sheet Tembin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheettembin = CheckSheetTembin::find($id);

        if ($checkSheettembin->photo_master_link || $checkSheettembin->photo_body_tembin || $checkSheettembin->photo_mur_baut || $checkSheettembin->photo_shackle || $checkSheettembin->photo_hook_atas || $checkSheettembin->photo_pengunci_hook_atas || $checkSheettembin->photo_mata_chain || $checkSheettembin->photo_chain || $checkSheettembin->photo_hook_bawah || $checkSheettembin->photo_pengunci_hook_bawah) {
            Storage::delete($checkSheettembin->photo_master_link);
            Storage::delete($checkSheettembin->photo_body_tembin);
            Storage::delete($checkSheettembin->photo_mur_baut);
            Storage::delete($checkSheettembin->photo_shackle);
            Storage::delete($checkSheettembin->photo_hook_atas);
            Storage::delete($checkSheettembin->photo_pengunci_hook_atas);
            Storage::delete($checkSheettembin->photo_mata_chain);
            Storage::delete($checkSheettembin->photo_chain);
            Storage::delete($checkSheettembin->photo_hook_bawah);
            Storage::delete($checkSheettembin->photo_pengunci_hook_bawah);
        }

        $checkSheettembin->delete();

        return back()->with('success1', 'Data Check Sheet Tembin berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheettembin = CheckSheetTembin::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.tembin.checksheet.index', compact('checksheettembin'));
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-tembin.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $tembinNumber = $request->input('tembin_number');


        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');

        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetTembin::with('tembins')
            ->select('tanggal_pengecekan', 'tembin_number', 'master_link', 'body_tembin', 'mur_baut', 'shackle', 'hook_atas', 'pengunci_hook_atas', 'mata_chain', 'hook_bawah', 'pengunci_hook_bawah')
            ->whereYear('tanggal_pengecekan', $selectedYear)
            ->where('tembin_number', $tembinNumber) // Gunakan nilai tag_number yang diambil dari form
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
}
