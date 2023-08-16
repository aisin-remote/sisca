<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use Illuminate\Http\Request;

class CheckSheetController extends Controller
{
    public function showForm()
    {
        return view('dashboard.checkSheet.check');
    }

    public function processForm(Request $request)
    {
        $tagNumber = $request->input('tag_number');

        $apar = Apar::where('tag_number', $tagNumber)->first();

        if (!$apar) {
            return back()->with('error', 'Tag Number tidak ditemukan.');
        }

        $type = $apar->type;

        if ($type === 'co2') {
            return view('dashboard.checkSheet.checkCo2', compact('tagNumber'));
        } elseif ($type === 'powder') {
            return view('dashboard.checkSheet.checkPowder', compact('tagNumber'));
        } elseif ($type === 'af11e') {
            return view('dashboard.checkSheet.checkCo2', compact('tagNumber'));
        } else {
            return back()->with('error', 'Tipe tidak dikenali');
        }
    }
}
