<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSafetyBelt;
use App\Models\Location;
use App\Models\Safetybelt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SafetybeltController extends Controller
{
    public function index()
    {
        $safetybelts = Safetybelt::get();
        return view('dashboard.safetybelt.index', compact('safetybelts'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('dashboard.safetybelt.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_safetybelt' => 'required|unique:tm_safetybelts',
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_safetybelt'] = strtoupper($validate['no_safetybelt']);


        Safetybelt::create($validate);
        return redirect()->route('safety-belt.index')->with('success', "Data Safety Belt {$validate['no_safetybelt']} berhasil ditambahkan");
    }

    public function show($id)
    {
        $safetybelt = Safetybelt::findOrFail($id);

        if (!$safetybelt) {
            return back()->with('error', 'Safety Belt tidak ditemukan.');
        }

        $checksheets = CheckSheetSafetyBelt::where('safetybelt_number', $safetybelt->no_safetybelt);
        $firstYear = CheckSheetSafetyBelt::min(DB::raw('YEAR(tanggal_pengecekan)'));
        $lastYear = CheckSheetSafetyBelt::max(DB::raw('YEAR(tanggal_pengecekan)'));

        if (request()->has('tahun_filter')) {
            $tahunFilter = request()->input('tahun_filter');
            $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
        }

        $checksheets = $checksheets->get();

        return view('dashboard.safetybelt.show', compact('safetybelt', 'checksheets', 'firstYear', 'lastYear'));
    }

    public function edit($id)
    {
        $safetybelt = Safetybelt::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.safetybelt.edit', compact('safetybelt', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $safetybelt = Safetybelt::findOrFail($id);

        $validateData = $request->validate([
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        $safetybelt->update($validateData);

        return redirect()->route('safety-belt.index')->with('success', 'Data berhasil di update.');
    }

    public function destroy($id)
    {
        $safetybelt = Safetybelt::find($id);
        $safetybelt->delete();

        return redirect()->route('safety-belt.index')->with('success', 'Data Safety Belt berhasil dihapus');
    }
}
