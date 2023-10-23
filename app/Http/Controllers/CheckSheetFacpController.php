<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetFacp;
use App\Models\Facp;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
