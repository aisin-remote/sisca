<?php

namespace App\Http\Controllers;

use App\Models\Chainblock;
use App\Models\CheckSheetChainblock;
use App\Models\CheckSheetTembin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request, $id)
    {
        $checkSheetchainblock = CheckSheetChainblock::findOrFail($id);

        // Validasi data yang diinputkan
        $rules = [
            'geared_trolley' => 'required',
            'catatan_geared_trolley' => 'nullable|string|max:255',
            'photo_geared_trolley' => 'image|file|max:3072',
            'chain_geared_trolley_1' => 'required',
            'catatan_chain_geared_trolley_1' => 'nullable|string|max:255',
            'photo_chain_geared_trolley_1' => 'image|file|max:3072',
            'chain_geared_trolley_2' => 'required',
            'catatan_chain_geared_trolley_2' => 'nullable|string|max:255',
            'photo_chain_geared_trolley_2' => 'image|file|max:3072',
            'hooking_geared_trolly' => 'required',
            'catatan_hooking_geared_trolly' => 'nullable|string|max:255',
            'photo_hooking_geared_trolly' => 'image|file|max:3072',
            'latch_hook_atas' => 'required',
            'catatan_latch_hook_atas' => 'nullable|string|max:255',
            'photo_latch_hook_atas' => 'image|file|max:3072',
            'hook_atas' => 'required',
            'catatan_hook_atas' => 'nullable|string|max:255',
            'photo_hook_atas' => 'image|file|max:3072',
            'hand_chain' => 'required',
            'catatan_hand_chain' => 'nullable|string|max:255',
            'photo_hand_chain' => 'image|file|max:3072',
            'load_chain' => 'required',
            'catatan_load_chain' => 'nullable|string|max:255',
            'photo_load_chain' => 'image|file|max:3072',
            'latch_hook_bawah' => 'required',
            'catatan_latch_hook_bawah' => 'nullable|string|max:255',
            'photo_latch_hook_bawah' => 'image|file|max:3072',
            'hook_bawah' => 'required',
            'catatan_hook_bawah' => 'nullable|string|max:255',
            'photo_hook_bawah' => 'image|file|max:3072',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('photo_geared_trolley')) {
            if ($request->oldImage_geared_trolley) {
                Storage::delete($request->oldImage_geared_trolley);
            }
            $validatedData['photo_geared_trolley'] = $request->file('photo_geared_trolley')->store('checksheet-chain-block');
        }

        if ($request->file('photo_chain_geared_trolley_1')) {
            if ($request->oldImage_chain_geared_trolley_1) {
                Storage::delete($request->oldImage_chain_geared_trolley_1);
            }
            $validatedData['photo_chain_geared_trolley_1'] = $request->file('photo_chain_geared_trolley_1')->store('checksheet-chain-block');
        }

        if ($request->file('photo_chain_geared_trolley_2')) {
            if ($request->oldImage_chain_geared_trolley_2) {
                Storage::delete($request->oldImage_chain_geared_trolley_2);
            }
            $validatedData['photo_chain_geared_trolley_2'] = $request->file('photo_chain_geared_trolley_2')->store('checksheet-chain-block');
        }

        if ($request->file('photo_hooking_geared_trolly')) {
            if ($request->oldImage_hooking_geared_trolly) {
                Storage::delete($request->oldImage_hooking_geared_trolly);
            }
            $validatedData['photo_hooking_geared_trolly'] = $request->file('photo_hooking_geared_trolly')->store('checksheet-chain-block');
        }

        if ($request->file('photo_latch_hook_atas')) {
            if ($request->oldImage_latch_hook_atas) {
                Storage::delete($request->oldImage_latch_hook_atas);
            }
            $validatedData['photo_latch_hook_atas'] = $request->file('photo_latch_hook_atas')->store('checksheet-chain-block');
        }

        if ($request->file('photo_hook_atas')) {
            if ($request->oldImage_hook_atas) {
                Storage::delete($request->oldImage_hook_atas);
            }
            $validatedData['photo_hook_atas'] = $request->file('photo_hook_atas')->store('checksheet-chain-block');
        }

        if ($request->file('photo_hand_chain')) {
            if ($request->oldImage_hand_chain) {
                Storage::delete($request->oldImage_hand_chain);
            }
            $validatedData['photo_hand_chain'] = $request->file('photo_hand_chain')->store('checksheet-chain-block');
        }

        if ($request->file('photo_load_chain')) {
            if ($request->oldImage_load_chain) {
                Storage::delete($request->oldImage_load_chain);
            }
            $validatedData['photo_load_chain'] = $request->file('photo_load_chain')->store('checksheet-chain-block');
        }

        if ($request->file('photo_latch_hook_bawah')) {
            if ($request->oldImage_latch_hook_bawah) {
                Storage::delete($request->oldImage_latch_hook_bawah);
            }
            $validatedData['photo_latch_hook_bawah'] = $request->file('photo_latch_hook_bawah')->store('checksheet-chain-block');
        }

        if ($request->file('photo_hook_bawah')) {
            if ($request->oldImage_hook_bawah) {
                Storage::delete($request->oldImage_hook_bawah);
            }
            $validatedData['photo_hook_bawah'] = $request->file('photo_hook_bawah')->store('checksheet-chain-block');
        }


        // Update data CheckSheetCo2 dengan data baru dari form
        $checkSheetchainblock->update($validatedData);

        $chainblock = Chainblock::where('no_chainblock', $checkSheetchainblock->chainblock_number)->first();

        if (!$chainblock) {
            return back()->with('error', 'Chain Block tidak ditemukan.');
        }

        return redirect()->route('chain-block.show', $chainblock->id)->with('success1', 'Data Check Sheet Chain Block berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $checkSheetchainblock = CheckSheetChainblock::find($id);

        if ($checkSheetchainblock->photo_geared_trolley || $checkSheetchainblock->photo_chain_geared_trolley_1 || $checkSheetchainblock->photo_chain_geared_trolley_2 || $checkSheetchainblock->photo_hooking_geared_trolly || $checkSheetchainblock->photo_latch_hook_atas || $checkSheetchainblock->photo_hook_atas || $checkSheetchainblock->photo_hand_chain || $checkSheetchainblock->photo_load_chain || $checkSheetchainblock->photo_latch_hook_bawah || $checkSheetchainblock->photo_hook_bawah) {
            Storage::delete($checkSheetchainblock->photo_geared_trolley);
            Storage::delete($checkSheetchainblock->photo_chain_geared_trolley_1);
            Storage::delete($checkSheetchainblock->photo_chain_geared_trolley_2);
            Storage::delete($checkSheetchainblock->photo_hooking_geared_trolly);
            Storage::delete($checkSheetchainblock->photo_latch_hook_atas);
            Storage::delete($checkSheetchainblock->photo_hook_atas);
            Storage::delete($checkSheetchainblock->photo_hand_chain);
            Storage::delete($checkSheetchainblock->photo_load_chain);
            Storage::delete($checkSheetchainblock->photo_latch_hook_bawah);
            Storage::delete($checkSheetchainblock->photo_hook_bawah);
        }

        $checkSheetchainblock->delete();

        return back()->with('success1', 'Data Check Sheet Chain Block berhasil dihapus');
    }

    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheetchainblock = CheckSheetChainblock::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.chainblock.checksheet.index', compact('checksheetchainblock'));
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $chainblockData = Chainblock::leftJoin('tt_check_sheet_chainblocks', 'tm_chainblocks.no_chainblock', '=', 'tt_check_sheet_chainblocks.chainblock_number')
            ->select(
                'tm_chainblocks.no_chainblock as chainblock_number',
                'tt_check_sheet_chainblocks.tanggal_pengecekan',
                'tt_check_sheet_chainblocks.geared_trolley',
                'tt_check_sheet_chainblocks.chain_geared_trolley_1',
                'tt_check_sheet_chainblocks.chain_geared_trolley_2',
                'tt_check_sheet_chainblocks.hooking_geared_trolly',
                'tt_check_sheet_chainblocks.latch_hook_atas',
                'tt_check_sheet_chainblocks.hook_atas',
                'tt_check_sheet_chainblocks.hand_chain',
                'tt_check_sheet_chainblocks.load_chain',
                'tt_check_sheet_chainblocks.latch_hook_bawah',
                'tt_check_sheet_chainblocks.hook_bawah',
            )
            ->get();

        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredChainblockData = $chainblockData->filter(function ($chainblock) use ($selectedYear) {
            return $chainblock->tanggal_pengecekan !== null &&
                date('Y', strtotime($chainblock->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedChainblockData = $filteredChainblockData->groupBy('chainblock_number')->map(function ($chainblockGroup) {
            $chainblockNumber = $chainblockGroup[0]['chainblock_number'];
            $chainblockPengecekan = $chainblockGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($chainblockGroup as $chainblock) {
                $month = date('n', strtotime($chainblock['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($chainblock['geared_trolley'] === 'NG') $issueCodes[] = 'a';
                if ($chainblock['chain_geared_trolley_1'] === 'NG') $issueCodes[] = 'b';
                if ($chainblock['chain_geared_trolley_2'] === 'NG') $issueCodes[] = 'c';
                if ($chainblock['hooking_geared_trolly'] === 'NG') $issueCodes[] = 'd';
                if ($chainblock['latch_hook_atas'] === 'NG') $issueCodes[] = 'e';
                if ($chainblock['hook_atas'] === 'NG') $issueCodes[] = 'f';
                if ($chainblock['hand_chain'] === 'NG') $issueCodes[] = 'g';
                if ($chainblock['load_chain'] === 'NG') $issueCodes[] = 'h';
                if ($chainblock['latch_hook_bawah'] === 'NG') $issueCodes[] = 'i';
                if ($chainblock['hook_bawah'] === 'NG') $issueCodes[] = 'j';

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }

                $months[$month] = $issueCodes;
            }

            return [
                'chainblock_number' => $chainblockNumber,
                'tanggal_pengecekan' => $chainblockPengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedChainblockData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('chainblock_data.json', $jsonString);

        return view('dashboard.chainblock_report', [
            'chainblockData' => $mappedChainblockData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
