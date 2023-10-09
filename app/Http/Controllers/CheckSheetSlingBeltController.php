<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSlingBelt;
use App\Models\CheckSheetSlingWire;
use App\Models\Sling;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function update(Request $request, $id)
    {
        $checkSheetbelt = CheckSheetSlingBelt::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'kelengkapan_tag_sling_belt' => 'required',
            'catatan_kelengkapan_tag_sling_belt' => 'nullable|string|max:255',
            'photo_kelengkapan_tag_sling_belt' => 'image|file|max:3072',
            'bagian_pinggir_belt_robek' => 'required',
            'catatan_bagian_pinggir_belt_robek' => 'nullable|string|max:255',
            'photo_bagian_pinggir_belt_robek' => 'image|file|max:3072',
            'pengecekan_lapisan_belt_1' => 'required',
            'catatan_pengecekan_lapisan_belt_1' => 'nullable|string|max:255',
            'photo_pengecekan_lapisan_belt_1' => 'image|file|max:3072',
            'pengecekan_jahitan_belt' => 'required',
            'catatan_pengecekan_jahitan_belt' => 'nullable|string|max:255',
            'photo_pengecekan_jahitan_belt' => 'image|file|max:3072',
            'pengecekan_permukaan_belt' => 'required',
            'catatan_pengecekan_permukaan_belt' => 'nullable|string|max:255',
            'photo_pengecekan_permukaan_belt' => 'image|file|max:3072',
            'pengecekan_lapisan_belt_2' => 'required',
            'catatan_pengecekan_lapisan_belt_2' => 'nullable|string|max:255',
            'photo_pengecekan_lapisan_belt_2' => 'image|file|max:3072',
            'pengecekan_aus' => 'required',
            'catatan_pengecekan_aus' => 'nullable|string|max:255',
            'photo_pengecekan_aus' => 'image|file|max:3072',
            'hook_wire' => 'required',
            'catatan_hook_wire' => 'nullable|string|max:255',
            'photo_hook_wire' => 'image|file|max:3072',
            'pengunci_hook' => 'required',
            'catatan_pengunci_hook' => 'nullable|string|max:255',
            'photo_pengunci_hook' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_kelengkapan_tag_sling_belt')) {
            if ($request->oldImage_kelengkapan_tag_sling_belt) {
                Storage::delete($request->oldImage_kelengkapan_tag_sling_belt);
            }
            $validatedData['photo_kelengkapan_tag_sling_belt'] = $request->file('photo_kelengkapan_tag_sling_belt')->store('checksheet-sling-belt');
        }

        if ($request->file('photo_bagian_pinggir_belt_robek')) {
            if ($request->oldImage_bagian_pinggir_belt_robek) {
                Storage::delete($request->oldImage_bagian_pinggir_belt_robek);
            }
            $validatedData['photo_bagian_pinggir_belt_robek'] = $request->file('photo_bagian_pinggir_belt_robek')->store('checksheet-sling-belt');
        }

        if ($request->file('photo_pengecekan_lapisan_belt_1')) {
            if ($request->oldImage_pengecekan_lapisan_belt_1) {
                Storage::delete($request->oldImage_pengecekan_lapisan_belt_1);
            }
            $validatedData['photo_pengecekan_lapisan_belt_1'] = $request->file('photo_pengecekan_lapisan_belt_1')->store('checksheet-sling-belt');
        }

        if ($request->file('photo_pengecekan_jahitan_belt')) {
            if ($request->oldImage_pengecekan_jahitan_belt) {
                Storage::delete($request->oldImage_pengecekan_jahitan_belt);
            }
            $validatedData['photo_pengecekan_jahitan_belt'] = $request->file('photo_pengecekan_jahitan_belt')->store('checksheet-sling-belt');
        }

        if ($request->file('photo_pengecekan_permukaan_belt')) {
            if ($request->oldImage_pengecekan_permukaan_belt) {
                Storage::delete($request->oldImage_pengecekan_permukaan_belt);
            }
            $validatedData['photo_pengecekan_permukaan_belt'] = $request->file('photo_pengecekan_permukaan_belt')->store('checksheet-sling-belt');
        }

        if ($request->file('photo_pengecekan_lapisan_belt_2')) {
            if ($request->oldImage_pengecekan_lapisan_belt_2) {
                Storage::delete($request->oldImage_pengecekan_lapisan_belt_2);
            }
            $validatedData['photo_pengecekan_lapisan_belt_2'] = $request->file('photo_pengecekan_lapisan_belt_2')->store('checksheet-sling-belt');
        }

        if ($request->file('photo_pengecekan_aus')) {
            if ($request->oldImage_pengecekan_aus) {
                Storage::delete($request->oldImage_pengecekan_aus);
            }
            $validatedData['photo_pengecekan_aus'] = $request->file('photo_pengecekan_aus')->store('checksheet-sling-belt');
        }

        if ($request->file('photo_hook_wire')) {
            if ($request->oldImage_hook_wire) {
                Storage::delete($request->oldImage_hook_wire);
            }
            $validatedData['photo_hook_wire'] = $request->file('photo_hook_wire')->store('checksheet-sling-belt');
        }

        if ($request->file('photo_pengunci_hook')) {
            if ($request->oldImage_pengunci_hook) {
                Storage::delete($request->oldImage_pengunci_hook);
            }
            $validatedData['photo_pengunci_hook'] = $request->file('photo_pengunci_hook')->store('checksheet-sling-belt');
        }

        // Update data CheckSheetIndoor dengan data baru dari form
        $checkSheetbelt->update($validatedData);

        $sling = Sling::where('no_sling', $checkSheetbelt->sling_number)->first();

        if (!$sling) {
            return back()->with('error', 'Sling tidak ditemukan.');
        }

        return redirect()->route('sling.show', $sling->id)->with('success1', 'Data Check Sheet Sling Belt berhasil diperbarui.');
    }

    public function show($id)
    {
        $checksheet = CheckSheetSlingBelt::findOrFail($id);

        return view('dashboard.sling.checksheet.show', compact('checksheet'));
    }

    public function destroy($id)
    {
        $checkSheetbelt = CheckSheetSlingBelt::find($id);

        if ($checkSheetbelt->photo_kelengkapan_tag_sling_belt || $checkSheetbelt->photo_bagian_pinggir_belt_robek || $checkSheetbelt->photo_pengecekan_lapisan_belt_1 || $checkSheetbelt->photo_pengecekan_jahitan_belt || $checkSheetbelt->photo_pengecekan_permukaan_belt || $checkSheetbelt->photo_pengecekan_lapisan_belt_2 || $checkSheetbelt->photo_pengecekan_aus || $checkSheetbelt->photo_hook_wire || $checkSheetbelt->photo_pengunci_hook) {
            Storage::delete($checkSheetbelt->photo_kelengkapan_tag_sling_belt);
            Storage::delete($checkSheetbelt->photo_bagian_pinggir_belt_robek);
            Storage::delete($checkSheetbelt->photo_pengecekan_lapisan_belt_1);
            Storage::delete($checkSheetbelt->photo_pengecekan_jahitan_belt);
            Storage::delete($checkSheetbelt->photo_pengecekan_permukaan_belt);
            Storage::delete($checkSheetbelt->photo_pengecekan_lapisan_belt_2);
            Storage::delete($checkSheetbelt->photo_pengecekan_aus);
            Storage::delete($checkSheetbelt->photo_hook_wire);
            Storage::delete($checkSheetbelt->photo_pengunci_hook);
        }

        $checkSheetbelt->delete();

        return back()->with('success1', 'Data Check Sheet Sling Belt berhasil dihapus');
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-belt.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $slingNumber = $request->input('sling_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');


        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetSlingBelt::with('slings')
            ->select('tanggal_pengecekan', 'sling_number', 'kelengkapan_tag_sling_belt', 'bagian_pinggir_belt_robek', 'pengecekan_lapisan_belt_1', 'pengecekan_jahitan_belt', 'pengecekan_permukaan_belt', 'pengecekan_lapisan_belt_2', 'pengecekan_aus', 'hook_wire', 'pengunci_hook')
            ->where(function ($query) use ($selectedYear, $slingNumber) {
                // Kondisi untuk memanggil data berdasarkan tahun dan tag_number
                $query->whereYear('tanggal_pengecekan', $selectedYear)
                    ->where('sling_number', $slingNumber);
            })
            ->orWhere(function ($query) use ($selectedYear, $slingNumber) {
                // Kondisi untuk memanggil data bulan Januari tahun selanjutnya
                $query->whereMonth('tanggal_pengecekan', 1)
                    ->whereYear('tanggal_pengecekan', $selectedYear + 1)
                    ->where('sling_number', $slingNumber);
            })
            ->get();


        // Quartal mapping ke kolom
        $quartalKolom = [
            1 => 'Y',  // Quartal 1 -> Kolom Y
            2 => 'AB', // Quartal 2 -> Kolom AB
            3 => 'AE', // Quartal 3 -> Kolom AE
            4 => 'AH', // Quartal 4 -> Kolom AH
        ];

        $worksheet->setCellValue('X' . 4, $data[0]->slings->plant);
        $worksheet->setCellValue('AA' . 4, $data[0]->slings->locations->location_name);
        $worksheet->setCellValue('AD' . 4, $data[0]->sling_number);
        $worksheet->setCellValue('AG' . 4, $data[0]->slings->swl);

        foreach ($data as $item) {

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $bulan = Carbon::parse($item->tanggal_pengecekan)->month;

            if ($bulan >= 2 && $bulan <= 4) {
                $quartal = 1;
            } elseif ($bulan >= 5 && $bulan <= 7) {
                $quartal = 2;
            } elseif ($bulan >= 8 && $bulan <= 10) {
                $quartal = 3;
            } else {
                $quartal = 4;
            }



            // Tentukan kolom berdasarkan bulan
            $col = $quartalKolom[$quartal];

            // Set value based on $item->pressure
            if ($item->kelengkapan_tag_sling_belt === 'OK') {
                $worksheet->setCellValue($col . 9, '√');
            } else if ($item->kelengkapan_tag_sling_belt === 'NG') {
                $worksheet->setCellValue($col . 9, 'X');
            }

            // Set value based on $item->hose
            if ($item->bagian_pinggir_belt_robek === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->bagian_pinggir_belt_robek === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->corong
            if ($item->pengecekan_lapisan_belt_1 === 'OK') {
                $worksheet->setCellValue($col . 15, '√');
            } else if ($item->pengecekan_lapisan_belt_1 === 'NG') {
                $worksheet->setCellValue($col . 15, 'X');
            }

            // Set value based on $item->tabung
            if ($item->pengecekan_jahitan_belt === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->pengecekan_jahitan_belt === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->regulator
            if ($item->pengecekan_permukaan_belt === 'OK') {
                $worksheet->setCellValue($col . 21, '√');
            } else if ($item->pengecekan_permukaan_belt === 'NG') {
                $worksheet->setCellValue($col . 21, 'X');
            }

            if ($item->pengecekan_lapisan_belt_2 === 'OK') {
                $worksheet->setCellValue($col . 24, '√');
            } else if ($item->pengecekan_lapisan_belt_2 === 'NG') {
                $worksheet->setCellValue($col . 24, 'X');
            }

            if ($item->pengecekan_aus === 'OK') {
                $worksheet->setCellValue($col . 27, '√');
            } else if ($item->pengecekan_aus === 'NG') {
                $worksheet->setCellValue($col . 27, 'X');
            }

            if ($item->hook_wire === 'OK') {
                $worksheet->setCellValue($col . 30, '√');
            } else if ($item->hook_wire === 'NG') {
                $worksheet->setCellValue($col . 30, 'X');
            }

            if ($item->pengunci_hook === 'OK') {
                $worksheet->setCellValue($col . 33, '√');
            } else if ($item->pengunci_hook === 'NG') {
                $worksheet->setCellValue($col . 33, 'X');
            }

            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-sling-belt.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
