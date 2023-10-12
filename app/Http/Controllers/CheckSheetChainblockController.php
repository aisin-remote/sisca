<?php

namespace App\Http\Controllers;

use App\Models\Chainblock;
use App\Models\CheckSheetChainblock;
use App\Models\CheckSheetTembin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckSheetChainblockController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetChainblocks = CheckSheetChainblock::orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard.chainblock.checksheet.check', compact('latestCheckSheetChainblocks'));
    }

    public function processForm(Request $request)
    {
        $chainblockNumber = $request->input('chainblock_number');

        $chainblock = Chainblock::where('no_chainblock', $chainblockNumber)->first();

        if (!$chainblock) {
            return back()->with('error', 'Chain Block Number tidak ditemukan.');
        }

        $chainblockNumber = strtoupper($chainblockNumber);

        return redirect()->route('checksheetchainblock', compact('chainblockNumber'));
    }

    public function createForm($chainblockNumber)
    {
        $latestCheckSheetChainblocks = CheckSheetChainblock::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri Co2 berdasarkan no_tabung
        $chainblock = Chainblock::where('no_chainblock', $chainblockNumber)->first();

        if (!$chainblock) {
            // Jika no_tabung tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->route('chainblock.show.form', compact('latestCheckSheetChainblocks'))->with('error', 'Chain Block Number tidak ditemukan.');
        }

        $chainblockNumber = strtoupper($chainblockNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetChainblock::where('chainblock_number', $chainblockNumber)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, tampilkan halaman edit
            return redirect()->route('chainblock.checksheetchainblock.edit', $existingCheckSheet->id)
                ->with('error', 'Check Sheet Chain Block sudah ada untuk Chain Block ' . $chainblockNumber . ' pada bulan ini. Silahkan edit.');
        } else {
            // Jika belum ada entri, tampilkan halaman create
            $checkSheetChainblocks = CheckSheetChainblock::all();
            return view('dashboard.chainblock.checksheet.checkChainblock', compact('checkSheetChainblocks', 'chainblockNumber'));
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mencari entri CheckSheetIndoor untuk bulan dan tahun saat ini
        $existingCheckSheet = CheckSheetChainblock::where('chainblock_number', $request->chainblock_number)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        if ($existingCheckSheet) {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'chainblock_number' => 'required',
                'geared_trolley' => 'required',
                'catatan_geared_trolley' => 'nullable|string|max:255',
                'photo_geared_trolley' => 'required|image|file|max:3072',
                'chain_geared_trolley_1' => 'required',
                'catatan_chain_geared_trolley_1' => 'nullable|string|max:255',
                'photo_chain_geared_trolley_1' => 'required|image|file|max:3072',
                'chain_geared_trolley_2' => 'required',
                'catatan_chain_geared_trolley_2' => 'nullable|string|max:255',
                'photo_chain_geared_trolley_2' => 'required|image|file|max:3072',
                'hooking_geared_trolly' => 'required',
                'catatan_hooking_geared_trolly' => 'nullable|string|max:255',
                'photo_hooking_geared_trolly' => 'required|image|file|max:3072',
                'latch_hook_atas' => 'required',
                'catatan_latch_hook_atas' => 'nullable|string|max:255',
                'photo_latch_hook_atas' => 'required|image|file|max:3072',
                'hook_atas' => 'required',
                'catatan_hook_atas' => 'nullable|string|max:255',
                'photo_hook_atas' => 'required|image|file|max:3072',
                'hand_chain' => 'required',
                'catatan_hand_chain' => 'nullable|string|max:255',
                'photo_hand_chain' => 'required|image|file|max:3072',
                'load_chain' => 'required',
                'catatan_load_chain' => 'nullable|string|max:255',
                'photo_load_chain' => 'required|image|file|max:3072',
                'latch_hook_bawah' => 'required',
                'catatan_latch_hook_bawah' => 'nullable|string|max:255',
                'photo_latch_hook_bawah' => 'required|image|file|max:3072',
                'hook_bawah' => 'required',
                'catatan_hook_bawah' => 'nullable|string|max:255',
                'photo_hook_bawah' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['chainblock_number'] = strtoupper($validatedData['chainblock_number']);

            if ($request->file('photo_geared_trolley') && $request->file('photo_chain_geared_trolley_1') && $request->file('photo_chain_geared_trolley_2') && $request->file('photo_hooking_geared_trolly') && $request->file('photo_latch_hook_atas') && $request->file('photo_hook_atas') && $request->file('photo_hand_chain') && $request->file('photo_load_chain') && $request->file('photo_latch_hook_bawah') && $request->file('photo_hook_bawah')) {
                $validatedData['photo_geared_trolley'] = $request->file('photo_geared_trolley')->store('checksheet-chain-block');
                $validatedData['photo_chain_geared_trolley_1'] = $request->file('photo_chain_geared_trolley_1')->store('checksheet-chain-block');
                $validatedData['photo_chain_geared_trolley_2'] = $request->file('photo_chain_geared_trolley_2')->store('checksheet-chain-block');
                $validatedData['photo_hooking_geared_trolly'] = $request->file('photo_hooking_geared_trolly')->store('checksheet-chain-block');
                $validatedData['photo_latch_hook_atas'] = $request->file('photo_latch_hook_atas')->store('checksheet-chain-block');
                $validatedData['photo_hook_atas'] = $request->file('photo_hook_atas')->store('checksheet-chain-block');
                $validatedData['photo_hand_chain'] = $request->file('photo_hand_chain')->store('checksheet-chain-block');
                $validatedData['photo_load_chain'] = $request->file('photo_load_chain')->store('checksheet-chain-block');
                $validatedData['photo_latch_hook_bawah'] = $request->file('photo_latch_hook_bawah')->store('checksheet-chain-block');
                $validatedData['photo_hook_bawah'] = $request->file('photo_hook_bawah')->store('checksheet-chain-block');
            }

            // Perbarui data entri yang sudah ada
            $existingCheckSheet->update($validatedData);

            return redirect()->route('chainblock.show.form')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika sudah ada entri, perbarui entri tersebut
            $validatedData = $request->validate([
                'tanggal_pengecekan' => 'required|date',
                'npk' => 'required',
                'chainblock_number' => 'required',
                'geared_trolley' => 'required',
                'catatan_geared_trolley' => 'nullable|string|max:255',
                'photo_geared_trolley' => 'required|image|file|max:3072',
                'chain_geared_trolley_1' => 'required',
                'catatan_chain_geared_trolley_1' => 'nullable|string|max:255',
                'photo_chain_geared_trolley_1' => 'required|image|file|max:3072',
                'chain_geared_trolley_2' => 'required',
                'catatan_chain_geared_trolley_2' => 'nullable|string|max:255',
                'photo_chain_geared_trolley_2' => 'required|image|file|max:3072',
                'hooking_geared_trolly' => 'required',
                'catatan_hooking_geared_trolly' => 'nullable|string|max:255',
                'photo_hooking_geared_trolly' => 'required|image|file|max:3072',
                'latch_hook_atas' => 'required',
                'catatan_latch_hook_atas' => 'nullable|string|max:255',
                'photo_latch_hook_atas' => 'required|image|file|max:3072',
                'hook_atas' => 'required',
                'catatan_hook_atas' => 'nullable|string|max:255',
                'photo_hook_atas' => 'required|image|file|max:3072',
                'hand_chain' => 'required',
                'catatan_hand_chain' => 'nullable|string|max:255',
                'photo_hand_chain' => 'required|image|file|max:3072',
                'load_chain' => 'required',
                'catatan_load_chain' => 'nullable|string|max:255',
                'photo_load_chain' => 'required|image|file|max:3072',
                'latch_hook_bawah' => 'required',
                'catatan_latch_hook_bawah' => 'nullable|string|max:255',
                'photo_latch_hook_bawah' => 'required|image|file|max:3072',
                'hook_bawah' => 'required',
                'catatan_hook_bawah' => 'nullable|string|max:255',
                'photo_hook_bawah' => 'required|image|file|max:3072',
                // tambahkan validasi untuk atribut lainnya
            ]);

            $validatedData['chainblock_number'] = strtoupper($validatedData['chainblock_number']);

            if ($request->file('photo_geared_trolley') && $request->file('photo_chain_geared_trolley_1') && $request->file('photo_chain_geared_trolley_2') && $request->file('photo_hooking_geared_trolly') && $request->file('photo_latch_hook_atas') && $request->file('photo_hook_atas') && $request->file('photo_hand_chain') && $request->file('photo_load_chain') && $request->file('photo_latch_hook_bawah') && $request->file('photo_hook_bawah')) {
                $validatedData['photo_geared_trolley'] = $request->file('photo_geared_trolley')->store('checksheet-chain-block');
                $validatedData['photo_chain_geared_trolley_1'] = $request->file('photo_chain_geared_trolley_1')->store('checksheet-chain-block');
                $validatedData['photo_chain_geared_trolley_2'] = $request->file('photo_chain_geared_trolley_2')->store('checksheet-chain-block');
                $validatedData['photo_hooking_geared_trolly'] = $request->file('photo_hooking_geared_trolly')->store('checksheet-chain-block');
                $validatedData['photo_latch_hook_atas'] = $request->file('photo_latch_hook_atas')->store('checksheet-chain-block');
                $validatedData['photo_hook_atas'] = $request->file('photo_hook_atas')->store('checksheet-chain-block');
                $validatedData['photo_hand_chain'] = $request->file('photo_hand_chain')->store('checksheet-chain-block');
                $validatedData['photo_load_chain'] = $request->file('photo_load_chain')->store('checksheet-chain-block');
                $validatedData['photo_latch_hook_bawah'] = $request->file('photo_latch_hook_bawah')->store('checksheet-chain-block');
                $validatedData['photo_hook_bawah'] = $request->file('photo_hook_bawah')->store('checksheet-chain-block');
            }

            // Tambahkan npk ke dalam validated data berdasarkan user yang terautentikasi
            $validatedData['npk'] = auth()->user()->npk;

            // Simpan data baru ke database menggunakan metode create
            CheckSheetChainblock::create($validatedData);

            return redirect()->route('chainblock.show.form')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function show($id)
    {
        $checksheet = CheckSheetChainblock::findOrFail($id);

        return view('dashboard.chainblock.checksheet.show', compact('checksheet'));
    }

    public function edit($id)
    {
        $checkSheetchainblock = CheckSheetChainblock::findOrFail($id);
        return view('dashboard.chainblock.checksheet.edit', compact('checkSheetchainblock'));
    }
}
