<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Nitrogen;
use Illuminate\Http\Request;

class NitrogenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nitrogens = Nitrogen::get();
        return view('dashboard.nitrogen.index', compact('nitrogens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.nitrogen.create', compact('locations'));
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
            'no_tabung'=>'required|unique:tm_nitrogens',
            'location_id'=>'required',
            'plant'=>'nullable',
        ]);

        Nitrogen::create($validate);
        return redirect()->route('data-nitrogen.index')->with('success', "Data Nitrogen {$validate['no_tabung']} berhasil ditambahkan");
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
        $nitrogen = Nitrogen::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.nitrogen.edit', compact('nitrogen', 'locations'));
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
        $nitrogen = Nitrogen::findOrFail($id);

        $validateData = $request->validate([
            'location_id'=>'required',
            'plant'=>'nullable',
        ]);

        $nitrogen->update($validateData);

        return redirect()->route('data-nitrogen.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nitrogen = Nitrogen::find($id);
        $nitrogen->delete();

        return redirect()->route('data-nitrogen.index')->with('success', 'Data Nitrogen berhasil dihapus');
    }
}
