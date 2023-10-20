<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetFacp;
use App\Models\Facp;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacpController extends Controller
{
    public function index()
    {
        $facps = Facp::get();
        return view('dashboard.facp.index', compact('facps'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('dashboard.facp.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'zona' => 'required|unique:tm_facps',
            'location_id' => 'required',
            'nomor_adress' => 'nullable',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['zona'] = strtoupper($validate['zona']);


        Facp::create($validate);
        return redirect()->route('facp.index')->with('success', "Data Facp {$validate['zona']} berhasil ditambahkan");
    }

    public function show($id)
    {
        $facp = Facp::findOrFail($id);

        if (!$facp) {
            return back()->with('error', 'Facp tidak ditemukan.');
        }

        $checksheets = CheckSheetFacp::where('zona_number', $facp->zona);
        $firstYear = CheckSheetFacp::min(DB::raw('YEAR(tanggal_pengecekan)'));
        $lastYear = CheckSheetFacp::max(DB::raw('YEAR(tanggal_pengecekan)'));

        if (request()->has('tahun_filter')) {
            $tahunFilter = request()->input('tahun_filter');
            $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
        }

        $checksheets = $checksheets->get();

        return view('dashboard.facp.show', compact('facp', 'checksheets', 'firstYear', 'lastYear'));
    }

    public function edit($id)
    {
        $facp = Facp::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.facp.edit', compact('facp', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $facp = Facp::findOrFail($id);

        $validateData = $request->validate([
            'location_id' => 'required',
            'nomor_adress' => 'nullable',
        ]);

        $facp->update($validateData);

        return redirect()->route('facp.index')->with('success', 'Data berhasil di update.');
    }

    public function destroy($id)
    {
        $facp = Facp::find($id);
        $facp->delete();

        return redirect()->route('facp.index')->with('success', 'Data FACP berhasil dihapus');
    }
}
