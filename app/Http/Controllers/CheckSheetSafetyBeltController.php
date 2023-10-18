<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSafetyBelt;
use App\Models\Safetybelt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckSheetSafetyBeltController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetSafetybelts = CheckSheetSafetyBelt::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.safetybelt.checksheet.check', compact('latestCheckSheetSafetybelts'));
    }

    public function processForm(Request $request)
    {
        $safetybeltNumber = $request->input('safetybelt_number');

        $safetybelt = Safetybelt::where('no_safetybelt', $safetybeltNumber)->first();

        if (!$safetybelt) {
            return back()->with('error', 'Safety Belt Number tidak ditemukan.');
        }

        $safetybeltNumber = strtoupper($safetybeltNumber);

        return redirect()->route('checksheetsafetybelt', compact('safetybeltNumber'));
    }

    public function createForm($safetybeltNumber)
    {
        $latestCheckSheetSafetybelts = CheckSheetSafetybelt::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $safetybelt = Safetybelt::where('no_safetybelt', $safetybeltNumber)->first();

        if (!$safetybelt) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('safetybelt.show.form', compact('latestCheckSheetSafetybelts'))->with('error', 'Safety Belt Number tidak ditemukan.');
        }

        $safetybeltNumber = strtoupper($safetybeltNumber);

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
        $existingCheckSheet = CheckSheetSafetyBelt::where('safetybelt_number', $safetybeltNumber)
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
            return redirect()->route('safetybelt.checksheetsafetybelt.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Safetybelt sudah ada untuk Safetybelt ' . $safetybeltNumber . ' pada triwulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetSafetybelts = CheckSheetSafetybelt::all();
            return view('dashboard.safetybelt.checksheet.checkSafetybelt', compact('checkSheetSafetybelts', 'safetybeltNumber'));
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
        $existingCheckSheet = CheckSheetSafetyBelt::where('safetybelt_number', $request->safetybelt_number)
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
                'safetybelt_number' => 'required',
                'buckle' => 'required',
                'catatan_buckle' => 'nullable|string|max:255',
                'photo_buckle' => 'required|image|file|max:3072',
                'seams' => 'required',
                'catatan_seams' => 'nullable|string|max:255',
                'photo_seams' => 'required|image|file|max:3072',
                'reel' => 'required',
                'catatan_reel' => 'nullable|string|max:255',
                'photo_reel' => 'required|image|file|max:3072',
                'shock_absorber' => 'required',
                'catatan_shock_absorber' => 'nullable|string|max:255',
                'photo_shock_absorber' => 'required|image|file|max:3072',
                'ring' => 'required',
                'catatan_ring' => 'nullable|string|max:255',
                'photo_ring' => 'required|image|file|max:3072',
                'torso_belt' => 'required',
                'catatan_torso_belt' => 'nullable|string|max:255',
                'photo_torso_belt' => 'required|image|file|max:3072',
                'strap' => 'required',
                'catatan_strap' => 'nullable|string|max:255',
                'photo_strap' => 'required|image|file|max:3072',
                'rope' => 'required',
                'catatan_rope' => 'nullable|string|max:255',
                'photo_rope' => 'required|image|file|max:3072',
                'seam_protection_tube' => 'required',
                'catatan_seam_protection_tube' => 'nullable|string|max:255',
                'photo_seam_protection_tube' => 'required|image|file|max:3072',
                'hook' => 'required',
                'catatan_hook' => 'nullable|string|max:255',
                'photo_hook' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['safetybelt_number'] = strtoupper($validatedData['safetybelt_number']);

            if ($request->file('photo_buckle') && $request->file('photo_seams') && $request->file('photo_reel') && $request->file('photo_shock_absorber') && $request->file('photo_ring') && $request->file('photo_torso_belt') && $request->file('photo_strap') && $request->file('photo_rope') && $request->file('photo_seam_protection_tube') && $request->file('photo_hook')) {
                $validatedData['photo_buckle'] = $request->file('photo_buckle')->store('checksheet-safety-belt');
                $validatedData['photo_seams'] = $request->file('photo_seams')->store('checksheet-safety-belt');
                $validatedData['photo_reel'] = $request->file('photo_reel')->store('checksheet-safety-belt');
                $validatedData['photo_shock_absorber'] = $request->file('photo_shock_absorber')->store('checksheet-safety-belt');
                $validatedData['photo_ring'] = $request->file('photo_ring')->store('checksheet-safety-belt');
                $validatedData['photo_torso_belt'] = $request->file('photo_torso_belt')->store('checksheet-safety-belt');
                $validatedData['photo_strap'] = $request->file('photo_strap')->store('checksheet-safety-belt');
                $validatedData['photo_rope'] = $request->file('photo_rope')->store('checksheet-safety-belt');
                $validatedData['photo_seam_protection_tube'] = $request->file('photo_seam_protection_tube')->store('checksheet-safety-belt');
                $validatedData['photo_hook'] = $request->file('photo_hook')->store('checksheet-safety-belt');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('safetybelt.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'safetybelt_number' => 'required',
                'buckle' => 'required',
                'catatan_buckle' => 'nullable|string|max:255',
                'photo_buckle' => 'required|image|file|max:3072',
                'seams' => 'required',
                'catatan_seams' => 'nullable|string|max:255',
                'photo_seams' => 'required|image|file|max:3072',
                'reel' => 'required',
                'catatan_reel' => 'nullable|string|max:255',
                'photo_reel' => 'required|image|file|max:3072',
                'shock_absorber' => 'required',
                'catatan_shock_absorber' => 'nullable|string|max:255',
                'photo_shock_absorber' => 'required|image|file|max:3072',
                'ring' => 'required',
                'catatan_ring' => 'nullable|string|max:255',
                'photo_ring' => 'required|image|file|max:3072',
                'torso_belt' => 'required',
                'catatan_torso_belt' => 'nullable|string|max:255',
                'photo_torso_belt' => 'required|image|file|max:3072',
                'strap' => 'required',
                'catatan_strap' => 'nullable|string|max:255',
                'photo_strap' => 'required|image|file|max:3072',
                'rope' => 'required',
                'catatan_rope' => 'nullable|string|max:255',
                'photo_rope' => 'required|image|file|max:3072',
                'seam_protection_tube' => 'required',
                'catatan_seam_protection_tube' => 'nullable|string|max:255',
                'photo_seam_protection_tube' => 'required|image|file|max:3072',
                'hook' => 'required',
                'catatan_hook' => 'nullable|string|max:255',
                'photo_hook' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['safetybelt_number'] = strtoupper($validatedData['safetybelt_number']);

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

            if ($request->file('photo_buckle') && $request->file('photo_seams') && $request->file('photo_reel') && $request->file('photo_shock_absorber') && $request->file('photo_ring') && $request->file('photo_torso_belt') && $request->file('photo_strap') && $request->file('photo_rope') && $request->file('photo_seam_protection_tube') && $request->file('photo_hook')) {
                $validatedData['photo_buckle'] = $request->file('photo_buckle')->store('checksheet-safety-belt');
                $validatedData['photo_seams'] = $request->file('photo_seams')->store('checksheet-safety-belt');
                $validatedData['photo_reel'] = $request->file('photo_reel')->store('checksheet-safety-belt');
                $validatedData['photo_shock_absorber'] = $request->file('photo_shock_absorber')->store('checksheet-safety-belt');
                $validatedData['photo_ring'] = $request->file('photo_ring')->store('checksheet-safety-belt');
                $validatedData['photo_torso_belt'] = $request->file('photo_torso_belt')->store('checksheet-safety-belt');
                $validatedData['photo_strap'] = $request->file('photo_strap')->store('checksheet-safety-belt');
                $validatedData['photo_rope'] = $request->file('photo_rope')->store('checksheet-safety-belt');
                $validatedData['photo_seam_protection_tube'] = $request->file('photo_seam_protection_tube')->store('checksheet-safety-belt');
                $validatedData['photo_hook'] = $request->file('photo_hook')->store('checksheet-safety-belt');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetSafetyBelt::create($validatedData);

            return redirect()->route('safetybelt.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetSafetyBelt::findOrFail($id);

        return view('dashboard.safetybelt.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheetsafetybelt = CheckSheetSafetyBelt::findOrFail($id);
        return view('dashboard.safetybelt.checksheet.edit', compact('checkSheetsafetybelt'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetsafetybelt = CheckSheetSafetyBelt::findOrFail($id);

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
            'photo_ring' => 'image|file|max:3072',
            'torso_belt' => 'required',
            'catatan_torso_belt' => 'nullable|string|max:255',
            'photo_torso_belt' => 'image|file|max:3072',
            'strap' => 'required',
            'catatan_strap' => 'nullable|string|max:255',
            'photo_strap' => 'image|file|max:3072',
            'rope' => 'required',
            'catatan_rope' => 'nullable|string|max:255',
            'photo_rope' => 'image|file|max:3072',
            'seam_protection_tube' => 'required',
            'catatan_seam_protection_tube' => 'nullable|string|max:255',
            'photo_seam_protection_tube' => 'image|file|max:3072',
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
        $checkSheetsafetybelt->update($validatedData);

        $safetybelt = Safetybelt::where('no_safetybelt', $checkSheetsafetybelt->safetybelt_number)->first();

        if (!$safetybelt) {
            return back()->with('error', 'Safety Belt tidak ditemukan.');
        }

        return redirect()->route('safety-belt.show', $safetybelt->id)->with('success1', 'Data Check Sheet Safety Belt berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheetsafetybelt = CheckSheetSafetyBelt::find($id);

        if ($checkSheetsafetybelt->photo_buckle || $checkSheetsafetybelt->photo_seams || $checkSheetsafetybelt->photo_reel || $checkSheetsafetybelt->photo_shock_absorber || $checkSheetsafetybelt->photo_ring || $checkSheetsafetybelt->photo_torso_belt || $checkSheetsafetybelt->photo_strap || $checkSheetsafetybelt->photo_rope || $checkSheetsafetybelt->photo_seam_protection_tube || $checkSheetsafetybelt->photo_hook) {
            Storage::delete($checkSheetsafetybelt->photo_buckle);
            Storage::delete($checkSheetsafetybelt->photo_seams);
            Storage::delete($checkSheetsafetybelt->photo_reel);
            Storage::delete($checkSheetsafetybelt->photo_shock_absorber);
            Storage::delete($checkSheetsafetybelt->photo_ring);
            Storage::delete($checkSheetsafetybelt->photo_torso_belt);
            Storage::delete($checkSheetsafetybelt->photo_strap);
            Storage::delete($checkSheetsafetybelt->photo_rope);
            Storage::delete($checkSheetsafetybelt->photo_seam_protection_tube);
            Storage::delete($checkSheetsafetybelt->photo_hook);
        }

        $checkSheetsafetybelt->delete();

        return back()->with('success1', 'Data Check Sheet Safety Belt berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheetsafetybelt = CheckSheetSafetyBelt::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.safetybelt.checksheet.index', compact('checksheetsafetybelt'));
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $safetybeltData = Safetybelt::leftJoin('tt_check_sheet_safety_belts', 'tm_safetybelts.no_safetybelt', '=', 'tt_check_sheet_safety_belts.safetybelt_number')
            ->select(
                'tm_safetybelts.no_safetybelt as safetybelt_number',
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
        $filteredSafetybeltData = $safetybeltData->filter(function ($safetybelt) use ($selectedYear) {
            return $safetybelt->tanggal_pengecekan !== null &&
                date('Y', strtotime($safetybelt->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedSafetybeltData = $filteredSafetybeltData->groupBy('safetybelt_number')->map(function ($safetybeltGroup) {
            $safetybeltNumber = $safetybeltGroup[0]['safetybelt_number'];
            $safetybeltPengecekan = $safetybeltGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($safetybeltGroup as $safetybelt) {
                $month = date('n', strtotime($safetybelt['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($safetybelt['buckle'] === 'NG') $issueCodes[] = 'a';
                if ($safetybelt['seams'] === 'NG') $issueCodes[] = 'b';
                if ($safetybelt['reel'] === 'NG') $issueCodes[] = 'c';
                if ($safetybelt['shock_absorber'] === 'NG') $issueCodes[] = 'd';
                if ($safetybelt['ring'] === 'NG') $issueCodes[] = 'e';
                if ($safetybelt['torso_belt'] === 'NG') $issueCodes[] = 'f';
                if ($safetybelt['strap'] === 'NG') $issueCodes[] = 'g';
                if ($safetybelt['rope'] === 'NG') $issueCodes[] = 'h';
                if ($safetybelt['seam_protection_tube'] === 'NG') $issueCodes[] = 'i';
                if ($safetybelt['hook'] === 'NG') $issueCodes[] = 'j';

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }


                $months[$month] = $issueCodes;
            }

            return [
                'safetybelt_number' => $safetybeltNumber,
                'tanggal_pengecekan' => $safetybeltPengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedSafetybeltData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('safetybelt_data.json', $jsonString);

        return view('dashboard.safetybelt_report', [
            'safetybeltData' => $mappedSafetybeltData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
