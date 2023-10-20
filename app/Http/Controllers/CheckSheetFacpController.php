<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetFacp;
use Illuminate\Http\Request;

class CheckSheetFacpController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetFacps = CheckSheetFacp::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.facp.checksheet.check', compact('latestCheckSheetFacps'));
    }
}
