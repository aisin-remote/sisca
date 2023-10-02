<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSlingBelt;
use App\Models\CheckSheetSlingWire;
use App\Models\Sling;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetSlingWire::where('sling_number', $slingNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        $slingNumber = strtoupper($slingNumber);

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('sling.checksheetwire.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet sudah ada untuk Sling Wire ' . $slingNumber . ' pada bulan ini. Silahkan edit.');
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

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetSlingWire::where('sling_number', $request->sling_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
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

            // if ($request->file('photo_serabut_wire') && $request->file('photo_bagian_wire_1') && $request->file('photo_bagian_wire_2') && $request->file('photo_kumpulan_wire_1') && $request->file('photo_diameter_wire') && $request->file('photo_kumpulan_wire_2') && $request->file('photo_hook_wire') && $request->file('photo_pengunci_hook') && $request->file('photo_mata_sling')) {
            //     $validatedData['photo_serabut_wire'] = $request->file('photo_serabut_wire')->store('checksheet-sling-wire');
            //     $validatedData['photo_bagian_wire_1'] = $request->file('photo_bagian_wire_1')->store('checksheet-sling-wire');
            //     $validatedData['photo_bagian_wire_2'] = $request->file('photo_bagian_wire_2')->store('checksheet-sling-wire');
            //     $validatedData['photo_kumpulan_wire_1'] = $request->file('photo_kumpulan_wire_1')->store('checksheet-sling-wire');
            //     $validatedData['photo_diameter_wire'] = $request->file('photo_diameter_wire')->store('checksheet-sling-wire');
            //     $validatedData['photo_kumpulan_wire_2'] = $request->file('photo_kumpulan_wire_2')->store('checksheet-sling-wire');
            //     $validatedData['photo_hook_wire'] = $request->file('photo_hook_wire')->store('checksheet-sling-wire');
            //     $validatedData['photo_pengunci_hook'] = $request->file('photo_pengunci_hook')->store('checksheet-sling-wire');
            //     $validatedData['photo_mata_sling'] = $request->file('photo_mata_sling')->store('checksheet-sling-wire');
            // }

            $imageAttributes = [
                'photo_serabut_wire',
                'photo_bagian_wire_1',
                'photo_bagian_wire_2',
                'photo_kumpulan_wire_1',
                'photo_diameter_wire',
                'photo_kumpulan_wire_2',
                'photo_hook_wire',
                'photo_pengunci_hook',
                'photo_mata_sling',
                // tambahkan atribut lain yang merupakan foto
            ];

            $maxFileSize = 3 * 1024;

            foreach ($imageAttributes as $attribute) {
                if ($request->hasFile($attribute)) {
                    $image = $request->file($attribute);

                    // Mendapatkan ekstensi asli file
                    $extension = $image->getClientOriginalExtension();

                    // Buat nama unik untuk file gambar
                    $fileName = 'checksheet-sling-wire/' . uniqid() . '.' . $extension;

                    // Kompresi gambar dengan kualitas 75% (atau sesuaikan dengan kebutuhan Anda)
                    $compressedImage = Image::make($image)->encode('jpg', 50);

                    // Simpan gambar yang telah dikompresi ke penyimpanan publik
                    Storage::disk('public')->put($fileName, $compressedImage->stream());

                    // Simpan nama file gambar yang dikompresi ke dalam database
                    $validatedData[$attribute] = $fileName;
                }
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetSlingWire::create($validatedData);

            return redirect()->route('sling.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }
}
