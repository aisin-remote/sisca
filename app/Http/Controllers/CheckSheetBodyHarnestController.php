<?php

namespace App\Http\Controllers;

use App\Models\Bodyharnest;
use App\Models\CheckSheetBodyHarnest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetBodyHarnestController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetBodyharnests = CheckSheetBodyHarnest::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.bodyharnest.checksheet.check', compact('latestCheckSheetBodyharnests'));
    }

    public function processForm(Request $request)
    {
        $bodyharnestNumber = $request->input('bodyharnest_number');

        $bodyharnest = Bodyharnest::where('no_bodyharnest', $bodyharnestNumber)->first();

        if (!$bodyharnest) {
            return back()->with('error', 'Body Harnest Number tidak ditemukan.');
        }

        $bodyharnestNumber = strtoupper($bodyharnestNumber);

        return redirect()->route('checksheetbodyharnest', compact('bodyharnestNumber'));
    }

    public function createForm($bodyharnestNumber)
    {
        $latestCheckSheetBodyharnests = CheckSheetBodyharnest::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $bodyharnest = Bodyharnest::where('no_bodyharnest', $bodyharnestNumber)->first();

        if (!$bodyharnest) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('bodyharnest.show.form', compact('latestCheckSheetBodyharnests'))->with('error', 'Body Harnest Number tidak ditemukan.');
        }

        $bodyharnestNumber = strtoupper($bodyharnestNumber);

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
        $existingCheckSheet = CheckSheetBodyHarnest::where('bodyharnest_number', $bodyharnestNumber)
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
            return redirect()->route('bodyharnest.checksheetbodyharnest.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Bodyharnest sudah ada untuk Bodyharnest ' . $bodyharnestNumber . ' pada triwulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetBodyharnests = CheckSheetBodyharnest::all();
            return view('dashboard.bodyharnest.checksheet.checkBodyharnest', compact('checkSheetBodyharnests', 'bodyharnestNumber'));
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
        $existingCheckSheet = CheckSheetBodyHarnest::where('bodyharnest_number', $request->bodyharnest_number)
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
                'bodyharnest_number' => 'required',
                'shoulder_straps' => 'required',
                'catatan_shoulder_straps' => 'nullable|string|max:255',
                'photo_shoulder_straps' => 'required|image|file|max:3072',
                'hook' => 'required',
                'catatan_hook' => 'nullable|string|max:255',
                'photo_hook' => 'required|image|file|max:3072',
                'buckles_waist' => 'required',
                'catatan_buckles_waist' => 'nullable|string|max:255',
                'photo_buckles_waist' => 'required|image|file|max:3072',
                'buckles_chest' => 'required',
                'catatan_buckles_chest' => 'nullable|string|max:255',
                'photo_buckles_chest' => 'required|image|file|max:3072',
                'leg_straps' => 'required',
                'catatan_leg_straps' => 'nullable|string|max:255',
                'photo_leg_straps' => 'required|image|file|max:3072',
                'buckles_leg' => 'required',
                'catatan_buckles_leg' => 'nullable|string|max:255',
                'photo_buckles_leg' => 'required|image|file|max:3072',
                'back_d_ring' => 'required',
                'catatan_back_d_ring' => 'nullable|string|max:255',
                'photo_back_d_ring' => 'required|image|file|max:3072',
                'carabiner' => 'required',
                'catatan_carabiner' => 'nullable|string|max:255',
                'photo_carabiner' => 'required|image|file|max:3072',
                'straps_rope' => 'required',
                'catatan_straps_rope' => 'nullable|string|max:255',
                'photo_straps_rope' => 'required|image|file|max:3072',
                'shock_absorber' => 'required',
                'catatan_shock_absorber' => 'nullable|string|max:255',
                'photo_shock_absorber' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['bodyharnest_number'] = strtoupper($validatedData['bodyharnest_number']);

            if ($request->file('photo_shoulder_straps') && $request->file('photo_hook') && $request->file('photo_buckles_waist') && $request->file('photo_buckles_chest') && $request->file('photo_leg_straps') && $request->file('photo_buckles_leg') && $request->file('photo_back_d_ring') && $request->file('photo_carabiner') && $request->file('photo_straps_rope') && $request->file('photo_shock_absorber')) {
                $validatedData['photo_shoulder_straps'] = $request->file('photo_shoulder_straps')->store('checksheet-body-harnest');
                $validatedData['photo_hook'] = $request->file('photo_hook')->store('checksheet-body-harnest');
                $validatedData['photo_buckles_waist'] = $request->file('photo_buckles_waist')->store('checksheet-body-harnest');
                $validatedData['photo_buckles_chest'] = $request->file('photo_buckles_chest')->store('checksheet-body-harnest');
                $validatedData['photo_leg_straps'] = $request->file('photo_leg_straps')->store('checksheet-body-harnest');
                $validatedData['photo_buckles_leg'] = $request->file('photo_buckles_leg')->store('checksheet-body-harnest');
                $validatedData['photo_back_d_ring'] = $request->file('photo_back_d_ring')->store('checksheet-body-harnest');
                $validatedData['photo_carabiner'] = $request->file('photo_carabiner')->store('checksheet-body-harnest');
                $validatedData['photo_straps_rope'] = $request->file('photo_straps_rope')->store('checksheet-body-harnest');
                $validatedData['photo_shock_absorber'] = $request->file('photo_shock_absorber')->store('checksheet-body-harnest');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('bodyharnest.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'bodyharnest_number' => 'required',
                'shoulder_straps' => 'required',
                'catatan_shoulder_straps' => 'nullable|string|max:255',
                'photo_shoulder_straps' => 'image|file|max:3072',
                'hook' => 'required',
                'catatan_hook' => 'nullable|string|max:255',
                'photo_hook' => 'image|file|max:3072',
                'buckles_waist' => 'required',
                'catatan_buckles_waist' => 'nullable|string|max:255',
                'photo_buckles_waist' => 'image|file|max:3072',
                'buckles_chest' => 'required',
                'catatan_buckles_chest' => 'nullable|string|max:255',
                'photo_buckles_chest' => 'image|file|max:3072',
                'leg_straps' => 'required',
                'catatan_leg_straps' => 'nullable|string|max:255',
                'photo_leg_straps' => 'image|file|max:3072',
                'buckles_leg' => 'required',
                'catatan_buckles_leg' => 'nullable|string|max:255',
                'photo_buckles_leg' => 'image|file|max:3072',
                'back_d_ring' => 'required',
                'catatan_back_d_ring' => 'nullable|string|max:255',
                'photo_back_d_ring' => 'image|file|max:3072',
                'carabiner' => 'required',
                'catatan_carabiner' => 'nullable|string|max:255',
                'photo_carabiner' => 'image|file|max:3072',
                'straps_rope' => 'required',
                'catatan_straps_rope' => 'nullable|string|max:255',
                'photo_straps_rope' => 'required|image|file|max:3072',
                'shock_absorber' => 'required',
                'catatan_shock_absorber' => 'nullable|string|max:255',
                'photo_shock_absorber' => 'image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['bodyharnest_number'] = strtoupper($validatedData['bodyharnest_number']);

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
                if ($bulan >= 1 && $bulan <=3) {
                    $tanggalAwalKuartal->subYear();
                }
            }

            // Set tanggal_pengecekan sesuai dengan tanggal awal kuartal
            $validatedData['tanggal_pengecekan'] = $tanggalAwalKuartal;

            if ($request->file('photo_shoulder_straps') && $request->file('photo_hook') && $request->file('photo_buckles_waist') && $request->file('photo_buckles_chest') && $request->file('photo_leg_straps') && $request->file('photo_buckles_leg') && $request->file('photo_back_d_ring') && $request->file('photo_carabiner') && $request->file('photo_straps_rope') && $request->file('photo_shock_absorber')) {
                $validatedData['photo_shoulder_straps'] = $request->file('photo_shoulder_straps')->store('checksheet-body-harnest');
                $validatedData['photo_hook'] = $request->file('photo_hook')->store('checksheet-body-harnest');
                $validatedData['photo_buckles_waist'] = $request->file('photo_buckles_waist')->store('checksheet-body-harnest');
                $validatedData['photo_buckles_chest'] = $request->file('photo_buckles_chest')->store('checksheet-body-harnest');
                $validatedData['photo_leg_straps'] = $request->file('photo_leg_straps')->store('checksheet-body-harnest');
                $validatedData['photo_buckles_leg'] = $request->file('photo_buckles_leg')->store('checksheet-body-harnest');
                $validatedData['photo_back_d_ring'] = $request->file('photo_back_d_ring')->store('checksheet-body-harnest');
                $validatedData['photo_carabiner'] = $request->file('photo_carabiner')->store('checksheet-body-harnest');
                $validatedData['photo_straps_rope'] = $request->file('photo_straps_rope')->store('checksheet-body-harnest');
                $validatedData['photo_shock_absorber'] = $request->file('photo_shock_absorber')->store('checksheet-body-harnest');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetBodyHarnest::create($validatedData);

            return redirect()->route('bodyharnest.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetBodyHarnest::findOrFail($id);

        return view('dashboard.bodyharnest.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheetbodyharnest = CheckSheetBodyHarnest::findOrFail($id);
        return view('dashboard.bodyharnest.checksheet.edit', compact('checkSheetbodyharnest'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetbodyharnest = CheckSheetBodyHarnest::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'shoulder_straps' => 'required',
            'catatan_shoulder_straps' => 'nullable|string|max:255',
            'photo_shoulder_straps' => 'image|file|max:3072',
            'hook' => 'required',
            'catatan_hook' => 'nullable|string|max:255',
            'photo_hook' => 'image|file|max:3072',
            'buckles_waist' => 'required',
            'catatan_buckles_waist' => 'nullable|string|max:255',
            'photo_buckles_waist' => 'image|file|max:3072',
            'buckles_chest' => 'required',
            'catatan_buckles_chest' => 'nullable|string|max:255',
            'photo_buckles_chest' => 'image|file|max:3072',
            'leg_straps' => 'required',
            'catatan_leg_straps' => 'nullable|string|max:255',
            'photo_leg_straps' => 'image|file|max:3072',
            'buckles_leg' => 'required',
            'catatan_buckles_leg' => 'nullable|string|max:255',
            'photo_buckles_leg' => 'image|file|max:3072',
            'back_d_ring' => 'required',
            'catatan_back_d_ring' => 'nullable|string|max:255',
            'photo_back_d_ring' => 'image|file|max:3072',
            'carabiner' => 'required',
            'catatan_carabiner' => 'nullable|string|max:255',
            'photo_carabiner' => 'image|file|max:3072',
            'straps_rope' => 'required',
            'catatan_straps_rope' => 'nullable|string|max:255',
            'photo_straps_rope' => 'image|file|max:3072',
            'shock_absorber' => 'required',
            'catatan_shock_absorber' => 'nullable|string|max:255',
            'photo_shock_absorber' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_shoulder_straps')) {
            if ($request->oldImage_shoulder_straps) {
                Storage::delete($request->oldImage_shoulder_straps);
            }
            $validatedData['photo_shoulder_straps'] = $request->file('photo_shoulder_straps')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_hook')) {
            if ($request->oldImage_hook) {
                Storage::delete($request->oldImage_hook);
            }
            $validatedData['photo_hook'] = $request->file('photo_hook')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_buckles_waist')) {
            if ($request->oldImage_buckles_waist) {
                Storage::delete($request->oldImage_buckles_waist);
            }
            $validatedData['photo_buckles_waist'] = $request->file('photo_buckles_waist')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_buckles_chest')) {
            if ($request->oldImage_buckles_chest) {
                Storage::delete($request->oldImage_buckles_chest);
            }
            $validatedData['photo_buckles_chest'] = $request->file('photo_buckles_chest')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_leg_straps')) {
            if ($request->oldImage_leg_straps) {
                Storage::delete($request->oldImage_leg_straps);
            }
            $validatedData['photo_leg_straps'] = $request->file('photo_leg_straps')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_buckles_leg')) {
            if ($request->oldImage_buckles_leg) {
                Storage::delete($request->oldImage_buckles_leg);
            }
            $validatedData['photo_buckles_leg'] = $request->file('photo_buckles_leg')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_back_d_ring')) {
            if ($request->oldImage_back_d_ring) {
                Storage::delete($request->oldImage_back_d_ring);
            }
            $validatedData['photo_back_d_ring'] = $request->file('photo_back_d_ring')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_carabiner')) {
            if ($request->oldImage_carabiner) {
                Storage::delete($request->oldImage_carabiner);
            }
            $validatedData['photo_carabiner'] = $request->file('photo_carabiner')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_straps_rope')) {
            if ($request->oldImage_straps_rope) {
                Storage::delete($request->oldImage_straps_rope);
            }
            $validatedData['photo_straps_rope'] = $request->file('photo_straps_rope')->store('checksheet-body-harnest');
        }

        if ($request->file('photo_shock_absorber')) {
            if ($request->oldImage_shock_absorber) {
                Storage::delete($request->oldImage_shock_absorber);
            }
            $validatedData['photo_shock_absorber'] = $request->file('photo_shock_absorber')->store('checksheet-body-harnest');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheetbodyharnest->update($validatedData);

        $bodyharnest = Bodyharnest::where('no_bodyharnest', $checkSheetbodyharnest->bodyharnest_number)->first();

        if (!$bodyharnest) {
            return back()->with('error', 'Body Harnest tidak ditemukan.');
        }

        return redirect()->route('body-harnest.show', $bodyharnest->id)->with('success1', 'Data Check Sheet Body Harnest berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheetbodyharnest = CheckSheetBodyHarnest::find($id);

        if ($checkSheetbodyharnest->photo_shoulder_straps || $checkSheetbodyharnest->photo_hook || $checkSheetbodyharnest->photo_buckles_waist || $checkSheetbodyharnest->photo_buckles_chest || $checkSheetbodyharnest->photo_leg_straps || $checkSheetbodyharnest->photo_buckles_leg || $checkSheetbodyharnest->photo_back_d_ring || $checkSheetbodyharnest->photo_carabiner || $checkSheetbodyharnest->photo_straps_rope || $checkSheetbodyharnest->photo_shock_absorber) {
            Storage::delete($checkSheetbodyharnest->photo_shoulder_straps);
            Storage::delete($checkSheetbodyharnest->photo_hook);
            Storage::delete($checkSheetbodyharnest->photo_buckles_waist);
            Storage::delete($checkSheetbodyharnest->photo_buckles_chest);
            Storage::delete($checkSheetbodyharnest->photo_leg_straps);
            Storage::delete($checkSheetbodyharnest->photo_buckles_leg);
            Storage::delete($checkSheetbodyharnest->photo_back_d_ring);
            Storage::delete($checkSheetbodyharnest->photo_carabiner);
            Storage::delete($checkSheetbodyharnest->photo_straps_rope);
            Storage::delete($checkSheetbodyharnest->photo_shock_absorber);
        }

        $checkSheetbodyharnest->delete();

        return back()->with('success1', 'Data Check Sheet Body Harnest berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheetbodyharnest = CheckSheetBodyHarnest::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.bodyharnest.checksheet.index', compact('checksheetbodyharnest'));
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $bodyharnestData = Bodyharnest::leftJoin('tt_check_sheet_body_harnests', 'tm_bodyharnests.no_bodyharnest', '=', 'tt_check_sheet_body_harnests.bodyharnest_number')
            ->select(
                'tm_bodyharnests.no_bodyharnest as bodyharnest_number',
                'tt_check_sheet_body_harnests.tanggal_pengecekan',
                'tt_check_sheet_body_harnests.shoulder_straps',
                'tt_check_sheet_body_harnests.hook',
                'tt_check_sheet_body_harnests.buckles_waist',
                'tt_check_sheet_body_harnests.buckles_chest',
                'tt_check_sheet_body_harnests.leg_straps',
                'tt_check_sheet_body_harnests.buckles_leg',
                'tt_check_sheet_body_harnests.back_d_ring',
                'tt_check_sheet_body_harnests.carabiner',
                'tt_check_sheet_body_harnests.straps_rope',
                'tt_check_sheet_body_harnests.shock_absorber',
            )
            ->get();


        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredBodyharnestData = $bodyharnestData->filter(function ($bodyharnest) use ($selectedYear) {
            return $bodyharnest->tanggal_pengecekan !== null &&
                date('Y', strtotime($bodyharnest->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedBodyharnestData = $filteredBodyharnestData->groupBy('bodyharnest_number')->map(function ($bodyharnestGroup) {
            $bodyharnestNumber = $bodyharnestGroup[0]['bodyharnest_number'];
            $bodyharnestPengecekan = $bodyharnestGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($bodyharnestGroup as $bodyharnest) {
                $month = date('n', strtotime($bodyharnest['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($bodyharnest['shoulder_straps'] === 'NG') $issueCodes[] = 'a';
                if ($bodyharnest['hook'] === 'NG') $issueCodes[] = 'b';
                if ($bodyharnest['buckles_waist'] === 'NG') $issueCodes[] = 'c';
                if ($bodyharnest['buckles_chest'] === 'NG') $issueCodes[] = 'd';
                if ($bodyharnest['leg_straps'] === 'NG') $issueCodes[] = 'e';
                if ($bodyharnest['buckles_leg'] === 'NG') $issueCodes[] = 'f';
                if ($bodyharnest['back_d_ring'] === 'NG') $issueCodes[] = 'g';
                if ($bodyharnest['carabiner'] === 'NG') $issueCodes[] = 'h';
                if ($bodyharnest['straps_rope'] === 'NG') $issueCodes[] = 'i';
                if ($bodyharnest['shock_absorber'] === 'NG') $issueCodes[] = 'j';

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }


                $months[$month] = $issueCodes;
            }

            return [
                'bodyharnest_number' => $bodyharnestNumber,
                'tanggal_pengecekan' => $bodyharnestPengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedBodyharnestData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('bodyharnest_data.json', $jsonString);

        return view('dashboard.bodyharnest_report', [
            'bodyharnestData' => $mappedBodyharnestData,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-bodyharnest.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $bodyharnestNumber = $request->input('bodyharnest_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');


        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetBodyHarnest::with('bodyharnests')
            ->select('tanggal_pengecekan', 'bodyharnest_number', 'shoulder_straps', 'hook', 'buckles_waist', 'buckles_chest', 'leg_straps', 'buckles_leg', 'back_d_ring', 'carabiner', 'shock_absorber')
            ->where(function ($query) use ($selectedYear, $bodyharnestNumber) {
                // Kondisi untuk memanggil data berdasarkan tahun dan tag_number
                $query->whereYear('tanggal_pengecekan', $selectedYear)
                    ->where('bodyharnest_number', $bodyharnestNumber);
            })
            // ->orWhere(function ($query) use ($selectedYear, $bodyharnestNumber) {
            //     // Kondisi untuk memanggil data bulan Januari tahun selanjutnya
            //     $query->whereMonth('tanggal_pengecekan', 1)
            //         ->whereYear('tanggal_pengecekan', $selectedYear + 1)
            //         ->where('bodyharnest_number', $bodyharnestNumber);
            // })
            ->get();


        // Quartal mapping ke kolom
        $quartalKolom = [
            1 => 'AQ',  // Quartal 1 -> Kolom Y
            2 => 'AT', // Quartal 2 -> Kolom AB
            3 => 'AW', // Quartal 3 -> Kolom AE
            4 => 'AN', // Quartal 4 -> Kolom AH
        ];

        $worksheet->setCellValue('AU' . 2, $data[0]->bodyharnest_number);
        $worksheet->setCellValue('AU' . 3, $data[0]->bodyharnests->locations->location_name);

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
            if ($item->shoulder_straps === 'OK') {
                $worksheet->setCellValue($col . 9, '√');
            } else if ($item->shoulder_straps === 'NG') {
                $worksheet->setCellValue($col . 9, 'X');
            }

            // Set value based on $item->hose
            if ($item->hook === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->hook === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->corong
            if ($item->buckles_waist === 'OK') {
                $worksheet->setCellValue($col . 15, '√');
            } else if ($item->buckles_waist === 'NG') {
                $worksheet->setCellValue($col . 15, 'X');
            }

            // Set value based on $item->tabung
            if ($item->buckles_chest === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->buckles_chest === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->regulator
            if ($item->leg_straps === 'OK') {
                $worksheet->setCellValue($col . 21, '√');
            } else if ($item->leg_straps === 'NG') {
                $worksheet->setCellValue($col . 21, 'X');
            }

            if ($item->buckles_leg === 'OK') {
                $worksheet->setCellValue($col . 24, '√');
            } else if ($item->buckles_leg === 'NG') {
                $worksheet->setCellValue($col . 24, 'X');
            }

            if ($item->back_d_ring === 'OK') {
                $worksheet->setCellValue($col . 27, '√');
            } else if ($item->back_d_ring === 'NG') {
                $worksheet->setCellValue($col . 27, 'X');
            }

            if ($item->carabiner === 'OK') {
                $worksheet->setCellValue($col . 30, '√');
            } else if ($item->carabiner === 'NG') {
                $worksheet->setCellValue($col . 30, 'X');
            }

            if ($item->straps_rope === 'OK') {
                $worksheet->setCellValue($col . 33, '√');
            } else if ($item->straps_rope === 'NG') {
                $worksheet->setCellValue($col . 33, 'X');
            }

            if ($item->shock_absorber === 'OK') {
                $worksheet->setCellValue($col . 36, '√');
            } else if ($item->shock_absorber === 'NG') {
                $worksheet->setCellValue($col . 36, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-body-harnest.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
