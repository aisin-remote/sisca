<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetBodyHarnest;
use Illuminate\Http\Request;

class CheckSheetBodyHarnestController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetBodyharnests = CheckSheetBodyHarnest::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.bodyharnest.checksheet.check', compact('latestCheckSheetBodyharnests'));
    }
}
