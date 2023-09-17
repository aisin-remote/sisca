<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHydrantIndoor;
use App\Models\CheckSheetHydrantOutdoor;
use App\Models\Hydrant;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HydrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hydrants = Hydrant::get();
        return view('dashboard.hydrant.index', compact('hydrants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.hydrant.create', compact('locations'));
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
            'no_hydrant'=>'required|unique:tm_hydrants',
            'location_id'=>'required',
            'zona'=>'nullable',
            'type'=>'required'
        ]);

        Hydrant::create($validate);
        return redirect()->route('hydrant.index')->with('success', "Data Hydrant {$validate['no_hydrant']} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hydrant = Hydrant::findOrFail($id);

        if (!$hydrant) {
            return back()->with('error', 'Hydrant tidak ditemukan.');
        }

        $type = $hydrant->type;
        $checksheets = null;

        if ($type === 'Indoor') {
            $checksheets = CheckSheetHydrantIndoor::where('hydrant_number', $hydrant->no_hydrant);
            $firstYear = CheckSheetHydrantIndoor::min(DB::raw('YEAR(tanggal_pengecekan)'));
            $lastYear = CheckSheetHydrantIndoor::max(DB::raw('YEAR(tanggal_pengecekan)'));

            if (request()->has('tahun_filter')) {
                $tahunFilter = request()->input('tahun_filter');
                $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
            }

            $checksheets = $checksheets->get();

            return view('dashboard.hydrant.show', compact('hydrant', 'checksheets', 'firstYear', 'lastYear'));

        } elseif ($type === 'Outdoor') {
            $checksheets = CheckSheetHydrantOutdoor::where('hydrant_number', $hydrant->no_hydrant);
            $firstYear = CheckSheetHydrantOutdoor::min(DB::raw('YEAR(tanggal_pengecekan)'));
            $lastYear = CheckSheetHydrantOutdoor::max(DB::raw('YEAR(tanggal_pengecekan)'));

            if (request()->has('tahun_filter')) {
                $tahunFilter = request()->input('tahun_filter');
                $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
            }

            $checksheets = $checksheets->get();

            return view('dashboard.hydrant.show', compact('hydrant', 'checksheets', 'firstYear', 'lastYear'));

        } else {
            return back()->with('error', 'Hydrant tidak dikenali');
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
        $hydrant = Hydrant::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.hydrant.edit', compact('hydrant', 'locations'));
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
        $hydrant = Hydrant::findOrFail($id);

        $validateData = $request->validate([
            'location_id'=>'required',
            'zona'=>'nullable',
            'type'=>'required'
        ]);

        $hydrant->update($validateData);

        return redirect()->route('hydrant.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hydrant = Hydrant::find($id);
        $hydrant->delete();

        return redirect()->route('hydrant.index')->with('success', 'Data Hydrant berhasil dihapus');
    }

    public function location()
    {
        return view('dashboard.hydrant.location.index');
    }
}
