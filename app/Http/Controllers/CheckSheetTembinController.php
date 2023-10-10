<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetTembin;
use App\Models\Tandu;
use App\Models\Tembin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckSheetTembinController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetTembins = CheckSheetTembin::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.tembin.checksheet.check', compact('latestCheckSheetTembins'));
    }

    public function processForm(Request $request)
    {
        $tembinNumber = $request->input('tembin_number');

        $tembin = Tembin::where('no_equip', $tembinNumber)->first();

        if (!$tembin) {
            return back()->with('error', 'Equip Number tidak ditemukan.');
        }

        $tembinNumber = strtoupper($tembinNumber);

        return redirect()->route('checksheettembin', compact('tembinNumber'));
    }

    public function createForm($tembinNumber)
    {
        $latestCheckSheetTembins = CheckSheetTembin::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $tembin = Tembin::where('no_equip', $tembinNumber)->first();

        if (!$tembin) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('tembin.show.form', compact('latestCheckSheetTembins'))->with('error', 'Equip Number tidak ditemukan.');
        }

        $tembinNumber = strtoupper($tembinNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetTembin::where('tembin_number', $tembinNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('tembin.checksheettembin.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Tembin sudah ada untuk Tembin ' . $tembinNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetTembins = CheckSheetTembin::all();
            return view('dashboard.tembin.checksheet.checkTembin', compact('checkSheetTembins', 'tembinNumber'));
        }
    }
}
