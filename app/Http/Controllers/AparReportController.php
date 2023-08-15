<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckSheetCo2;
use App\Models\CheckSheetPowder;
use Illuminate\Support\Facades\DB;

class AparReportController extends Controller
{
    public function index()
    {
        return view('dashboard.apar_report');
    }
}
