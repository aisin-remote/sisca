<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use App\Models\CheckSheetCo2;
use App\Models\CheckSheetPowder;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AparController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apars = Apar::get();
        return view('dashboard.apar.index', compact('apars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.apar.create', compact('locations'));
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
            'tag_number' => 'required|unique:tm_apars',
            'location_id' => 'required',
            'expired' => 'required',
            'post' => 'nullable',
            'type' => 'required'
        ]);

        $validate['tag_number'] = strtoupper($validate['tag_number']);

        Apar::create($validate);
        return redirect()->route('apar.index')->with('success', "Data Apar {$validate['tag_number']} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apar = Apar::findOrFail($id);

        if (!$apar) {
            return back()->with('error', 'Apar tidak ditemukan.');
        }

        $type = $apar->type;
        $checksheets = null;

        if ($type === 'co2') {
            $checksheets = CheckSheetCo2::where('apar_number', $apar->tag_number);
            $firstYear = CheckSheetCo2::min(DB::raw('YEAR(tanggal_pengecekan)'));
            $lastYear = CheckSheetCo2::max(DB::raw('YEAR(tanggal_pengecekan)'));

            if (request()->has('tahun_filter')) {
                $tahunFilter = request()->input('tahun_filter');
                $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
            }

            $checksheets = $checksheets->get();

            return view('dashboard.apar.show', compact('apar', 'checksheets', 'firstYear', 'lastYear'));

        } elseif ($type === 'powder') {
            $checksheets = CheckSheetPowder::where('apar_number', $apar->tag_number);
            $firstYear = CheckSheetPowder::min(DB::raw('YEAR(tanggal_pengecekan)'));
            $lastYear = CheckSheetPowder::max(DB::raw('YEAR(tanggal_pengecekan)'));

            if (request()->has('tahun_filter')) {
                $tahunFilter = request()->input('tahun_filter');
                $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
            }

            $checksheets = $checksheets->get();

            return view('dashboard.apar.show', compact('apar', 'checksheets', 'firstYear', 'lastYear'));

        } elseif ($type === 'af11e') {
            $checksheets = CheckSheetCo2::where('apar_number', $apar->tag_number);
            $firstYear = CheckSheetCo2::min(DB::raw('YEAR(tanggal_pengecekan)'));
            $lastYear = CheckSheetCo2::max(DB::raw('YEAR(tanggal_pengecekan)'));

            if (request()->has('tahun_filter')) {
                $tahunFilter = request()->input('tahun_filter');
                $checksheets->whereDate('tanggal_pengecekan', $tahunFilter);
            }

            $checksheets = $checksheets->get();

            return view('dashboard.apar.show', compact('apar', 'checksheets', 'firstYear', 'lastYear'));
        } else {
            return back()->with('error', 'Apar tidak dikenali');
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
        $apar = Apar::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.apar.edit', compact('apar', 'locations'));
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
        $apar = Apar::findOrFail($id);

        $validateData = $request->validate([
            'location_id' => 'required',
            'expired' => 'required',
            'post' => 'nullable',
            'type' => 'required'
        ]);

        $apar->update($validateData);

        return redirect()->route('apar.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apar = Apar::find($id);
        $apar->delete();

        return redirect()->route('apar.index')->with('success', 'Data Apar berhasil dihapus');
    }

    public function location()
    {
        return view('dashboard.apar.location.index');
    }
}
