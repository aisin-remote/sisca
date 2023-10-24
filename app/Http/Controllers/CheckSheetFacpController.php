<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetFacp;
use App\Models\Facp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckSheetFacpController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetFacps = CheckSheetFacp::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.facp.checksheet.check', compact('latestCheckSheetFacps'));
    }

    public function processForm(Request $request)
    {
        $facpNumber = $request->input('zona_number');

        $facp = Facp::where('zona', $facpNumber)->first();

        if (!$facp) {
            return back()->with('error', 'Zona Number tidak ditemukan.');
        }

        $facpNumber = strtoupper($facpNumber);

        return redirect()->route('checksheetfacp', compact('facpNumber'));
    }

    public function createForm($facpNumber)
    {
        $latestCheckSheetFacps = CheckSheetFacp::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $facp = Facp::where('zona', $facpNumber)->first();

        if (!$facp) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('facp.show.form', compact('latestCheckSheetFacps'))->with('error', 'Zona Number tidak ditemukan.');
        }

        $facpNumber = strtoupper($facpNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month; // Mengatur $currentMonth menjadi Januari
        $currentYear = Carbon::now()->year; // Mengatur $currentYear menjadi 2024


        // Menghitung musim berdasarkan bulan saat ini
        if ($currentMonth >= 5 && $currentMonth <= 10) {
            // Musim 1 (Februari, Maret, April)
            $season = 1;
        } else {
            // Musim 4 (November, Desember, Januari tahun sebelumnya)
            $season = 2;
        }

        // Menghitung bulan awal musim untuk melakukan pengecekan
        if ($season == 1) {
            $startMonth = 5;
        } else {
            $startMonth = 11;
        }

        // Mencari entri CheckSheetSlingWire untuk sling_number tertentu dan 3 bulan musim tersebut
        $existingCheckSheet = CheckSheetFacp::where('zona_number', $facpNumber)
            ->where(function ($query) use ($currentYear, $currentMonth, $startMonth, $season) {

                if ($season == 2) {
                    $query->where(function ($q) use ($currentYear, $startMonth) {
                        $q->whereYear('created_at', $currentYear - 1)
                            ->whereMonth('created_at', '=', $startMonth);
                    });
                } else {
                    // Untuk musim lainnya, mencari data pada tahun ini
                    $query->where(function ($q) use ($currentYear, $startMonth) {
                        $q->whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', '>=', $startMonth)
                            ->whereMonth('created_at', '<=', $startMonth + 5);
                    });
                }
            })
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('facp.checksheetfacp.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet FACP sudah ada untuk zona ' . $facpNumber . ' pada 1 Semester ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetFacps = CheckSheetFacp::all();
            return view('dashboard.facp.checksheet.checkFacp', compact('checkSheetFacps', 'facpNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Menghitung musim berdasarkan bulan saat ini
        if ($currentMonth >= 5 && $currentMonth <= 10) {
            // Musim 1 (Februari, Maret, April)
            $season = 1;
        } else {
            // Musim 4 (November, Desember, Januari tahun sebelumnya)
            $season = 2;
        }

        // Menghitung bulan awal musim untuk melakukan pengecekan
        if ($season == 1) {
            $startMonth = 5;
        } else {
            $startMonth = 11;
        }

        // Mencari entri CheckSheetSlingWire untuk sling_number tertentu dan 3 bulan musim tersebut
        $existingCheckSheet = CheckSheetFacp::where('zona_number', $request->zona_number)
            ->where(function ($query) use ($currentYear, $startMonth, $season) {
                if ($season == 4) {
                    // Jika musim 4, mencari data pada tahun sebelumnya
                    $query->where(function ($q) use ($currentYear, $startMonth) {
                        $q->whereYear('created_at', $currentYear - 1)
                            ->whereMonth('created_at', '=', $startMonth);
                    });
                } else {
                    // Untuk musim lainnya, mencari data pada tahun ini
                    $query->where(function ($q) use ($currentYear, $startMonth) {
                        $q->whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', '>=', $startMonth)
                            ->whereMonth('created_at', '<=', $startMonth + 5);
                    });
                }
            })
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'zona_number' => 'required',
                'ok_smoke_detector' => 'required',
                'ng_smoke_detector' => 'nullable',
                'catatan_smoke_detector' => 'nullable|string|max:255',
                'photo_smoke_detector' => 'nullable|image|file|max:3072',
                'ok_heat_detector' => 'required',
                'ng_heat_detector' => 'nullable',
                'catatan_heat_detector' => 'nullable|string|max:255',
                'photo_heat_detector' => 'nullable|image|file|max:3072',
                'ok_beam_detector' => 'required',
                'ng_beam_detector' => 'nullable',
                'catatan_beam_detector' => 'nullable|string|max:255',
                'photo_beam_detector' => 'nullable|image|file|max:3072',
                'ok_push_button' => 'required',
                'ng_push_button' => 'nullable',
                'catatan_push_button' => 'nullable|string|max:255',
                'photo_push_button' => 'nullable|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            // Sebelum validasi atau jika validasi gagal
            if (empty($validatedData['ng_smoke_detector'])) {
                $validatedData['ng_smoke_detector'] = 0;
            }
            if (empty($validatedData['ng_heat_detector'])) {
                $validatedData['ng_heat_detector'] = 0;
            }
            if (empty($validatedData['ng_beam_detector'])) {
                $validatedData['ng_beam_detector'] = 0;
            }
            if (empty($validatedData['ng_push_button'])) {
                $validatedData['ng_push_button'] = 0;
            }

            if ($request->file('photo_smoke_detector') && $request->file('photo_heat_detector') && $request->file('photo_beam_detector') && $request->file('photo_push_button')) {
                $validatedData['photo_smoke_detector'] = $request->file('photo_smoke_detector')->store('checksheet-facp');
                $validatedData['photo_heat_detector'] = $request->file('photo_heat_detector')->store('checksheet-facp');
                $validatedData['photo_beam_detector'] = $request->file('photo_beam_detector')->store('checksheet-facp');
                $validatedData['photo_push_button'] = $request->file('photo_push_button')->store('checksheet-facp');

                // Perbarui data entri yang sudah ada
                $existingCheckSheet->update($validatedData);

                return redirect()->route('facp.show.form')->with('success', 'Data berhasil diperbarui.');
            }
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'zona_number' => 'required',
                'ok_smoke_detector' => 'required',
                'ng_smoke_detector' => 'nullable',
                'catatan_smoke_detector' => 'nullable|string|max:255',
                'photo_smoke_detector' => 'nullable|image|file|max:3072',
                'ok_heat_detector' => 'required',
                'ng_heat_detector' => 'nullable',
                'catatan_heat_detector' => 'nullable|string|max:255',
                'photo_heat_detector' => 'nullable|image|file|max:3072',
                'ok_beam_detector' => 'required',
                'ng_beam_detector' => 'nullable',
                'catatan_beam_detector' => 'nullable|string|max:255',
                'photo_beam_detector' => 'nullable|image|file|max:3072',
                'ok_push_button' => 'required',
                'ng_push_button' => 'nullable',
                'catatan_push_button' => 'nullable|string|max:255',
                'photo_push_button' => 'nullable|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['zona_number'] = strtoupper($validatedData['zona_number']);

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $tanggalPengecekan = Carbon::parse($validatedData['tanggal_pengecekan']);
            $bulan = $tanggalPengecekan->month;

            // Tentukan tanggal awal kuartal berdasarkan bulan
            if ($bulan >= 5 && $bulan <= 10) {
                $tanggalAwalKuartal = Carbon::create($tanggalPengecekan->year, 5, 1); // Kuartal 1
            } else {
                // Jika bulan di luar kuartal, maka masuk ke kuartal 4
                $tanggalAwalKuartal = Carbon::create($tanggalPengecekan->year, 11, 1); // Kuartal 4

                // Jika bulan adalah Januari, kurangi tahun sebelumnya
                if ($bulan >= 1 && $bulan <= 4) {
                    $tanggalAwalKuartal->subYear();
                }
            }

            // Sebelum validasi atau jika validasi gagal
            if (empty($validatedData['ng_smoke_detector'])) {
                $validatedData['ng_smoke_detector'] = 0;
            }
            if (empty($validatedData['ng_heat_detector'])) {
                $validatedData['ng_heat_detector'] = 0;
            }
            if (empty($validatedData['ng_beam_detector'])) {
                $validatedData['ng_beam_detector'] = 0;
            }
            if (empty($validatedData['ng_push_button'])) {
                $validatedData['ng_push_button'] = 0;
            }

            // Set tanggal_pengecekan sesuai dengan tanggal awal kuartal
            $validatedData['tanggal_pengecekan'] = $tanggalAwalKuartal;

            if ($request->file('photo_smoke_detector') && $request->file('photo_heat_detector') && $request->file('photo_beam_detector') && $request->file('photo_push_button')) {
                $validatedData['photo_smoke_detector'] = $request->file('photo_smoke_detector')->store('checksheet-facp');
                $validatedData['photo_heat_detector'] = $request->file('photo_heat_detector')->store('checksheet-facp');
                $validatedData['photo_beam_detector'] = $request->file('photo_beam_detector')->store('checksheet-facp');
                $validatedData['photo_push_button'] = $request->file('photo_push_button')->store('checksheet-facp');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetFacp::create($validatedData);

            return redirect()->route('facp.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetFacp::findOrFail($id);

        return view('dashboard.facp.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheetfacp = CheckSheetFacp::findOrFail($id);
        return view('dashboard.facp.checksheet.edit', compact('checkSheetfacp'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetfacp = CheckSheetFacp::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'ok_smoke_detector' => 'required',
            'ng_smoke_detector' => 'nullable',
            'catatan_smoke_detector' => 'nullable|string|max:255',
            'photo_smoke_detector' => 'nullable|image|file|max:3072',
            'ok_heat_detector' => 'required',
            'ng_heat_detector' => 'nullable',
            'catatan_heat_detector' => 'nullable|string|max:255',
            'photo_heat_detector' => 'nullable|image|file|max:3072',
            'ok_beam_detector' => 'required',
            'ng_beam_detector' => 'nullable',
            'catatan_beam_detector' => 'nullable|string|max:255',
            'photo_beam_detector' => 'nullable|image|file|max:3072',
            'ok_push_button' => 'required',
            'ng_push_button' => 'nullable',
            'catatan_push_button' => 'nullable|string|max:255',
            'photo_push_button' => 'nullable|image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_smoke_detector')) {
            if ($request->oldImage_smoke_detector) {
                Storage::delete($request->oldImage_smoke_detector);
            }
            $validatedData['photo_smoke_detector'] = $request->file('photo_smoke_detector')->store('checksheet-facp');
        }

        if ($request->file('photo_heat_detector')) {
            if ($request->oldImage_heat_detector) {
                Storage::delete($request->oldImage_heat_detector);
            }
            $validatedData['photo_heat_detector'] = $request->file('photo_heat_detector')->store('checksheet-facp');
        }

        if ($request->file('photo_beam_detector')) {
            if ($request->oldImage_beam_detector) {
                Storage::delete($request->oldImage_beam_detector);
            }
            $validatedData['photo_beam_detector'] = $request->file('photo_beam_detector')->store('checksheet-facp');
        }

        if ($request->file('photo_push_button')) {
            if ($request->oldImage_push_button) {
                Storage::delete($request->oldImage_push_button);
            }
            $validatedData['photo_push_button'] = $request->file('photo_push_button')->store('checksheet-facp');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheetfacp->update($validatedData);

        $facp = Facp::where('zona', $checkSheetfacp->zona_number)->first();

        if (!$facp) {
            return back()->with('error', 'FACP tidak ditemukan.');
        }

        return redirect()->route('facp.show', $facp->id)->with('success1', 'Data Check Sheet FACP berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheetfacp = CheckSheetFacp::find($id);

        if ($checkSheetfacp->photo_smoke_detector || $checkSheetfacp->photo_heat_detector || $checkSheetfacp->photo_beam_detector || $checkSheetfacp->photo_push_button) {
            Storage::delete($checkSheetfacp->photo_smoke_detector);
            Storage::delete($checkSheetfacp->photo_heat_detector);
            Storage::delete($checkSheetfacp->photo_beam_detector);
            Storage::delete($checkSheetfacp->photo_push_button);
        }

        $checkSheetfacp->delete();

        return back()->with('success1', 'Data Check Sheet FACP berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheetfacp = CheckSheetFacp::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.facp.checksheet.index', compact('checksheetfacp'));
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $facpData = Facp::leftJoin('tt_check_sheet_facps', 'tm_facps.zona', '=', 'tt_check_sheet_facps.zona_number')
            ->select(
                'tm_facps.zona as zona_number',
                'tt_check_sheet_facps.tanggal_pengecekan',
                'tt_check_sheet_facps.ok_smoke_detector',
                'tt_check_sheet_facps.ng_smoke_detector',
                'tt_check_sheet_facps.ok_heat_detector',
                'tt_check_sheet_facps.ng_heat_detector',
                'tt_check_sheet_facps.ok_beam_detector',
                'tt_check_sheet_facps.ng_beam_detector',
                'tt_check_sheet_facps.ok_push_button',
                'tt_check_sheet_facps.ng_push_button',
            )
            ->get();


        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredFacpData = $facpData->filter(function ($facp) use ($selectedYear) {
            return $facp->tanggal_pengecekan !== null &&
                date('Y', strtotime($facp->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedFacpData = $filteredFacpData->groupBy('zona_number')->map(function ($facpGroup) {
            $facpNumber = $facpGroup[0]['zona_number'];
            $facpPengecekan = $facpGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($facpGroup as $facp) {
                $month = date('n', strtotime($facp['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($facp['ng_smoke_detector'] !== '0') $issueCodes[] = 'a';
                if ($facp['ng_heat_detector'] !== '0') $issueCodes[] = 'b';
                if ($facp['ng_beam_detector'] !== '0') $issueCodes[] = 'c';
                if ($facp['ng_push_button'] !== '0') $issueCodes[] = 'd';

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }

                $months[$month] = $issueCodes;
            }

            return [
                'zona_number' => $facpNumber,
                'tanggal_pengecekan' => $facpPengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedFacpData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('facp_data.json', $jsonString);

        return view('dashboard.facp_report', [
            'facpData' => $mappedFacpData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
