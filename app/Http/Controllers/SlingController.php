<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Sling;
use Illuminate\Http\Request;

class SlingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slings = Sling::get();
        return view('dashboard.sling.index', compact('slings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.sling.create', compact('locations'));
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
            'no_sling'=>'required|unique:tm_slings',
            'location_id'=>'required',
            'plant'=>'nullable',
            'type'=>'required'
        ]);

        Sling::create($validate);
        return redirect()->route('data-sling.index')->with('success', "Data Sling {$validate['no_sling']} berhasil ditambahkan");
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
        $sling = Sling::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.sling.edit', compact('sling', 'locations'));
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
        $sling = Sling::findOrFail($id);

        $validateData = $request->validate([
            'location_id'=>'required',
            'plant'=>'nullable',
            'type'=>'required'
        ]);

        $sling->update($validateData);

        return redirect()->route('data-sling.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sling = Sling::find($id);
        $sling->delete();

        return redirect()->route('data-sling.index')->with('success', 'Data Sling berhasil dihapus');
    }
}
