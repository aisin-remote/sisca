<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSlingBelt;
use App\Models\CheckSheetSlingWire;
use App\Models\Sling;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckSheetSlingBeltController extends Controller
{
    public function showForm($slingNumber)
    {
        $latestCheckSheetWires = CheckSheetSlingWire::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetBelts = CheckSheetSlingBelt::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetWires->merge($latestCheckSheetBelts);

        // Mencari entri Co2 berdasarkan no_tabung
        $sling = Sling::where('no_sling', $slingNumber)->first();

        if (!$sling) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('sling.show.form', compact('combinedLatestCheckSheets'))->with('error', 'Sling Number tidak ditemukan.');
        }

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Menghitung musim berdasarkan bulan saat ini
        if ($currentMonth >= 2 && $currentMonth <= 4) {
            // Musim 1 (Februari, Maret, April)
            $season = 1;
        } elseif ($currentMonth >= 5 && $currentMonth <= 7) {
            // Musim 2 (Mei, Juni, Juli)
            $season = 2;
        } elseif ($currentMonth >= 8 && $currentMonth <= 10) {
            // Musim 3 (Agustus, September, Oktober)
            $season = 3;
        } else {
            // Musim 4 (November, Desember, Januari tahun sebelumnya)
            $season = 4;
        }

        // Menghitung bulan awal musim untuk melakukan pengecekan
        if ($season == 1) {
            $startMonth = 2;
        } elseif ($season == 2) {
            $startMonth = 5;
        } elseif ($season == 3) {
            $startMonth = 8;
        } else {
            $startMonth = 11;
        }

        // Mencari entri CheckSheetSlingWire untuk sling_number tertentu dan 3 bulan musim tersebut
        $existingCheckSheet = CheckSheetSlingBelt::where('sling_number', $slingNumber)
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
                            ->whereMonth('created_at', '<=', $startMonth + 2);
                    });
                }
            })
            ->first();


        $slingNumber = strtoupper($slingNumber);

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('sling.checksheetbelt.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet sudah ada untuk Sling Belt ' . $slingNumber . ' pada triwulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetBelts = CheckSheetSlingBelt::all();
            return view('dashboard.sling.checksheet.checkBelt', compact('checkSheetBelts', 'slingNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Menghitung musim berdasarkan bulan saat ini
        if ($currentMonth >= 2 && $currentMonth <= 4) {
            // Musim 1 (Februari, Maret, April)
            $season = 1;
        } elseif ($currentMonth >= 5 && $currentMonth <= 7) {
            // Musim 2 (Mei, Juni, Juli)
            $season = 2;
        } elseif ($currentMonth >= 8 && $currentMonth <= 10) {
            // Musim 3 (Agustus, September, Oktober)
            $season = 3;
        } else {
            // Musim 4 (November, Desember, Januari tahun sebelumnya)
            $season = 4;
        }

        // Menghitung bulan awal musim untuk melakukan pengecekan
        if ($season == 1) {
            $startMonth = 2;
        } elseif ($season == 2) {
            $startMonth = 5;
        } elseif ($season == 3) {
            $startMonth = 8;
        } else {
            $startMonth = 11;
        }

        // Mencari entri CheckSheetSlingWire untuk sling_number tertentu dan 3 bulan musim tersebut
        $existingCheckSheet = CheckSheetSlingBelt::where('sling_number', $request->sling_number)
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
                            ->whereMonth('created_at', '<=', $startMonth + 2);
                    });
                }
            })
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'sling_number' => 'required',
                'kelengkapan_tag_sling_belt' => 'required',
                'catatan_kelengkapan_tag_sling_belt' => 'nullable|string|max:255',
                'photo_kelengkapan_tag_sling_belt' => 'required|image|file|max:3072',
                'bagian_pinggir_belt_robek' => 'required',
                'catatan_bagian_pinggir_belt_robek' => 'nullable|string|max:255',
                'photo_bagian_pinggir_belt_robek' => 'required|image|file|max:3072',
                'pengecekan_lapisan_belt_1' => 'required',
                'catatan_pengecekan_lapisan_belt_1' => 'nullable|string|max:255',
                'photo_pengecekan_lapisan_belt_1' => 'required|image|file|max:3072',
                'pengecekan_jahitan_belt' => 'required',
                'catatan_pengecekan_jahitan_belt' => 'nullable|string|max:255',
                'photo_pengecekan_jahitan_belt' => 'required|image|file|max:3072',
                'pengecekan_permukaan_belt' => 'required',
                'catatan_pengecekan_permukaan_belt' => 'nullable|string|max:255',
                'photo_pengecekan_permukaan_belt' => 'required|image|file|max:3072',
                'pengecekan_lapisan_belt_2' => 'required',
                'catatan_pengecekan_lapisan_belt_2' => 'nullable|string|max:255',
                'photo_pengecekan_lapisan_belt_2' => 'required|image|file|max:3072',
                'pengecekan_aus' => 'required',
                'catatan_pengecekan_aus' => 'nullable|string|max:255',
                'photo_pengecekan_aus' => 'required|image|file|max:3072',
                'hook_wire' => 'required',
                'catatan_hook_wire' => 'nullable|string|max:255',
                'photo_hook_wire' => 'required|image|file|max:3072',
                'pengunci_hook' => 'required',
                'catatan_pengunci_hook' => 'nullable|string|max:255',
                'photo_pengunci_hook' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['sling_number'] = strtoupper($validatedData['sling_number']);

            if ($request->file('photo_kelengkapan_tag_sling_belt') && $request->file('photo_bagian_pinggir_belt_robek') && $request->file('photo_pengecekan_lapisan_belt_1') && $request->file('photo_pengecekan_jahitan_belt') && $request->file('photo_pengecekan_permukaan_belt') && $request->file('photo_pengecekan_lapisan_belt_2') && $request->file('photo_pengecekan_aus') && $request->file('photo_hook_wire') && $request->file('photo_pengunci_hook')) {
                $validatedData['photo_kelengkapan_tag_sling_belt'] = $request->file('photo_kelengkapan_tag_sling_belt')->store('checksheet-sling-belt');
                $validatedData['photo_bagian_pinggir_belt_robek'] = $request->file('photo_bagian_pinggir_belt_robek')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_lapisan_belt_1'] = $request->file('photo_pengecekan_lapisan_belt_1')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_jahitan_belt'] = $request->file('photo_pengecekan_jahitan_belt')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_permukaan_belt'] = $request->file('photo_pengecekan_permukaan_belt')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_lapisan_belt_2'] = $request->file('photo_pengecekan_lapisan_belt_2')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_aus'] = $request->file('photo_pengecekan_aus')->store('checksheet-sling-belt');
                $validatedData['photo_hook_wire'] = $request->file('photo_hook_wire')->store('checksheet-sling-belt');
                $validatedData['photo_pengunci_hook'] = $request->file('photo_pengunci_hook')->store('checksheet-sling-belt');



                // Perbarui data entri yang sudah ada
                $existingCheckSheet->update($validatedData);

                return redirect()->route('sling.show.form')->with('success', 'Data berhasil diperbarui.');
            }
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'sling_number' => 'required',
                'kelengkapan_tag_sling_belt' => 'required',
                'catatan_kelengkapan_tag_sling_belt' => 'nullable|string|max:255',
                'photo_kelengkapan_tag_sling_belt' => 'required|image|file|max:3072',
                'bagian_pinggir_belt_robek' => 'required',
                'catatan_bagian_pinggir_belt_robek' => 'nullable|string|max:255',
                'photo_bagian_pinggir_belt_robek' => 'required|image|file|max:3072',
                'pengecekan_lapisan_belt_1' => 'required',
                'catatan_pengecekan_lapisan_belt_1' => 'nullable|string|max:255',
                'photo_pengecekan_lapisan_belt_1' => 'required|image|file|max:3072',
                'pengecekan_jahitan_belt' => 'required',
                'catatan_pengecekan_jahitan_belt' => 'nullable|string|max:255',
                'photo_pengecekan_jahitan_belt' => 'required|image|file|max:3072',
                'pengecekan_permukaan_belt' => 'required',
                'catatan_pengecekan_permukaan_belt' => 'nullable|string|max:255',
                'photo_pengecekan_permukaan_belt' => 'required|image|file|max:3072',
                'pengecekan_lapisan_belt_2' => 'required',
                'catatan_pengecekan_lapisan_belt_2' => 'nullable|string|max:255',
                'photo_pengecekan_lapisan_belt_2' => 'required|image|file|max:3072',
                'pengecekan_aus' => 'required',
                'catatan_pengecekan_aus' => 'nullable|string|max:255',
                'photo_pengecekan_aus' => 'required|image|file|max:3072',
                'hook_wire' => 'required',
                'catatan_hook_wire' => 'nullable|string|max:255',
                'photo_hook_wire' => 'required|image|file|max:3072',
                'pengunci_hook' => 'required',
                'catatan_pengunci_hook' => 'nullable|string|max:255',
                'photo_pengunci_hook' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['sling_number'] = strtoupper($validatedData['sling_number']);

            if ($request->file('photo_kelengkapan_tag_sling_belt') && $request->file('photo_bagian_pinggir_belt_robek') && $request->file('photo_pengecekan_lapisan_belt_1') && $request->file('photo_pengecekan_jahitan_belt') && $request->file('photo_pengecekan_permukaan_belt') && $request->file('photo_pengecekan_lapisan_belt_2') && $request->file('photo_pengecekan_aus') && $request->file('photo_hook_wire') && $request->file('photo_pengunci_hook')) {
                $validatedData['photo_kelengkapan_tag_sling_belt'] = $request->file('photo_kelengkapan_tag_sling_belt')->store('checksheet-sling-belt');
                $validatedData['photo_bagian_pinggir_belt_robek'] = $request->file('photo_bagian_pinggir_belt_robek')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_lapisan_belt_1'] = $request->file('photo_pengecekan_lapisan_belt_1')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_jahitan_belt'] = $request->file('photo_pengecekan_jahitan_belt')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_permukaan_belt'] = $request->file('photo_pengecekan_permukaan_belt')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_lapisan_belt_2'] = $request->file('photo_pengecekan_lapisan_belt_2')->store('checksheet-sling-belt');
                $validatedData['photo_pengecekan_aus'] = $request->file('photo_pengecekan_aus')->store('checksheet-sling-belt');
                $validatedData['photo_hook_wire'] = $request->file('photo_hook_wire')->store('checksheet-sling-belt');
                $validatedData['photo_pengunci_hook'] = $request->file('photo_pengunci_hook')->store('checksheet-sling-belt');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetSlingBelt::create($validatedData);

            return redirect()->route('sling.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function edit($id)
    {
        $checkSheetbelt = CheckSheetSlingBelt::findOrFail($id);
        return view('dashboard.sling.checksheetbelt.edit', compact('checkSheetbelt'));
    }
}
