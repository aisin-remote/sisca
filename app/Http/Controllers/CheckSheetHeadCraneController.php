<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHeadCrane;
use App\Models\HeadCrane;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetHeadCraneController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetHeadCranes = CheckSheetHeadCrane::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.headcrane.checksheet.check', compact('latestCheckSheetHeadCranes'));
    }

    public function processForm(Request $request)
    {
        if (auth()->user()->role != 'Admin') {
            return back()->with('error', 'Hanya admin yang dapat melakukan check');
        }

        $headcraneNumber = $request->input('headcrane_number');

        $headcrane = HeadCrane::where('no_headcrane', $headcraneNumber)->first();

        if (!$headcrane) {
            return back()->with('error', 'Head Crane Number tidak ditemukan.');
        }

        $headcraneNumber = strtoupper($headcraneNumber);

        return redirect()->route('CheckSheetHeadCrane', compact('headcraneNumber'));
    }

    public function createForm($headcraneNumber)
    {
        $latestCheckSheetHeadCranes = CheckSheetHeadCrane::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $headcrane = HeadCrane::where('no_headcrane', $headcraneNumber)->first();

        if (!$headcrane) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('headcrane.show.form', compact('latestCheckSheetHeadCranes'))->with('error', 'Head Crane Number tidak ditemukan.');
        }

        $headcraneNumber = strtoupper($headcraneNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month; // Mengatur $currentMonth menjadi Januari
        $currentYear = Carbon::now()->year; // Mengatur $currentYear menjadi 2024


        // Menghitung musim berdasarkan bulan saat ini
        if ($currentMonth >= 4 && $currentMonth <= 6) {
            // Musim 1 (Februari, Maret, April)
            $season = 1;
        } elseif ($currentMonth >= 7 && $currentMonth <= 9) {
            // Musim 2 (Mei, Juni, Juli)
            $season = 2;
        } elseif ($currentMonth >= 10 && $currentMonth <= 12) {
            // Musim 3 (Agustus, September, Oktober)
            $season = 3;
        } else {
            // Musim 4 (November, Desember, Januari tahun sebelumnya)
            $season = 4;
        }

        // Menghitung bulan awal musim untuk melakukan pengecekan
        if ($season == 1) {
            $startMonth = 4;
        } elseif ($season == 2) {
            $startMonth = 7;
        } elseif ($season == 3) {
            $startMonth = 10;
        } else {
            $startMonth = 1;
        }

        // Mencari entri CheckSheetSlingWire untuk sling_number tertentu dan 3 bulan musim tersebut
        $existingCheckSheet = CheckSheetHeadCrane::where('headcrane_number', $headcraneNumber)
            ->where(function ($query) use ($currentYear, $currentMonth, $startMonth, $season) {

                // Untuk musim lainnya, mencari data pada tahun ini
                $query->where(function ($q) use ($currentYear, $startMonth) {
                    $q->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', '>=', $startMonth)
                        ->whereMonth('created_at', '<=', $startMonth + 2);
                });
            })
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('headcrane.checksheetheadcrane.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet headcrane sudah ada untuk headcrane ' . $headcraneNumber . ' pada triwulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetHeadCranes = CheckSheetHeadCrane::all();
            return view('dashboard.headcrane.checksheet.checkheadcrane', compact('checkSheetHeadCranes', 'headcraneNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Menghitung musim berdasarkan bulan saat ini
        if ($currentMonth >= 4 && $currentMonth <= 6) {
            // Musim 1 (Februari, Maret, April)
            $season = 1;
        } elseif ($currentMonth >= 7 && $currentMonth <= 9) {
            // Musim 2 (Mei, Juni, Juli)
            $season = 2;
        } elseif ($currentMonth >= 10 && $currentMonth <= 12) {
            // Musim 3 (Agustus, September, Oktober)
            $season = 3;
        } else {
            // Musim 4 (November, Desember, Januari tahun sebelumnya)
            $season = 4;
        }

        // Menghitung bulan awal musim untuk melakukan pengecekan
        if ($season == 1) {
            $startMonth = 4;
        } elseif ($season == 2) {
            $startMonth = 7;
        } elseif ($season == 3) {
            $startMonth = 10;
        } else {
            $startMonth = 1;
        }

        // // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        // $existingCheckSheet = CheckSheetBodyHarnest::where('bodyharnest_number', $request->bodyharnest_number)
        //     ->whereYear('created_at', $currentYear)
        //     ->whereMonth('created_at', $currentMonth)
        //     ->first();
        // Mencari entri CheckSheetSlingWire untuk sling_number tertentu dan 3 bulan musim tersebut
        $existingCheckSheet = CheckSheetHeadCrane::where('headcrane_number', $request->headcrane_number)
            ->where(function ($query) use ($currentYear, $startMonth, $season) {

                // Untuk musim lainnya, mencari data pada tahun ini
                $query->where(function ($q) use ($currentYear, $startMonth) {
                    $q->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', '>=', $startMonth)
                        ->whereMonth('created_at', '<=', $startMonth + 2);
                });
            })
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'headcrane_number' => 'required',
                'cross_travelling' => 'required',
                'catatan_cross_travelling' => 'nullable|string|max:255',
                'photo_cross_travelling' => 'required|image|file|max:3072',
                'long_travelling' => 'required',
                'catatan_long_travelling' => 'nullable|string|max:255',
                'photo_long_travelling' => 'required|image|file|max:3072',
                'button_up' => 'required',
                'catatan_button_up' => 'nullable|string|max:255',
                'photo_button_up' => 'required|image|file|max:3072',
                'button_down' => 'required',
                'catatan_button_down' => 'nullable|string|max:255',
                'photo_button_down' => 'required|image|file|max:3072',
                'button_push' => 'required',
                'catatan_button_push' => 'nullable|string|max:255',
                'photo_button_push' => 'required|image|file|max:3072',
                'wire_rope' => 'required',
                'catatan_wire_rope' => 'nullable|string|max:255',
                'photo_wire_rope' => 'required|image|file|max:3072',
                'block_hook' => 'required',
                'catatan_block_hook' => 'nullable|string|max:255',
                'photo_block_hook' => 'required|image|file|max:3072',
                'hom' => 'required',
                'catatan_hom' => 'nullable|string|max:255',
                'photo_hom' => 'required|image|file|max:3072',
                'emergency_stop' => 'required',
                'catatan_emergency_stop' => 'nullable|string|max:255',
                'photo_emergency_stop' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['headcrane_number'] = strtoupper($validatedData['headcrane_number']);

            if ($request->file('photo_cross_travelling') && $request->file('photo_long_travelling') && $request->file('photo_button_up') && $request->file('photo_button_down') && $request->file('photo_button_push') && $request->file('photo_wire_rope') && $request->file('photo_block_hook') && $request->file('photo_hom') && $request->file('photo_emergency_stop') && $request->file('photo_hook')) {
                $validatedData['photo_cross_travelling'] = $request->file('photo_cross_travelling')->store('checksheet-head-crane');
                $validatedData['photo_long_travelling'] = $request->file('photo_long_travelling')->store('checksheet-head-crane');
                $validatedData['photo_button_up'] = $request->file('photo_button_up')->store('checksheet-head-crane');
                $validatedData['photo_button_down'] = $request->file('photo_button_down')->store('checksheet-head-crane');
                $validatedData['photo_button_push'] = $request->file('photo_button_push')->store('checksheet-head-crane');
                $validatedData['photo_wire_rope'] = $request->file('photo_wire_rope')->store('checksheet-head-crane');
                $validatedData['photo_block_hook'] = $request->file('photo_block_hook')->store('checksheet-head-crane');
                $validatedData['photo_hom'] = $request->file('photo_hom')->store('checksheet-head-crane');
                $validatedData['photo_emergency_stop'] = $request->file('photo_emergency_stop')->store('checksheet-head-crane');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('headcrane.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'headcrane_number' => 'required',
                'cross_travelling' => 'required',
                'catatan_cross_travelling' => 'nullable|string|max:255',
                'photo_cross_travelling' => 'required|image|file|max:3072',
                'long_travelling' => 'required',
                'catatan_long_travelling' => 'nullable|string|max:255',
                'photo_long_travelling' => 'required|image|file|max:3072',
                'button_up' => 'required',
                'catatan_button_up' => 'nullable|string|max:255',
                'photo_button_up' => 'required|image|file|max:3072',
                'button_down' => 'required',
                'catatan_button_down' => 'nullable|string|max:255',
                'photo_button_down' => 'required|image|file|max:3072',
                'button_push' => 'required',
                'catatan_button_push' => 'nullable|string|max:255',
                'photo_button_push' => 'required|image|file|max:3072',
                'wire_rope' => 'required',
                'catatan_wire_rope' => 'nullable|string|max:255',
                'photo_wire_rope' => 'required|image|file|max:3072',
                'block_hook' => 'required',
                'catatan_block_hook' => 'nullable|string|max:255',
                'photo_block_hook' => 'required|image|file|max:3072',
                'hom' => 'required',
                'catatan_hom' => 'nullable|string|max:255',
                'photo_hom' => 'required|image|file|max:3072',
                'emergency_stop' => 'required',
                'catatan_emergency_stop' => 'nullable|string|max:255',
                'photo_emergency_stop' => 'required|image|file|max:3072',

                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['headcrane_number'] = strtoupper($validatedData['headcrane_number']);

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $tanggalPengecekan = Carbon::parse($validatedData['tanggal_pengecekan']);
            $bulan = $tanggalPengecekan->month;

            // Tentukan tanggal awal kuartal berdasarkan bulan
            if ($bulan >= 4 && $bulan <= 6) {
                $tanggalAwalKuartal = Carbon::create($tanggalPengecekan->year, 4, 1); // Kuartal 1
            } elseif ($bulan >= 7 && $bulan <= 9) {
                $tanggalAwalKuartal = Carbon::create($tanggalPengecekan->year, 7, 1); // Kuartal 2
            } elseif ($bulan >= 10 && $bulan <= 12) {
                $tanggalAwalKuartal = Carbon::create($tanggalPengecekan->year, 10, 1); // Kuartal 3
            } else {
                // Jika bulan di luar kuartal, maka masuk ke kuartal 4
                $tanggalAwalKuartal = Carbon::create($tanggalPengecekan->year, 1, 1); // Kuartal 4

                // Jika bulan adalah Januari, kurangi tahun sebelumnya
                if ($bulan >= 1 && $bulan <= 3) {
                    $tanggalAwalKuartal->subYear();
                }
            }

            // Set tanggal_pengecekan sesuai dengan tanggal awal kuartal
            $validatedData['tanggal_pengecekan'] = $tanggalAwalKuartal;

            if ($request->file('photo_cross_travelling') && $request->file('photo_long_travelling') && $request->file('photo_button_up') && $request->file('photo_button_down') && $request->file('photo_button_push') && $request->file('photo_wire_rope') && $request->file('photo_block_hook') && $request->file('photo_hom') && $request->file('photo_emergency_stop') && $request->file('photo_hook')) {
                $validatedData['photo_cross_travelling'] = $request->file('photo_buckle')->store('checksheet-head-crane');
                $validatedData['photo_long_travelling'] = $request->file('photo_seams')->store('checksheet-head-crane');
                $validatedData['photo_button_up'] = $request->file('photo_reel')->store('checksheet-head-crane');
                $validatedData['photo_button_down'] = $request->file('photo_button_down')->store('checksheet-head-crane');
                $validatedData['photo_button_push'] = $request->file('photo_button_push')->store('checksheet-head-crane');
                $validatedData['photo_wire_rope'] = $request->file('photo_wire_rope')->store('checksheet-head-crane');
                $validatedData['photo_block_hook'] = $request->file('photo_block_hook')->store('checksheet-head-crane');
                $validatedData['photo_hom'] = $request->file('photo_hom')->store('checksheet-head-crane');
                $validatedData['photo_emergency_stop'] = $request->file('photo_emergency_stop')->store('checksheet-head-crane');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetHeadCrane::create($validatedData);

            return redirect()->route('headcrane.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetHeadCrane::findOrFail($id);

        return view('dashboard.headcrane.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheetheadcrane = CheckSheetHeadCrane::findOrFail($id);
        return view('dashboard.headcrane.checksheet.edit', compact('checkSheetheadcrane'));
    }

    public function update(Request $request, $id)
    {
        $CheckSheetHeadCrane = CheckSheetHeadCrane::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'cross_travelling' => 'required',
            'catatan_cross_travelling' => 'nullable|string|max:255',
            'photo_cross_travelling' => 'required|image|file|max:3072',
            'long_travelling' => 'required',
            'catatan_long_travelling' => 'nullable|string|max:255',
            'photo_long_travelling' => 'required|image|file|max:3072',
            'button_up' => 'required',
            'catatan_button_up' => 'nullable|string|max:255',
            'photo_button_up' => 'required|image|file|max:3072',
            'button_down' => 'required',
            'catatan_button_down' => 'nullable|string|max:255',
            'photo_button_down' => 'required|image|file|max:3072',
            'button_push' => 'required',
            'catatan_button_push' => 'nullable|string|max:255',
            'photo_button_push' => 'required|image|file|max:3072',
            'wire_rope' => 'required',
            'catatan_wire_rope' => 'nullable|string|max:255',
            'photo_wire_rope' => 'required|image|file|max:3072',
            'block_hook' => 'required',
            'catatan_block_hook' => 'nullable|string|max:255',
            'photo_block_hook' => 'required|image|file|max:3072',
            'hom' => 'required',
            'catatan_hom' => 'nullable|string|max:255',
            'photo_hom' => 'required|image|file|max:3072',
            'emergency_stop' => 'required',
            'catatan_emergency_stop' => 'nullable|string|max:255',
            'photo_emergency_stop' => 'required|image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_cross_travelling')) {
            if ($request->oldImage_cross_travelling) {
                Storage::delete($request->oldImage_cross_travelling);
            }
            $validatedData['photo_cross_travelling'] = $request->file('photo_cross_travelling')->store('checksheet-head-crane');
        }

        if ($request->file('photo_long_travelling')) {
            if ($request->oldImage_long_travelling) {
                Storage::delete($request->oldImage_long_travelling);
            }
            $validatedData['photo_long_travelling'] = $request->file('photo_long_travelling')->store('checksheet-head-crane');
        }

        if ($request->file('photo_button_up')) {
            if ($request->oldImage_button_up) {
                Storage::delete($request->oldImage_button_up);
            }
            $validatedData['photo_button_up'] = $request->file('photo_button_up')->store('checksheet-head-crane');
        }

        if ($request->file('photo_button_down')) {
            if ($request->oldImage_button_down) {
                Storage::delete($request->oldImage_button_down);
            }
            $validatedData['photo_button_down'] = $request->file('photo_button_down')->store('checksheet-head-crane');
        }

        if ($request->file('photo_button_push')) {
            if ($request->oldImage_button_push) {
                Storage::delete($request->oldImage_button_push);
            }
            $validatedData['photo_button_push'] = $request->file('photo_button_push')->store('checksheet-head-crane');
        }

        if ($request->file('photo_wire_rope')) {
            if ($request->oldImage_wire_rope) {
                Storage::delete($request->oldImage_wire_rope);
            }
            $validatedData['photo_wire_rope'] = $request->file('photo_wire_rope')->store('checksheet-head-crane');
        }

        if ($request->file('photo_block_hook')) {
            if ($request->oldImage_block_hook) {
                Storage::delete($request->oldImage_block_hook);
            }
            $validatedData['photo_block_hook'] = $request->file('photo_block_hook')->store('checksheet-head-crane');
        }

        if ($request->file('photo_hom')) {
            if ($request->oldImage_hom) {
                Storage::delete($request->oldImage_hom);
            }
            $validatedData['photo_hom'] = $request->file('photo_hom')->store('checksheet-head-crane');
        }

        if ($request->file('photo_emergency_stop')) {
            if ($request->oldImage_emergency_stop) {
                Storage::delete($request->oldImage_emergency_stop);
            }
            $validatedData['photo_emergency_stop'] = $request->file('photo_emergency_stop')->store('checksheet-head-crane');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $CheckSheetHeadCrane->update($validatedData);

        $headcrane = headcrane::where('no_headcrane', $CheckSheetHeadCrane->headcrane_number)->first();

        if (!$headcrane) {
            return back()->with('error', 'Head Crane tidak ditemukan.');
        }

        return redirect()->route('head-crane.show', $headcrane->id)->with('success1', 'Data Check Sheet Head Crane berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $CheckSheetHeadCrane = CheckSheetHeadCrane::find($id);

        if ($CheckSheetHeadCrane->photo_cross_travelling || $CheckSheetHeadCrane->photo_long_travelling || $CheckSheetHeadCrane->photo_button_up || $CheckSheetHeadCrane->photo_button_down || $CheckSheetHeadCrane->photo_button_push || $CheckSheetHeadCrane->photo_wire_rope || $CheckSheetHeadCrane->photo_block_hook || $CheckSheetHeadCrane->photo_hom || $CheckSheetHeadCrane->photo_emergency_stop) {
            Storage::delete($CheckSheetHeadCrane->photo_cross_travelling);
            Storage::delete($CheckSheetHeadCrane->photo_long_travelling);
            Storage::delete($CheckSheetHeadCrane->photo_button_up);
            Storage::delete($CheckSheetHeadCrane->photo_button_down);
            Storage::delete($CheckSheetHeadCrane->photo_button_push);
            Storage::delete($CheckSheetHeadCrane->photo_wire_rope);
            Storage::delete($CheckSheetHeadCrane->photo_block_hook);
            Storage::delete($CheckSheetHeadCrane->photo_hom);
            Storage::delete($CheckSheetHeadCrane->photo_emergency_stop);
        }

        $CheckSheetHeadCrane->delete();

        return back()->with('success1', 'Data Check Sheet Head Crane berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheetheadcrane = CheckSheetHeadCrane::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.headcrane.checksheet.index', compact('checksheetheadcrane'));
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $headcraneData = headcrane::leftJoin('tt_check_sheet_head_cranes', 'tm_HeadCranes.no_headcrane', '=', 'tt_check_sheet_head_cranes.headcrane_number')
            ->select(
                'tm_headcranes.no_headcrane as headcrane_number',
                'tt_check_sheet_head_cranes.tanggal_pengecekan',
                'tt_check_sheet_head_cranes.cross_travelling',
                'tt_check_sheet_head_cranes.long_travelling',
                'tt_check_sheet_head_cranes.button_up',
                'tt_check_sheet_head_cranes.button_down',
                'tt_check_sheet_head_cranes.button_push',
                'tt_check_sheet_head_cranes.wire_rope',
                'tt_check_sheet_head_cranes.block_hook',
                'tt_check_sheet_head_cranes.hom',
                'tt_check_sheet_head_cranes.emergency_stop',
            )
            ->get();


        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredheadcraneData = $headcraneData->filter(function ($headcrane) use ($selectedYear) {
            return $headcrane->tanggal_pengecekan !== null &&
                date('Y', strtotime($headcrane->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedheadcraneData = $filteredheadcraneData->groupBy('headcrane_number')->map(function ($headcraneGroup) {
            $headcraneNumber = $headcraneGroup[0]['headcrane_number'];
            $headcranePengecekan = $headcraneGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($headcraneGroup as $headcrane) {
                $month = date('n', strtotime($headcrane['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($headcrane['cross_travelling'] === 'NG') $issueCodes[] = 'a';
                if ($headcrane['long_travelling'] === 'NG') $issueCodes[] = 'b';
                if ($headcrane['button_up'] === 'NG') $issueCodes[] = 'c';
                if ($headcrane['button_down'] === 'NG') $issueCodes[] = 'd';
                if ($headcrane['button_push'] === 'NG') $issueCodes[] = 'e';
                if ($headcrane['wire_rope'] === 'NG') $issueCodes[] = 'f';
                if ($headcrane['block_hook'] === 'NG') $issueCodes[] = 'g';
                if ($headcrane['hom'] === 'NG') $issueCodes[] = 'h';
                if ($headcrane['emergency_stop'] === 'NG') $issueCodes[] = 'i';

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }


                $months[$month] = $issueCodes;
            }

            return [
                'headcrane_number' => $headcraneNumber,
                'tanggal_pengecekan' => $headcranePengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedheadcraneData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('headcrane_data.json', $jsonString);

        return view('dashboard.headcrane.reports.index', [
            'headcraneData' => $mappedheadcraneData,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-headcrane.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $headcraneNumber = $request->input('headcrane_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');


        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetHeadCrane::with('HeadCranes')
            ->select('tanggal_pengecekan', 'headcrane_number', 'cross_travelling', 'long_travelling', 'button_up', 'button_down', 'button_push', 'wire_rope', 'block_hook', 'hom', 'emergency_stop')
            ->where(function ($query) use ($selectedYear, $headcraneNumber) {
                // Kondisi untuk memanggil data berdasarkan tahun dan tag_number
                $query->whereYear('tanggal_pengecekan', $selectedYear)
                    ->where('headcrane_number', $headcraneNumber);
            })
            // ->orWhere(function ($query) use ($selectedYear, $headcraneNumber) {
            //     // Kondisi untuk memanggil data bulan Januari tahun selanjutnya
            //     $query->whereMonth('tanggal_pengecekan', 1)
            //         ->whereYear('tanggal_pengecekan', $selectedYear + 1)
            //         ->where('headcrane_number', $headcraneNumber);
            // })
            ->get();


        // Quartal mapping ke kolom
        $quartalKolom = [
            1 => 'AQ',  // Quartal 1 -> Kolom Y
            2 => 'AT', // Quartal 2 -> Kolom AB
            3 => 'AW', // Quartal 3 -> Kolom AE
            4 => 'AN', // Quartal 4 -> Kolom AH
        ];

        $worksheet->setCellValue('AU' . 2, $data[0]->headcrane_number);
        $worksheet->setCellValue('AU' . 3, $data[0]->HeadCranes->locations->location_name);

        foreach ($data as $item) {

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $bulan = Carbon::parse($item->tanggal_pengecekan)->month;

            if ($bulan >= 4 && $bulan <= 6) {
                $quartal = 1;
            } elseif ($bulan >= 7 && $bulan <= 9) {
                $quartal = 2;
            } elseif ($bulan >= 10 && $bulan <= 12) {
                $quartal = 3;
            } else {
                $quartal = 4;
            }



            // Tentukan kolom berdasarkan bulan
            $col = $quartalKolom[$quartal];

            // Set value based on $item->pressure
            if ($item->cross_travelling === 'OK') {
                $worksheet->setCellValue($col . 9, '√');
            } else if ($item->cross_travelling === 'NG') {
                $worksheet->setCellValue($col . 9, 'X');
            }

            // Set value based on $item->hose
            if ($item->long_travelling === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->long_travelling === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->corong
            if ($item->button_up === 'OK') {
                $worksheet->setCellValue($col . 15, '√');
            } else if ($item->button_up === 'NG') {
                $worksheet->setCellValue($col . 15, 'X');
            }

            // Set value based on $item->tabung
            if ($item->button_down === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->button_down === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->regulator
            if ($item->button_push === 'OK') {
                $worksheet->setCellValue($col . 21, '√');
            } else if ($item->button_push === 'NG') {
                $worksheet->setCellValue($col . 21, 'X');
            }

            if ($item->wire_rope === 'OK') {
                $worksheet->setCellValue($col . 24, '√');
            } else if ($item->wire_rope === 'NG') {
                $worksheet->setCellValue($col . 24, 'X');
            }

            if ($item->block_hook === 'OK') {
                $worksheet->setCellValue($col . 27, '√');
            } else if ($item->block_hook === 'NG') {
                $worksheet->setCellValue($col . 27, 'X');
            }

            if ($item->hom === 'OK') {
                $worksheet->setCellValue($col . 30, '√');
            } else if ($item->hom === 'NG') {
                $worksheet->setCellValue($col . 30, 'X');
            }

            if ($item->emergency_stop === 'OK') {
                $worksheet->setCellValue($col . 33, '√');
            } else if ($item->emergency_stop === 'NG') {
                $worksheet->setCellValue($col . 33, 'X');
            }
            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-head-crane.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
