<?php

namespace App\Http\Controllers;

use App\Models\Eyewasher;
use App\Models\Location;
use Illuminate\Http\Request;

class EyewasherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eyewashers = Eyewasher::get();
        return view('dashboard.eyewasher.index', compact('eyewashers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.eyewasher.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_eyewasher' => 'required|unique:tm_eyewashers',
            'type' => 'required',
            'location_id' => 'required',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_eyewasher'] = strtoupper($validate['no_eyewasher']);


        Eyewasher::create($validate);
        return redirect()->route('eye-washer.index')->with('success', "Data Eye Washer {$validate['no_eyewasher']} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eyewasher = Eyewasher::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.eyewasher.edit', compact('eyewasher', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $eyewasher = Eyewasher::findOrFail($id);

        $validateData = $request->validate([
            'location_id' => 'required',
        ]);

        $eyewasher->update($validateData);

        return redirect()->route('eye-washer.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eyewasher = Eyewasher::find($id);
        $eyewasher->delete();

        return redirect()->route('eye-washer.index')->with('success', 'Data Eye Washer berhasil dihapus');
    }
}
