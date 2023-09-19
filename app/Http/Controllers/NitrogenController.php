<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetNitrogenServer;
use App\Models\Location;
use App\Models\Nitrogen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NitrogenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nitrogens = Nitrogen::get();
        return view('dashboard.nitrogen.index', compact('nitrogens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.nitrogen.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_tabung' => 'required|unique:tm_nitrogens',
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_tabung'] = strtoupper($validate['no_tabung']);


        Nitrogen::create($validate);
        return redirect()->route('nitrogen.index')->with('success', "Data Nitrogen {$validate['no_tabung']} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nitrogen = Nitrogen::findOrFail($id);

        if (!$nitrogen) {
            return back()->with('error', 'Nitrogen tidak ditemukan.');
        }

        $checksheets = CheckSheetNitrogenServer::where('tabung_number', $nitrogen->no_tabung);
        $firstYear = CheckSheetNitrogenServer::min(DB::raw('YEAR(tanggal_pengecekan)'));
        $lastYear = CheckSheetNitrogenServer::max(DB::raw('YEAR(tanggal_pengecekan)'));

        if (request()->has('tahun_filter')) {
            $tahunFilter = request()->input('tahun_filter');
            $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
        }

        $checksheets = $checksheets->get();

        return view('dashboard.nitrogen.show', compact('nitrogen', 'checksheets', 'firstYear', 'lastYear'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nitrogen = Nitrogen::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.nitrogen.edit', compact('nitrogen', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nitrogen = Nitrogen::findOrFail($id);

        $validateData = $request->validate([
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        $nitrogen->update($validateData);

        return redirect()->route('nitrogen.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nitrogen = Nitrogen::find($id);
        $nitrogen->delete();

        return redirect()->route('nitrogen.index')->with('success', 'Data Nitrogen berhasil dihapus');
    }
}
