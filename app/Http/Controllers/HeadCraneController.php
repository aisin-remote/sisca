<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHeadCrane;
use App\Models\HeadCrane;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HeadCraneController extends Controller
{
    public function index()
    {
        $head_crane = HeadCrane::get();
        return view('dashboard.headcrane.master.index', compact('head_crane'));
    }
    public function create()
    {
        $locations = Location::get();
        return view('dashboard.headcrane.master.create', compact('locations'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_headcrane' => 'required|unique:tm_headcranes',
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_headcrane'] = strtoupper($validate['no_headcrane']);


        HeadCrane::create($validate);
        return redirect()->route('head-crane.index')->with('success', "Data Head Crane {$validate['no_headcrane']} berhasil ditambahkan");
    }
    public function show($id)
    {
        $headcrane = HeadCrane::findOrFail($id);

        if (!$headcrane) {
            return back()->with('error', 'Safety Belt tidak ditemukan.');
        }

        $checksheets = CheckSheetHeadCrane::where('headcrane_number', $headcrane->no_headcrane);
        $firstYear = CheckSheetHeadCrane::min(DB::raw('YEAR(tanggal_pengecekan)'));
        $lastYear = CheckSheetHeadCrane::max(DB::raw('YEAR(tanggal_pengecekan)'));

        if (request()->has('tahun_filter')) {
            $tahunFilter = request()->input('tahun_filter');
            $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
        }

        $checksheets = $checksheets->get();

        return view('dashboard.headcrane.master.show', compact('headcrane', 'checksheets', 'firstYear', 'lastYear'));
    }

    public function edit($id)
    {
        $headcrane = HeadCrane::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.headcrane.master.edit', compact('headcrane', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $headcrane = HeadCrane::findOrFail($id);

        // Ambil data dari request dan lakukan validasi manual jika diperlukan
        $inputData = $request->only(['location_id', 'plant']);

        // Update data headcrane
        $headcrane->update($inputData);

        // Redirect dengan pesan sukses
        return redirect()->route('head-crane.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $headcrane = HeadCrane::find($id);
        $headcrane->delete();

        return redirect()->route('head-crane.index')->with('success', 'Data Head Crane berhasil dihapus');
    }
}
