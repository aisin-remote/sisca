<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHydrantIndoor;
use App\Models\CheckSheetHydrantOutdoor;
use App\Models\Hydrant;
use Illuminate\Http\Request;

class CheckSheetHydrantController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheetindoor = CheckSheetHydrantIndoor::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        $checksheetoutdoor = CheckSheetHydrantOutdoor::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.hydrant.checksheet.index', compact('checksheetindoor', 'checksheetoutdoor'));
    }
    public function showForm()
    {
        $latestCheckSheetOutdoors = CheckSheetHydrantOutdoor::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetIndoor = CheckSheetHydrantIndoor::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetOutdoors->merge($latestCheckSheetIndoor);

        return view('dashboard.hydrant.checksheet.check', compact('combinedLatestCheckSheets'));
    }

    public function processForm(Request $request)
    {
        $hydrantNumber = $request->input('hydrant_number');

        $hydrant = Hydrant::where('no_hydrant', $hydrantNumber)->first();

        if (!$hydrant) {
            return back()->with('error', 'Hydrant Number tidak ditemukan.');
        }

        $type = $hydrant->type;

        if ($type === 'Indoor') {
            return redirect()->route('checksheetindoor', compact('hydrantNumber'));
        } elseif ($type === 'Outdoor') {
            return redirect()->route('checksheetoutdoor', compact('hydrantNumber'));
        } else {
            return back()->with('error', 'Tipe tidak dikenali');
        }
    }
}
