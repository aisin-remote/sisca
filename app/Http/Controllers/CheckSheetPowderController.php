<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Apar;
use Illuminate\Http\Request;
use App\Models\CheckSheetPowder;

class CheckSheetPowderController extends Controller
{
    public function showForm($tagNumber)
    {
        $checkSheetPowders = CheckSheetPowder::all();

        $lastMonth = Carbon::now()->subMonth();

        $existingCheckSheet = CheckSheetPowder::where('apar_number', $tagNumber)
            ->where('created_at', '>', $lastMonth)
            ->first();

        if ($existingCheckSheet) {
            return redirect()->route('apar.checksheetpowder.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Powder sudah ada dalam satu bulan terakhir untuk Apar ' . $tagNumber . '. Silahkan edit.');
        }

        return view('dashboard.checkSheet.checkPowder', compact('checkSheetPowders', 'tagNumber'));
    }

    public function store(Request $request)
    {
        $lastMonth = Carbon::now()->subMonth();

        $existingCheckSheet = CheckSheetPowder::where('apar_number', $request->apar_number)
            ->where('created_at', '>', $lastMonth)
            ->first();

        if ($existingCheckSheet) {
            return redirect()->route('apar.checksheetpowder.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Powder sudah ada dalam satu bulan terakhir untuk Apar ' . $request->apar_number . '. Silahkan edit.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'tanggal_pengecekan' => 'required|date',
            'npk' => 'required',
            'apar_number' => 'required',
            'pressure' => 'required',
            'hose' => 'required',
            'tabung' => 'required',
            'regulator' => 'required',
            'lock_pin' => 'required',
            'powder' => 'required',
            // tambahkan validasi untuk atribut lainnya
        ]);

        // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
        $validatedData['npk'] = auth()->user()->npk;

        // Simpan data ke database menggunakan metode create
        CheckSheetPowder::create($validatedData);

        return redirect()->route('show.form')->with('success', 'Data berhasil disimpan.');
    }

    public function edit ($id)
    {
        $checkSheetpowder = CheckSheetPowder::findOrFail($id);
        return view('dashboard.apar.checksheetpowder.edit', compact('checkSheetpowder'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetpowder = CheckSheetPowder::findOrFail($id);

        // Validasi data yang diinputkan
        $request->validate([
            'pressure' => 'required',
            'hose' => 'required',
            'tabung' => 'required',
            'regulator' => 'required',
            'lock_pin' => 'required',
            'powder' => 'required',
        ]);

        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheetpowder->update($request->all());

        $apar = Apar::where('tag_number', $checkSheetpowder->apar_number)->first();

        if (!$apar) {
            return back()->with('error', 'Apar tidak ditemukan.');
        }

        return redirect()->route('data_apar.show', $apar->id)->with('success1', 'Data Check Sheet Powder berhasil diperbarui.');
    }

    public function destroy ($id) {
        $checkSheetpowder = CheckSheetPowder::find($id);
        $checkSheetpowder->delete();

        return back()->with('success1', 'Data Check Sheet Apar Powder berhasil dihapus');
    }
}
