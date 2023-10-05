<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSlingBelt;
use App\Models\CheckSheetSlingWire;
use App\Models\Sling;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;



class CheckSheetSlingWireController extends Controller
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
        $existingCheckSheet = CheckSheetSlingWire::where('sling_number', $slingNumber)
            ->where(function ($query) use ($currentYear, $currentMonth, $startMonth, $season) {
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
            return redirect()->route('sling.checksheetwire.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet sudah ada untuk Sling Wire ' . $slingNumber . ' pada triwulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetWires = CheckSheetSlingWire::all();
            return view('dashboard.sling.checksheet.checkWire', compact('checkSheetWires', 'slingNumber'));
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
        $existingCheckSheet = CheckSheetSlingWire::where('sling_number', $request->sling_number)
            ->where(function ($query) use ($currentYear, $currentMonth, $startMonth, $season) {
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
                'serabut_wire' => 'required',
                'catatan_serabut_wire' => 'nullable|string|max:255',
                'photo_serabut_wire' => 'required|image|file|max:3072',
                'bagian_wire_1' => 'required',
                'catatan_bagian_wire_1' => 'nullable|string|max:255',
                'photo_bagian_wire_1' => 'required|image|file|max:3072',
                'bagian_wire_2' => 'required',
                'catatan_bagian_wire_2' => 'nullable|string|max:255',
                'photo_bagian_wire_2' => 'required|image|file|max:3072',
                'kumpulan_wire_1' => 'required',
                'catatan_kumpulan_wire_1' => 'nullable|string|max:255',
                'photo_kumpulan_wire_1' => 'required|image|file|max:3072',
                'diameter_wire' => 'required',
                'catatan_diameter_wire' => 'nullable|string|max:255',
                'photo_diameter_wire' => 'required|image|file|max:3072',
                'kumpulan_wire_2' => 'required',
                'catatan_kumpulan_wire_2' => 'nullable|string|max:255',
                'photo_kumpulan_wire_2' => 'required|image|file|max:3072',
                'hook_wire' => 'required',
                'catatan_hook_wire' => 'nullable|string|max:255',
                'photo_hook_wire' => 'required|image|file|max:3072',
                'pengunci_hook' => 'required',
                'catatan_pengunci_hook' => 'nullable|string|max:255',
                'photo_pengunci_hook' => 'required|image|file|max:3072',
                'mata_sling' => 'required',
                'catatan_mata_sling' => 'nullable|string|max:255',
                'photo_mata_sling' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['sling_number'] = strtoupper($validatedData['sling_number']);

            if ($request->file('photo_serabut_wire') && $request->file('photo_bagian_wire_1') && $request->file('photo_bagian_wire_2') && $request->file('photo_kumpulan_wire_1') && $request->file('photo_diameter_wire') && $request->file('photo_kumpulan_wire_2') && $request->file('photo_hook_wire') && $request->file('photo_pengunci_hook') && $request->file('photo_mata_sling')) {
                $validatedData['photo_serabut_wire'] = $request->file('photo_serabut_wire')->store('checksheet-sling-wire');
                $validatedData['photo_bagian_wire_1'] = $request->file('photo_bagian_wire_1')->store('checksheet-sling-wire');
                $validatedData['photo_bagian_wire_2'] = $request->file('photo_bagian_wire_2')->store('checksheet-sling-wire');
                $validatedData['photo_kumpulan_wire_1'] = $request->file('photo_kumpulan_wire_1')->store('checksheet-sling-wire');
                $validatedData['photo_diameter_wire'] = $request->file('photo_diameter_wire')->store('checksheet-sling-wire');
                $validatedData['photo_kumpulan_wire_2'] = $request->file('photo_kumpulan_wire_2')->store('checksheet-sling-wire');
                $validatedData['photo_hook_wire'] = $request->file('photo_hook_wire')->store('checksheet-sling-wire');
                $validatedData['photo_pengunci_hook'] = $request->file('photo_pengunci_hook')->store('checksheet-sling-wire');
                $validatedData['photo_mata_sling'] = $request->file('photo_mata_sling')->store('checksheet-sling-wire');



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
                'serabut_wire' => 'required',
                'catatan_serabut_wire' => 'nullable|string|max:255',
                'photo_serabut_wire' => 'required|image|file',
                'bagian_wire_1' => 'required',
                'catatan_bagian_wire_1' => 'nullable|string|max:255',
                'photo_bagian_wire_1' => 'required|image|file',
                'bagian_wire_2' => 'required',
                'catatan_bagian_wire_2' => 'nullable|string|max:255',
                'photo_bagian_wire_2' => 'required|image|file',
                'kumpulan_wire_1' => 'required',
                'catatan_kumpulan_wire_1' => 'nullable|string|max:255',
                'photo_kumpulan_wire_1' => 'required|image|file',
                'diameter_wire' => 'required',
                'catatan_diameter_wire' => 'nullable|string|max:255',
                'photo_diameter_wire' => 'required|image|file',
                'kumpulan_wire_2' => 'required',
                'catatan_kumpulan_wire_2' => 'nullable|string|max:255',
                'photo_kumpulan_wire_2' => 'required|image|file',
                'hook_wire' => 'required',
                'catatan_hook_wire' => 'nullable|string|max:255',
                'photo_hook_wire' => 'required|image|file',
                'pengunci_hook' => 'required',
                'catatan_pengunci_hook' => 'nullable|string|max:255',
                'photo_pengunci_hook' => 'required|image|file',
                'mata_sling' => 'required',
                'catatan_mata_sling' => 'nullable|string|max:255',
                'photo_mata_sling' => 'required|image|file',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['sling_number'] = strtoupper($validatedData['sling_number']);

            if ($request->file('photo_serabut_wire') && $request->file('photo_bagian_wire_1') && $request->file('photo_bagian_wire_2') && $request->file('photo_kumpulan_wire_1') && $request->file('photo_diameter_wire') && $request->file('photo_kumpulan_wire_2') && $request->file('photo_hook_wire') && $request->file('photo_pengunci_hook') && $request->file('photo_mata_sling')) {
                $validatedData['photo_serabut_wire'] = $request->file('photo_serabut_wire')->store('checksheet-sling-wire');
                $validatedData['photo_bagian_wire_1'] = $request->file('photo_bagian_wire_1')->store('checksheet-sling-wire');
                $validatedData['photo_bagian_wire_2'] = $request->file('photo_bagian_wire_2')->store('checksheet-sling-wire');
                $validatedData['photo_kumpulan_wire_1'] = $request->file('photo_kumpulan_wire_1')->store('checksheet-sling-wire');
                $validatedData['photo_diameter_wire'] = $request->file('photo_diameter_wire')->store('checksheet-sling-wire');
                $validatedData['photo_kumpulan_wire_2'] = $request->file('photo_kumpulan_wire_2')->store('checksheet-sling-wire');
                $validatedData['photo_hook_wire'] = $request->file('photo_hook_wire')->store('checksheet-sling-wire');
                $validatedData['photo_pengunci_hook'] = $request->file('photo_pengunci_hook')->store('checksheet-sling-wire');
                $validatedData['photo_mata_sling'] = $request->file('photo_mata_sling')->store('checksheet-sling-wire');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetSlingWire::create($validatedData);

            return redirect()->route('sling.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function edit($id)
    {
        $checkSheetwire = CheckSheetSlingWire::findOrFail($id);
        return view('dashboard.sling.checksheetwire.edit', compact('checkSheetwire'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetwire = CheckSheetSlingWire::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'serabut_wire' => 'required',
            'catatan_serabut_wire' => 'nullable|string|max:255',
            'photo_serabut_wire' => 'image|file|max:3072',
            'bagian_wire_1' => 'required',
            'catatan_bagian_wire_1' => 'nullable|string|max:255',
            'photo_bagian_wire_1' => 'image|file|max:3072',
            'bagian_wire_2' => 'required',
            'catatan_bagian_wire_2' => 'nullable|string|max:255',
            'photo_bagian_wire_2' => 'image|file|max:3072',
            'kumpulan_wire_1' => 'required',
            'catatan_kumpulan_wire_1' => 'nullable|string|max:255',
            'photo_kumpulan_wire_1' => 'image|file|max:3072',
            'diameter_wire' => 'required',
            'catatan_diameter_wire' => 'nullable|string|max:255',
            'photo_diameter_wire' => 'image|file|max:3072',
            'kumpulan_wire_2' => 'required',
            'catatan_kumpulan_wire_2' => 'nullable|string|max:255',
            'photo_kumpulan_wire_2' => 'image|file|max:3072',
            'hook_wire' => 'required',
            'catatan_hook_wire' => 'nullable|string|max:255',
            'photo_hook_wire' => 'image|file|max:3072',
            'pengunci_hook' => 'required',
            'catatan_pengunci_hook' => 'nullable|string|max:255',
            'photo_pengunci_hook' => 'image|file|max:3072',
            'mata_sling' => 'required',
            'catatan_mata_sling' => 'nullable|string|max:255',
            'photo_mata_sling' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_serabut_wire')) {
            if ($request->oldImage_serabut_wire) {
                Storage::delete($request->oldImage_serabut_wire);
            }
            $validatedData['photo_serabut_wire'] = $request->file('photo_serabut_wire')->store('checksheet-sling-wire');
        }

        if ($request->file('photo_bagian_wire_1')) {
            if ($request->oldImage_bagian_wire_1) {
                Storage::delete($request->oldImage_bagian_wire_1);
            }
            $validatedData['photo_bagian_wire_1'] = $request->file('photo_bagian_wire_1')->store('checksheet-sling-wire');
        }

        if ($request->file('photo_bagian_wire_2')) {
            if ($request->oldImage_bagian_wire_2) {
                Storage::delete($request->oldImage_bagian_wire_2);
            }
            $validatedData['photo_bagian_wire_2'] = $request->file('photo_bagian_wire_2')->store('checksheet-sling-wire');
        }

        if ($request->file('photo_kumpulan_wire_1')) {
            if ($request->oldImage_kumpulan_wire_1) {
                Storage::delete($request->oldImage_kumpulan_wire_1);
            }
            $validatedData['photo_kumpulan_wire_1'] = $request->file('photo_kumpulan_wire_1')->store('checksheet-sling-wire');
        }

        if ($request->file('photo_diameter_wire')) {
            if ($request->oldImage_diameter_wire) {
                Storage::delete($request->oldImage_diameter_wire);
            }
            $validatedData['photo_diameter_wire'] = $request->file('photo_diameter_wire')->store('checksheet-sling-wire');
        }

        if ($request->file('photo_kumpulan_wire_2')) {
            if ($request->oldImage_kumpulan_wire_2) {
                Storage::delete($request->oldImage_kumpulan_wire_2);
            }
            $validatedData['photo_kumpulan_wire_2'] = $request->file('photo_kumpulan_wire_2')->store('checksheet-sling-wire');
        }

        if ($request->file('photo_hook_wire')) {
            if ($request->oldImage_hook_wire) {
                Storage::delete($request->oldImage_hook_wire);
            }
            $validatedData['photo_hook_wire'] = $request->file('photo_hook_wire')->store('checksheet-sling-wire');
        }

        if ($request->file('photo_pengunci_hook')) {
            if ($request->oldImage_pengunci_hook) {
                Storage::delete($request->oldImage_pengunci_hook);
            }
            $validatedData['photo_pengunci_hook'] = $request->file('photo_pengunci_hook')->store('checksheet-sling-wire');
        }

        if ($request->file('photo_mata_sling')) {
            if ($request->oldImage_mata_sling) {
                Storage::delete($request->oldImage_mata_sling);
            }
            $validatedData['photo_mata_sling'] = $request->file('photo_mata_sling')->store('checksheet-sling-wire');
        }

        // Update data CheckSheetIndoor dengan data baru dari form
        $checkSheetwire->update($validatedData);

        $sling = Sling::where('no_sling', $checkSheetwire->sling_number)->first();

        if (!$sling) {
            return back()->with('error', 'Sling tidak ditemukan.');
        }

        return redirect()->route('sling.show', $sling->id)->with('success1', 'Data Check Sheet Sling Wire berhasil diperbarui.');
    }

    public function show($id)
    {
        $checksheet = CheckSheetSlingWire::findOrFail($id);

        return view('dashboard.sling.checksheet.show', compact('checksheet'));
    }

    public function destroy($id)
    {
        $checkSheetwire = CheckSheetSlingWire::find($id);

        if ($checkSheetwire->photo_serabut_wire || $checkSheetwire->photo_bagian_wire_1 || $checkSheetwire->photo_bagian_wire_2 || $checkSheetwire->photo_kumpulan_wire_1 || $checkSheetwire->photo_diameter_wire || $checkSheetwire->photo_kumpulan_wire_2 || $checkSheetwire->photo_hook_wire || $checkSheetwire->photo_pengunci_hook || $checkSheetwire->photo_mata_sling) {
            Storage::delete($checkSheetwire->photo_serabut_wire);
            Storage::delete($checkSheetwire->photo_bagian_wire_1);
            Storage::delete($checkSheetwire->photo_bagian_wire_2);
            Storage::delete($checkSheetwire->photo_kumpulan_wire_1);
            Storage::delete($checkSheetwire->photo_diameter_wire);
            Storage::delete($checkSheetwire->photo_kumpulan_wire_2);
            Storage::delete($checkSheetwire->photo_hook_wire);
            Storage::delete($checkSheetwire->photo_pengunci_hook);
            Storage::delete($checkSheetwire->photo_mata_sling);
        }

        $checkSheetwire->delete();

        return back()->with('success1', 'Data Check Sheet Sling Wire berhasil dihapus');
    }
}
