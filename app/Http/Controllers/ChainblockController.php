<?php

namespace App\Http\Controllers;

use App\Models\Chainblock;
use App\Models\CheckSheetChainblock;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChainblockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chainblocks = Chainblock::get();
        return view('dashboard.chainblock.index', compact('chainblocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.chainblock.create', compact('locations'));
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
            'no_chainblock' => 'required|unique:tm_chainblocks',
            'location_id' => 'required',
            'handling_detail' => 'required',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_chainblock'] = strtoupper($validate['no_chainblock']);


        Chainblock::create($validate);
        return redirect()->route('chain-block.index')->with('success', "Data Chain Block {$validate['no_chainblock']} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chainblock = Chainblock::findOrFail($id);

        if (!$chainblock) {
            return back()->with('error', 'Chain Block tidak ditemukan.');
        }

        $checksheets = CheckSheetChainblock::where('chainblock_number', $chainblock->no_chainblock);
        $firstYear = CheckSheetChainblock::min(DB::raw('YEAR(tanggal_pengecekan)'));
        $lastYear = CheckSheetChainblock::max(DB::raw('YEAR(tanggal_pengecekan)'));

        if (request()->has('tahun_filter')) {
            $tahunFilter = request()->input('tahun_filter');
            $checksheets->whereYear('tanggal_pengecekan', $tahunFilter);
        }

        $checksheets = $checksheets->get();

        return view('dashboard.chainblock.show', compact('chainblock', 'checksheets', 'firstYear', 'lastYear'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chainblock = Chainblock::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.chainblock.edit', compact('chainblock', 'locations'));
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
        $chainblock = Chainblock::findOrFail($id);

        $validateData = $request->validate([
            'location_id' => 'required',
            'handling_detail' => 'required',
        ]);

        $chainblock->update($validateData);

        return redirect()->route('chain-block.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chainblock = Chainblock::find($id);
        $chainblock->delete();

        return redirect()->route('chain-block.index')->with('success', 'Data Chain Block berhasil dihapus');
    }
}
