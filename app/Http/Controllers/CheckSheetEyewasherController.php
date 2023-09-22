<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetEyewasher;
use App\Models\CheckSheetEyewasherShower;
use App\Models\Eyewasher;
use Illuminate\Http\Request;

class CheckSheetEyewasherController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetEyewashers = CheckSheetEyewasher::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetShower = CheckSheetEyewasherShower::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetEyewashers->merge($latestCheckSheetShower);

        return view('dashboard.eyewasher.checksheet.check', compact('combinedLatestCheckSheets'));
    }

    public function processForm(Request $request)
    {
        $eyewasherNumber = $request->input('eyewasher_number');

        $eyewasherNumber = strtoupper($eyewasherNumber);

        $eyewasher = Eyewasher::where('no_eyewasher', $eyewasherNumber)->first();

        if (!$eyewasher) {
            return back()->with('error', 'Eyewasher Number tidak ditemukan.');
        }

        $type = $eyewasher->type;

        if ($type === 'Eyewasher') {
            return redirect()->route('checksheeteyewasher', compact('eyewasherNumber'));
        } elseif ($type === 'Shower') {
            return redirect()->route('checksheetshower', compact('eyewasherNumber'));
        } else {
            return back()->with('error', 'Tipe tidak dikenali');
        }
    }
}
