<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetTabungCo2;
use App\Models\Co2;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Co2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $co2s = Co2::get();
        return view('dashboard.co2.index', compact('co2s'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.co2.create', compact('locations'));
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
            'no_tabung'=>'required|unique:tm_co2s',
            'location_id'=>'required',
            'plant'=>'nullable',
        ]);

        Co2::create($validate);
        return redirect()->route('co2.index')->with('success', "Data Co2 {$validate['no_tabung']} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $co2 = Co2::findOrFail($id);

        if (!$co2) {
            return back()->with('error', 'Co2 tidak ditemukan.');
        }

        $checksheets = CheckSheetTabungCo2::where('tabung_number', $co2->no_tabung);
        $firstYear = CheckSheetTabungCo2::min(DB::raw('YEAR(tanggal_pengecekan)'));
        $lastYear = CheckSheetTabungCo2::max(DB::raw('YEAR(tanggal_pengecekan)'));

        if (request()->has('tahun_filter')) {
            $tahunFilter = request()->input('tahun_filter');
            $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
        }

        $checksheets = $checksheets->get();

        return view('dashboard.co2.show', compact('co2', 'checksheets', 'firstYear', 'lastYear'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $co2 = Co2::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.co2.edit', compact('co2', 'locations'));
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
        $co2 = Co2::findOrFail($id);

        $validateData = $request->validate([
            'location_id'=>'required',
            'plant'=>'nullable',
        ]);

        $co2->update($validateData);

        return redirect()->route('co2.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $co2 = Co2::find($id);
        $co2->delete();

        return redirect()->route('co2.index')->with('success', 'Data Co2 berhasil dihapus');
    }
}
