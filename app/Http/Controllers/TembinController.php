<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetTandu;
use App\Models\CheckSheetTembin;
use App\Models\Location;
use App\Models\Tembin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TembinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.tembin.index', [
            'tembins' => Tembin::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.tembin.create',  compact('locations'));
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
            'no_equip' => 'required|unique:tm_tembins',
            'location_id' => 'required'
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_equip'] = strtoupper($validate['no_equip']);


        Tembin::create($validate);
        return redirect()->route('tembin.index')->with('success', "Data Tembin {$validate['no_equip']} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tembin = Tembin::findOrFail($id);

        if (!$tembin) {
            return back()->with('error', 'Tembin tidak ditemukan.');
        }

        $checksheets = CheckSheetTembin::where('tembin_number', $tembin->no_equip);
        $firstYear = CheckSheetTembin::min(DB::raw('YEAR(tanggal_pengecekan)'));
        $lastYear = CheckSheetTembin::max(DB::raw('YEAR(tanggal_pengecekan)'));

        if (request()->has('tahun_filter')) {
            $tahunFilter = request()->input('tahun_filter');
            $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
        }

        $checksheets = $checksheets->get();

        return view('dashboard.tembin.show', compact('tembin', 'checksheets', 'firstYear', 'lastYear'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tembin = Tembin::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.tembin.edit', compact('tembin', 'locations'));
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
        $tembin = Tembin::findOrFail($id);

        $validateData = $request->validate([
            'location_id' => 'required',
        ]);

        $tembin->update($validateData);

        return redirect()->route('tembin.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tembin = Tembin::find($id);
        $tembin->delete();

        return redirect()->route('tembin.index')->with('success', 'Data Tembin berhasil dihapus');
    }
}
