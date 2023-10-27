<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use Illuminate\Http\Request;
use App\Models\CheckSheetCo2;
use App\Models\CheckSheetPowder;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AparCheckSheetExport;
use Carbon\Carbon;

class CheckSheetController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheetco2 = CheckSheetCo2::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        $checksheetpowder = CheckSheetPowder::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.apar.checksheet.index', compact('checksheetco2', 'checksheetpowder'));
    }
    public function showForm()
    {
        $latestCheckSheetPowders = CheckSheetPowder::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetCo2 = CheckSheetCo2::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetPowders->merge($latestCheckSheetCo2);

        return view('dashboard.checkSheet.check', compact('combinedLatestCheckSheets'));
    }

    public function processForm(Request $request)
    {
        if (auth()->user()->role != 'Admin') {
            return back()->with('error', 'Hanya admin yang dapat melakukan check');
        }

        $tagNumber = $request->input('tag_number');

        $apar = Apar::where('tag_number', $tagNumber)->first();

        if (!$apar) {
            return back()->with('error', 'Tag Number tidak ditemukan.');
        }

        $type = $apar->type;

        if ($type === 'co2') {
            return redirect()->route('checksheetco2', compact('tagNumber'));
        } elseif ($type === 'powder') {
            return redirect()->route('checksheetpowder', compact('tagNumber'));
        } elseif ($type === 'af11e') {
            return redirect()->route('checksheetco2', compact('tagNumber'));
        } else {
            return back()->with('error', 'Tipe tidak dikenali');
        }
    }
}
