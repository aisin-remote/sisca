<?php

namespace App\Http\Controllers;

use App\Models\Bodyharnest;
use App\Models\Location;
use Illuminate\Http\Request;

class BodyharnestController extends Controller
{
    public function index()
    {
        $bodyharnests = Bodyharnest::get();
        return view('dashboard.bodyharnest.index', compact('bodyharnests'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('dashboard.bodyharnest.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_bodyharnest' => 'required|unique:tm_bodyharnests',
            'tinggi' => 'required',
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_bodyharnest'] = strtoupper($validate['no_bodyharnest']);


        Bodyharnest::create($validate);
        return redirect()->route('body-harnest.index')->with('success', "Data Body Harnest {$validate['no_bodyharnest']} berhasil ditambahkan");
    }
}
