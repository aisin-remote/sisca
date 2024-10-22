<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHeadCrane;
use Illuminate\Http\Request;

class CheckSheetHeadCraneController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetHeadCranes = CheckSheetHeadCrane::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.safetybelt.checksheet.check', compact('latestCheckSheetHeadCranes'));
    }
}
