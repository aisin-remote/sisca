<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use Illuminate\Http\Request;
use App\Models\CheckSheetCo2;
use Carbon\Carbon;

class CheckSheetCo2Controller extends Controller
{
    public function showForm($tagNumber)
    {
        $checkSheetCo2s = CheckSheetCo2::all();

        $lastMonth = Carbon::now()->subMonth();

        $existingCheckSheet = CheckSheetCo2::where('apar_number', $tagNumber)
            ->where('created_at', '>', $lastMonth)
            ->first();

        if ($existingCheckSheet) {
            return redirect()->route('apar.checksheetco2.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Co2 sudah ada dalam satu bulan terakhir untuk Apar ' . $tagNumber . '. Silahkan edit.');
        }

        return view('dashboard.checkSheet.checkCo2', compact('checkSheetCo2s', 'tagNumber'));
    }

    public function store(Request $request)
    {
        $lastMonth = Carbon::now()->subMonth();

        $existingCheckSheet = CheckSheetCo2::where('apar_number', $request->apar_number)
            ->where('created_at', '>', $lastMonth)
            ->first();

        if ($existingCheckSheet) {
            return redirect()->route('apar.checksheetco2.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Powder sudah ada dalam satu bulan terakhir untuk Apar ' . $request->apar_number . '. Silahkan edit.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'tanggal_pengecekan' => 'required|date',
            'npk' => 'required',
            'apar_number' => 'required',
            'pressure' => 'required',
            'hose' => 'required',
            'corong' => 'required',
            'tabung' => 'required',
            'regulator' => 'required',
            'lock_pin' => 'required',
            'berat_tabung' => 'required',
            // tambahkan validasi untuk atribut lainnya
        ]);

        // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
        $validatedData['npk'] = auth()->user()->npk;

        // Simpan data ke database menggunakan metode create
        CheckSheetCo2::create($validatedData);

        return redirect()->route('show.form')->with('success', 'Data berhasil disimpan.');
    }

    public function edit ($id)
    {
        $checkSheetco2 = CheckSheetCo2::findOrFail($id);
        return view('dashboard.apar.checksheetco2.edit', compact('checkSheetco2'));
    }

    public function update(Request $request, $id)
    {
        $checkSheetco2 = CheckSheetCo2::findOrFail($id);

        // Validasi data yang diinputkan
        $request->validate([
            'pressure' => 'required',
            'hose' => 'required',
            'corong' => 'required',
            'tabung' => 'required',
            'regulator' => 'required',
            'lock_pin' => 'required',
            'berat_tabung' => 'required',
        ]);

        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheetco2->update($request->all());

        $apar = Apar::where('tag_number', $checkSheetco2->apar_number)->first();

        if (!$apar) {
            return back()->with('error', 'Apar tidak ditemukan.');
        }

        return redirect()->route('data_apar.show', $apar->id)->with('success1', 'Data Check Sheet Co2 berhasil diperbarui.');
    }

    public function destroy ($id) {
        $checkSheetco2 = CheckSheetCo2::find($id);
        $checkSheetco2->delete();

        return back()->with('success1', 'Data Check Sheet Apar Co2 berhasil dihapus');
    }
}
