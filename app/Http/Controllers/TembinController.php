<?php

namespace App\Http\Controllers;

use App\Models\Tembin;
use Illuminate\Http\Request;

class TembinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.tembin.index',[
            'tembins' => Tembin::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.tembin.create');
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
            'no_equip'=>'required|unique:tm_tembins'
        ]);

        Tembin::create($validate);
        return redirect()->route('tembin.index')->with('success', "Data Tembin {$validate['no_equip']} berhasil ditambahkan");
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
    // public function edit($id)
    // {
    //     $location = Location::findOrFail($id);
    //     return view('dashboard.location.edit', compact('location'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $location = Location::findOrFail($id);

    //     $validateData = $request->validate([
    //         'location_name' => 'required'
    //     ]);

    //     $location->update($validateData);

    //     return redirect()->route('data_location.index')->with('success', 'Data berhasil di update.');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tembin = Tembin::find($id);
        $tembin->delete();

        return redirect()->route('tembin.index')->with('success', 'Data Tembin berhasil dihapus');
    }
}
