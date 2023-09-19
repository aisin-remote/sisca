<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Tandu;
use Illuminate\Http\Request;

class TanduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tandus = Tandu::get();
        return view('dashboard.tandu.index', compact('tandus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.tandu.create', compact('locations'));
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
            'no_tandu' => 'required|unique:tm_tandus',
            'location_id' => 'required',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_tandu'] = strtoupper($validate['no_tandu']);


        Tandu::create($validate);
        return redirect()->route('tandu.index')->with('success', "Data Tandu {$validate['no_tandu']} berhasil ditambahkan");
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
        $tandu = Tandu::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.tandu.edit', compact('tandu', 'locations'));
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
        $tandu = Tandu::findOrFail($id);

        $validateData = $request->validate([
            'location_id' => 'required',
        ]);

        $tandu->update($validateData);

        return redirect()->route('tandu.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tandu = Tandu::find($id);
        $tandu->delete();

        return redirect()->route('tandu.index')->with('success', 'Data Tandu berhasil dihapus');
    }
}
