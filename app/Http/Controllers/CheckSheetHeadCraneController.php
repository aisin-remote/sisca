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
            return redirect()->route('headcrane.CheckSheetHeadCrane.edit', $existingCheckSheet->id)
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
            'buckle' => 'required',
            'catatan_buckle' => 'nullable|string|max:255',
            'photo_buckle' => 'image|file|max:3072',
            'seams' => 'required',
            'catatan_seams' => 'nullable|string|max:255',
            'photo_seams' => 'image|file|max:3072',
            'reel' => 'required',
            'catatan_reel' => 'nullable|string|max:255',
            'photo_reel' => 'image|file|max:3072',
            'shock_absorber' => 'required',
            'catatan_shock_absorber' => 'nullable|string|max:255',
            'photo_shock_absorber' => 'image|file|max:3072',
            'ring' => 'required',
            'catatan_ring' => 'nullable|string|max:255',
            'photo_button_push' => 'image|file|max:3072',
            'torso_belt' => 'required',
            'catatan_torso_belt' => 'nullable|string|max:255',
            'photo_torso_belt' => 'image|file|max:3072',
            'strap' => 'required',
            'catatan_strap' => 'nullable|string|max:255',
            'photo_strap' => 'image|file|max:3072',
            'rope' => 'required',
            'catatan_rope' => 'nullable|string|max:255',
            'photo_rope' => 'image|file|max:3072',
            'emergency_stop' => 'required',
            'catatan_emergency_stop' => 'nullable|string|max:255',
            'photo_emergency_stop' => 'image|file|max:3072',
            'hook' => 'required',
            'catatan_hook' => 'nullable|string|max:255',
            'photo_hook' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_buckle')) {
            if ($request->oldImage_buckle) {
                Storage::delete($request->oldImage_buckle);
            }
            $validatedData['photo_buckle'] = $request->file('photo_buckle')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_seams')) {
            if ($request->oldImage_seams) {
                Storage::delete($request->oldImage_seams);
            }
            $validatedData['photo_seams'] = $request->file('photo_seams')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_reel')) {
            if ($request->oldImage_reel) {
                Storage::delete($request->oldImage_reel);
            }
            $validatedData['photo_reel'] = $request->file('photo_reel')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_shock_absorber')) {
            if ($request->oldImage_shock_absorber) {
                Storage::delete($request->oldImage_shock_absorber);
            }
            $validatedData['photo_shock_absorber'] = $request->file('photo_shock_absorber')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_ring')) {
            if ($request->oldImage_ring) {
                Storage::delete($request->oldImage_ring);
            }
            $validatedData['photo_ring'] = $request->file('photo_ring')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_torso_belt')) {
            if ($request->oldImage_torso_belt) {
                Storage::delete($request->oldImage_torso_belt);
            }
            $validatedData['photo_torso_belt'] = $request->file('photo_torso_belt')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_strap')) {
            if ($request->oldImage_strap) {
                Storage::delete($request->oldImage_strap);
            }
            $validatedData['photo_strap'] = $request->file('photo_strap')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_rope')) {
            if ($request->oldImage_rope) {
                Storage::delete($request->oldImage_rope);
            }
            $validatedData['photo_rope'] = $request->file('photo_rope')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_seam_protection_tube')) {
            if ($request->oldImage_seam_protection_tube) {
                Storage::delete($request->oldImage_seam_protection_tube);
            }
            $validatedData['photo_seam_protection_tube'] = $request->file('photo_seam_protection_tube')->store('checksheet-safety-belt');
        }

        if ($request->file('photo_hook')) {
            if ($request->oldImage_hook) {
                Storage::delete($request->oldImage_hook);
            }
            $validatedData['photo_hook'] = $request->file('photo_hook')->store('checksheet-safety-belt');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $CheckSheetHeadCrane->update($validatedData);

        $headcrane = headcrane::where('no_headcrane', $CheckSheetHeadCrane->headcrane_number)->first();

        if (!$headcrane) {
            return back()->with('error', 'Safety Belt tidak ditemukan.');
        }

        return redirect()->route('safety-belt.show', $headcrane->id)->with('success1', 'Data Check Sheet Safety Belt berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $CheckSheetHeadCrane = CheckSheetHeadCrane::find($id);

        if ($CheckSheetHeadCrane->photo_buckle || $CheckSheetHeadCrane->photo_seams || $CheckSheetHeadCrane->photo_reel || $CheckSheetHeadCrane->photo_shock_absorber || $CheckSheetHeadCrane->photo_ring || $CheckSheetHeadCrane->photo_torso_belt || $CheckSheetHeadCrane->photo_strap || $CheckSheetHeadCrane->photo_rope || $CheckSheetHeadCrane->photo_seam_protection_tube || $CheckSheetHeadCrane->photo_hook) {
            Storage::delete($CheckSheetHeadCrane->photo_buckle);
            Storage::delete($CheckSheetHeadCrane->photo_seams);
            Storage::delete($CheckSheetHeadCrane->photo_reel);
            Storage::delete($CheckSheetHeadCrane->photo_shock_absorber);
            Storage::delete($CheckSheetHeadCrane->photo_ring);
            Storage::delete($CheckSheetHeadCrane->photo_torso_belt);
            Storage::delete($CheckSheetHeadCrane->photo_strap);
            Storage::delete($CheckSheetHeadCrane->photo_rope);
            Storage::delete($CheckSheetHeadCrane->photo_seam_protection_tube);
            Storage::delete($CheckSheetHeadCrane->photo_hook);
        }

        $CheckSheetHeadCrane->delete();

        return back()->with('success1', 'Data Check Sheet Safety Belt berhasil dihapus');
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

        $headcraneData = headcrane::leftJoin('tt_check_sheet_safety_belts', 'tm_HeadCranes.no_headcrane', '=', 'tt_check_sheet_safety_belts.headcrane_number')
            ->select(
                'tm_HeadCranes.no_headcrane as headcrane_number',
                'tt_check_sheet_safety_belts.tanggal_pengecekan',
                'tt_check_sheet_safety_belts.buckle',
                'tt_check_sheet_safety_belts.seams',
                'tt_check_sheet_safety_belts.reel',
                'tt_check_sheet_safety_belts.shock_absorber',
                'tt_check_sheet_safety_belts.ring',
                'tt_check_sheet_safety_belts.torso_belt',
                'tt_check_sheet_safety_belts.strap',
                'tt_check_sheet_safety_belts.rope',
                'tt_check_sheet_safety_belts.seam_protection_tube',
                'tt_check_sheet_safety_belts.hook',
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
                if ($headcrane['buckle'] === 'NG') $issueCodes[] = 'a';
                if ($headcrane['seams'] === 'NG') $issueCodes[] = 'b';
                if ($headcrane['reel'] === 'NG') $issueCodes[] = 'c';
                if ($headcrane['shock_absorber'] === 'NG') $issueCodes[] = 'd';
                if ($headcrane['ring'] === 'NG') $issueCodes[] = 'e';
                if ($headcrane['torso_belt'] === 'NG') $issueCodes[] = 'f';
                if ($headcrane['strap'] === 'NG') $issueCodes[] = 'g';
                if ($headcrane['rope'] === 'NG') $issueCodes[] = 'h';
                if ($headcrane['seam_protection_tube'] === 'NG') $issueCodes[] = 'i';
                if ($headcrane['hook'] === 'NG') $issueCodes[] = 'j';

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

        return view('dashboard.headcrane_report', [
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
            ->select('tanggal_pengecekan', 'headcrane_number', 'buckle', 'seams', 'reel', 'shock_absorber', 'ring', 'torso_belt', 'strap', 'rope', 'seam_protection_tube', 'hook')
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
            if ($item->buckle === 'OK') {
                $worksheet->setCellValue($col . 9, '√');
            } else if ($item->buckle === 'NG') {
                $worksheet->setCellValue($col . 9, 'X');
            }

            // Set value based on $item->hose
            if ($item->seams === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->seams === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->corong
            if ($item->reel === 'OK') {
                $worksheet->setCellValue($col . 15, '√');
            } else if ($item->reel === 'NG') {
                $worksheet->setCellValue($col . 15, 'X');
            }

            // Set value based on $item->tabung
            if ($item->shock_absorber === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->shock_absorber === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->regulator
            if ($item->ring === 'OK') {
                $worksheet->setCellValue($col . 21, '√');
            } else if ($item->ring === 'NG') {
                $worksheet->setCellValue($col . 21, 'X');
            }

            if ($item->torso_belt === 'OK') {
                $worksheet->setCellValue($col . 24, '√');
            } else if ($item->torso_belt === 'NG') {
                $worksheet->setCellValue($col . 24, 'X');
            }

            if ($item->strap === 'OK') {
                $worksheet->setCellValue($col . 27, '√');
            } else if ($item->strap === 'NG') {
                $worksheet->setCellValue($col . 27, 'X');
            }

            if ($item->rope === 'OK') {
                $worksheet->setCellValue($col . 30, '√');
            } else if ($item->rope === 'NG') {
                $worksheet->setCellValue($col . 30, 'X');
            }

            if ($item->seam_protection_tube === 'OK') {
                $worksheet->setCellValue($col . 33, '√');
            } else if ($item->seam_protection_tube === 'NG') {
                $worksheet->setCellValue($col . 33, 'X');
            }

            if ($item->hook === 'OK') {
                $worksheet->setCellValue($col . 36, '√');
            } else if ($item->hook === 'NG') {
                $worksheet->setCellValue($col . 36, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-safety-belt.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
