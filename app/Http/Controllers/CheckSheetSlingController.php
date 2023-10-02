<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSlingBelt;
use App\Models\CheckSheetSlingWire;
use App\Models\Sling;
use Illuminate\Http\Request;

class CheckSheetSlingController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetWires = CheckSheetSlingWire::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetBelt = CheckSheetSlingBelt::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetWires->merge($latestCheckSheetBelt);

        return view('dashboard.sling.checksheet.check', compact('combinedLatestCheckSheets'));
    }

    public function processForm(Request $request)
    {
        $slingNumber = $request->input('sling_number');

        $slingNumber = strtoupper($slingNumber);

        $sling = Sling::where('no_sling', $slingNumber)->first();

        if (!$sling) {
            return back()->with('error', 'Sling Number tidak ditemukan.');
        }

        $type = $sling->type;

        if ($type === 'Sling Wire') {
            return redirect()->route('checksheetwire', compact('slingNumber'));
        } elseif ($type === 'Sling Belt') {
            return redirect()->route('checksheetbelt', compact('slingNumber'));
        } else {
            return back()->with('error', 'Tipe tidak dikenali');
        }
    }
}
