<?php

namespace App\Http\Controllers;

use App\Models\Facp;
use App\Models\Location;
use Illuminate\Http\Request;

class FacpController extends Controller
{
    public function index()
    {
        $facps = Facp::get();
        return view('dashboard.facp.index', compact('facps'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('dashboard.facp.create', compact('locations'));
    }
}
