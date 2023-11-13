<?php

namespace App\Http\Controllers;

use App\Models\Bodyharnest;
use App\Models\CheckSheetBodyHarnest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BodyharnestController extends Controller
{
    public function index()
    {
        $bodyharnests = Bodyharnest::get();
        return view('dashboard.bodyharnest.index', compact('bodyharnests'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('dashboard.bodyharnest.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_bodyharnest' => 'required|unique:tm_bodyharnests',
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_bodyharnest'] = strtoupper($validate['no_bodyharnest']);


        Bodyharnest::create($validate);
        return redirect()->route('body-harnest.index')->with('success', "Data Body Harnest {$validate['no_bodyharnest']} berhasil ditambahkan");
    }

    public function show($id)
    {
        $bodyharnest = Bodyharnest::findOrFail($id);

        if (!$bodyharnest) {
            return back()->with('error', 'Body Harnest tidak ditemukan.');
        }

        $checksheets = CheckSheetBodyHarnest::where('bodyharnest_number', $bodyharnest->no_bodyharnest);
        $firstYear = CheckSheetBodyHarnest::min(DB::raw('YEAR(tanggal_pengecekan)'));
        $lastYear = CheckSheetBodyHarnest::max(DB::raw('YEAR(tanggal_pengecekan)'));

        if (request()->has('tahun_filter')) {
            $tahunFilter = request()->input('tahun_filter');
            $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
        }

        $checksheets = $checksheets->get();

        return view('dashboard.bodyharnest.show', compact('bodyharnest', 'checksheets', 'firstYear', 'lastYear'));
    }

    public function edit($id)
    {
        $bodyharnest = Bodyharnest::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.bodyharnest.edit', compact('bodyharnest', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $bodyharnest = Bodyharnest::findOrFail($id);

        $validateData = $request->validate([
            'plant' => 'nullable',
        ]);

        $bodyharnest->update($validateData);

        return redirect()->route('body-harnest.index')->with('success', 'Data berhasil di update.');
    }

    public function destroy($id)
    {
        $bodyharnest = Bodyharnest::find($id);
        $bodyharnest->delete();

        return redirect()->route('body-harnest.index')->with('success', 'Data Body Harnest berhasil dihapus');
    }
}
