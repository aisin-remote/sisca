<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHeadCrane;
use App\Models\ChecksheetItemHeadcrane;
use App\Models\HeadCrane;
use App\Models\ItemCheckHeadCrane;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HeadCraneController extends Controller
{
    public function index()
    {
        $head_crane = HeadCrane::get();
        return view('dashboard.headcrane.master.index', compact('head_crane'));
    }
    public function create()
    {
        $locations = Location::get();
        return view('dashboard.headcrane.master.create', compact('locations'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_headcrane' => 'required|unique:tm_headcranes',
            'location_id' => 'required',
            'plant' => 'nullable',
        ]);

        // Mengubah 'no_tabung' menjadi huruf besar
        $validate['no_headcrane'] = strtoupper($validate['no_headcrane']);


        HeadCrane::create($validate);
        return redirect()->route('head-crane.index')->with('success', "Data Head Crane {$validate['no_headcrane']} berhasil ditambahkan");
    }
    public function show($id)
{
    // Cari data HeadCrane berdasarkan ID
    $headcrane = CheckSheetHeadCrane::find($id);

    if (!$headcrane) {
        return back()->with('error', 'Head Crane tidak ditemukan.');
    }

    // Ambil data CheckSheet dan item check yang terkait dengan headcrane ini
    $checksheetItems = ChecksheetItemHeadcrane::select('tt_check_sheet_item_headcrane.*', 'tm_item_check_head_crane.item_check')
        ->join('tm_item_check_head_crane', 'tt_check_sheet_item_headcrane.item_check_id', 'tm_item_check_head_crane.id')
        ->with(['checkSheet.headcrane', 'itemCheck'])
        ->where('check_sheet_id', $id)
        ->get();

    // Group by check_sheet_id dan item_check untuk menghitung jumlah data berdasarkan item_check
    $groupedByCheckSheetId = $checksheetItems->groupBy('check_sheet_id')->map(function ($itemsByCheckSheetId) {
        $groupedByItemCheck = $itemsByCheckSheetId->groupBy('item_check')->map(function ($itemsByItemCheck) {
            $countOk = $itemsByItemCheck->where('check', 'OK')->count(); // Jumlah OK
            $countNg = $itemsByItemCheck->where('check', 'NG')->count(); // Jumlah NG
            $total = $itemsByItemCheck->count(); // Jumlah total

            return [
                'OK' => $countOk,
                'NG' => $countNg,
                'total' => $total,
                'items' => $itemsByItemCheck, // Data terkait untuk ditampilkan
            ];
        });

        return [
            'checkSheetId' => $itemsByCheckSheetId->first()->check_sheet_id, // ID dari check_sheet
            'groupedByItemCheck' => $groupedByItemCheck, // Data yang telah dikelompokkan berdasarkan item_check
        ];
    });
// dd($groupedByCheckSheetId);
    // Ambil tahun pertama dan terakhir dari tanggal pengecekan
    $firstYear = CheckSheetHeadCrane::min(DB::raw('YEAR(tanggal_pengecekan)'));
    $lastYear = CheckSheetHeadCrane::max(DB::raw('YEAR(tanggal_pengecekan)'));

    return view('dashboard.headcrane.master.show', compact('headcrane', 'groupedByCheckSheetId', 'firstYear', 'lastYear'));
}

    

    public function edit($id)
    {
        $headcrane = HeadCrane::findOrFail($id);
        $locations = Location::all();
        return view('dashboard.headcrane.master.edit', compact('headcrane', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $headcrane = HeadCrane::findOrFail($id);

        // Ambil data dari request dan lakukan validasi manual jika diperlukan
        $inputData = $request->only(['location_id', 'plant']);

        // Update data headcrane
        $headcrane->update($inputData);

        // Redirect dengan pesan sukses
        return redirect()->route('head-crane.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $headcrane = HeadCrane::find($id);
        $headcrane->delete();

        return redirect()->route('head-crane.index')->with('success', 'Data Head Crane berhasil dihapus');
    }
    public function location()
    {
        return view('dashboard.headcrane.location.index');
    }
}
