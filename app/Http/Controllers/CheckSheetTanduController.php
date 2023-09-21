<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetTandu;
use App\Models\Tandu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckSheetTanduController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetTandus = CheckSheetTandu::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.tandu.checksheet.check', compact('latestCheckSheetTandus'));
    }

    public function processForm(Request $request)
    {
        $tanduNumber = $request->input('tandu_number');

        $tandu = Tandu::where('no_tandu', $tanduNumber)->first();

        if (!$tandu) {
            return back()->with('error', 'Tandu Number tidak ditemukan.');
        }

        $tanduNumber = strtoupper($tanduNumber);

        return redirect()->route('checksheettandu', compact('tanduNumber'));
    }

    public function createForm($tanduNumber)
    {
        $latestCheckSheetTandus = CheckSheetTandu::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $tandu = Tandu::where('no_tandu', $tanduNumber)->first();

        if (!$tandu) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('tandu.show.form', compact('latestCheckSheetTandus'))->with('error', 'Tandu Number tidak ditemukan.');
        }

        $tanduNumber = strtoupper($tanduNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTandu::where('tandu_number', $tanduNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('tandu.checksheettandu.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Tandu sudah ada untuk Tandu ' . $tanduNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetTandus = CheckSheetTandu::all();
            return view('dashboard.tandu.checksheet.checkTandu', compact('checkSheetTandus', 'tanduNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTandu::where('tandu_number', $request->tandu_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tandu_number' => 'required',
                'kunci_pintu' => 'required',
                'catatan_kunci_pintu' => 'nullable|string|max:255',
                'photo_kunci_pintu' => 'required|image|file|max:3072',
                'pintu' => 'required',
                'catatan_pintu' => 'nullable|string|max:255',
                'photo_pintu' => 'required|image|file|max:3072',
                'sign' => 'required',
                'catatan_sign' => 'nullable|string|max:255',
                'photo_sign' => 'required|image|file|max:3072',
                'hand_grip' => 'required',
                'catatan_hand_grip' => 'nullable|string|max:255',
                'photo_hand_grip' => 'required|image|file|max:3072',
                'body' => 'required',
                'catatan_body' => 'nullable|string|max:255',
                'photo_body' => 'required|image|file|max:3072',
                'engsel' => 'required',
                'catatan_engsel' => 'nullable|string|max:255',
                'photo_engsel' => 'required|image|file|max:3072',
                'kaki' => 'required',
                'catatan_kaki' => 'nullable|string|max:255',
                'photo_kaki' => 'required|image|file|max:3072',
                'belt' => 'required',
                'catatan_belt' => 'nullable|string|max:255',
                'photo_belt' => 'required|image|file|max:3072',
                'rangka' => 'required',
                'catatan_rangka' => 'nullable|string|max:255',
                'photo_rangka' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['tandu_number'] = strtoupper($validatedData['tandu_number']);

            if ($request->file('photo_kunci_pintu') && $request->file('photo_pintu') && $request->file('photo_sign') && $request->file('photo_hand_grip') && $request->file('photo_body') && $request->file('photo_engsel') && $request->file('photo_kaki') && $request->file('photo_belt') && $request->file('photo_rangka')) {
                $validatedData['photo_kunci_pintu'] = $request->file('photo_kunci_pintu')->store('checksheet-tandu');
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-tandu');
                $validatedData['photo_sign'] = $request->file('photo_sign')->store('checksheet-tandu');
                $validatedData['photo_hand_grip'] = $request->file('photo_hand_grip')->store('checksheet-tandu');
                $validatedData['photo_body'] = $request->file('photo_body')->store('checksheet-tandu');
                $validatedData['photo_engsel'] = $request->file('photo_engsel')->store('checksheet-tandu');
                $validatedData['photo_kaki'] = $request->file('photo_kaki')->store('checksheet-tandu');
                $validatedData['photo_belt'] = $request->file('photo_belt')->store('checksheet-tandu');
                $validatedData['photo_rangka'] = $request->file('photo_rangka')->store('checksheet-tandu');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('tandu.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'tandu_number' => 'required',
                'kunci_pintu' => 'required',
                'catatan_kunci_pintu' => 'nullable|string|max:255',
                'photo_kunci_pintu' => 'required|image|file|max:3072',
                'pintu' => 'required',
                'catatan_pintu' => 'nullable|string|max:255',
                'photo_pintu' => 'required|image|file|max:3072',
                'sign' => 'required',
                'catatan_sign' => 'nullable|string|max:255',
                'photo_sign' => 'required|image|file|max:3072',
                'hand_grip' => 'required',
                'catatan_hand_grip' => 'nullable|string|max:255',
                'photo_hand_grip' => 'required|image|file|max:3072',
                'body' => 'required',
                'catatan_body' => 'nullable|string|max:255',
                'photo_body' => 'required|image|file|max:3072',
                'engsel' => 'required',
                'catatan_engsel' => 'nullable|string|max:255',
                'photo_engsel' => 'required|image|file|max:3072',
                'kaki' => 'required',
                'catatan_kaki' => 'nullable|string|max:255',
                'photo_kaki' => 'required|image|file|max:3072',
                'belt' => 'required',
                'catatan_belt' => 'nullable|string|max:255',
                'photo_belt' => 'required|image|file|max:3072',
                'rangka' => 'required',
                'catatan_rangka' => 'nullable|string|max:255',
                'photo_rangka' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['tandu_number'] = strtoupper($validatedData['tandu_number']);

            if ($request->file('photo_kunci_pintu') && $request->file('photo_pintu') && $request->file('photo_sign') && $request->file('photo_hand_grip') && $request->file('photo_body') && $request->file('photo_engsel') && $request->file('photo_kaki') && $request->file('photo_belt') && $request->file('photo_rangka')) {
                $validatedData['photo_kunci_pintu'] = $request->file('photo_kunci_pintu')->store('checksheet-tandu');
                $validatedData['photo_pintu'] = $request->file('photo_pintu')->store('checksheet-tandu');
                $validatedData['photo_sign'] = $request->file('photo_sign')->store('checksheet-tandu');
                $validatedData['photo_hand_grip'] = $request->file('photo_hand_grip')->store('checksheet-tandu');
                $validatedData['photo_body'] = $request->file('photo_body')->store('checksheet-tandu');
                $validatedData['photo_engsel'] = $request->file('photo_engsel')->store('checksheet-tandu');
                $validatedData['photo_kaki'] = $request->file('photo_kaki')->store('checksheet-tandu');
                $validatedData['photo_belt'] = $request->file('photo_belt')->store('checksheet-tandu');
                $validatedData['photo_rangka'] = $request->file('photo_rangka')->store('checksheet-tandu');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetTandu::create($validatedData);

            return redirect()->route('tandu.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetTandu::findOrFail($id);

        return view('dashboard.tandu.checksheet.show', compact('checksheet'));
    }

    public function destroy($id)
    {
        $checkSheettandu = CheckSheetTandu::find($id);

        if ($checkSheettandu->photo_kunci_pintu || $checkSheettandu->photo_pintu || $checkSheettandu->photo_sign || $checkSheettandu->photo_hand_grip || $checkSheettandu->photo_body || $checkSheettandu->photo_engsel || $checkSheettandu->photo_kaki || $checkSheettandu->photo_belt || $checkSheettandu->photo_rangka) {
            Storage::delete($checkSheettandu->photo_kunci_pintu);
            Storage::delete($checkSheettandu->photo_pintu);
            Storage::delete($checkSheettandu->photo_sign);
            Storage::delete($checkSheettandu->photo_hand_grip);
            Storage::delete($checkSheettandu->photo_body);
            Storage::delete($checkSheettandu->photo_engsel);
            Storage::delete($checkSheettandu->photo_kaki);
            Storage::delete($checkSheettandu->photo_belt);
            Storage::delete($checkSheettandu->photo_rangka);
        }

        $checkSheettandu->delete();

        return back()->with('success1', 'Data Check Sheet Tandu berhasil dihapus');
    }
}
