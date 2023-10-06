<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSlingBelt;
use App\Models\CheckSheetSlingWire;
use App\Models\Location;
use App\Models\Sling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slings = Sling::get();
        return view('dashboard.sling.index', compact('slings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.sling.create', compact('locations'));
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
            'no_sling' => 'required|unique:tm_slings',
            'swl' => 'required',
            'location_id' => 'required',
            'plant' => 'nullable',
            'type' => 'required'
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_sling'] = strtoupper($validate['no_sling']);


        Sling::create($validate);
        return redirect()->route('sling.index')->with('success', "Data Sling {$validate['no_sling']} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sling = Sling::findOrFail($id);

        if (!$sling) {
            return back()->with('error', 'Sling tidak ditemukan.');
        }

        $type = $sling->type;
        $checksheets = null;

        if ($type === 'Sling Wire') {
            $checksheets = CheckSheetSlingWire::where('sling_number', $sling->no_sling);
            $firstYear = CheckSheetSlingWire::min(DB::raw('YEAR(tanggal_pengecekan)'));
            $lastYear = CheckSheetSlingWire::max(DB::raw('YEAR(tanggal_pengecekan)'));

            if (request()->has('tahun_filter')) {
                $tahunFilter = request()->input('tahun_filter');
                $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
            }

            $checksheets = $checksheets->get();

            return view('dashboard.sling.show', compact('sling', 'checksheets', 'firstYear', 'lastYear'));

        } elseif ($type === 'Sling Belt') {
            $checksheets = CheckSheetSlingBelt::where('sling_number', $sling->no_sling);
            $firstYear = CheckSheetSlingBelt::min(DB::raw('YEAR(tanggal_pengecekan)'));
            $lastYear = CheckSheetSlingBelt::max(DB::raw('YEAR(tanggal_pengecekan)'));

            if (request()->has('tahun_filter')) {
                $tahunFilter = request()->input('tahun_filter');
                $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
            }

            $checksheets = $checksheets->get();

            return view('dashboard.sling.show', compact('sling', 'checksheets', 'firstYear', 'lastYear'));
        } else {
            return back()->with('error', 'Sling tidak dikenali');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sling = Sling::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.sling.edit', compact('sling', 'locations'));
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
        $sling = Sling::findOrFail($id);

        $validateData = $request->validate([
            'swl' => 'required',
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        $sling->update($validateData);

        return redirect()->route('sling.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sling = Sling::find($id);
        $sling->delete();

        return redirect()->route('sling.index')->with('success', 'Data Sling berhasil dihapus');
    }
}
