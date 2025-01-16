<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetHeadCrane;
use App\Models\ChecksheetItemHeadcrane;
use App\Models\HeadCrane;
use App\Models\ItemCheckHeadCrane;
use App\Models\ProsedurItemCheckHeadCrane;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CheckSheetHeadCraneController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetHeadCranes = CheckSheetHeadCrane::select('tm_check_sheet_head_crane.*', 'tm_headcranes.no_headcrane')
        ->join('tm_headcranes', 'tm_check_sheet_head_crane.headcrane_id', '=', 'tm_headcranes.id') // Lakukan join
        ->orderBy('tm_check_sheet_head_crane.updated_at', 'desc')
        ->distinct('tm_check_sheet_head_crane.headcrane_id') // Menggunakan headcrane_id untuk menyaring duplikat
        ->take(10) // Ambil 10 hasil terbaru
        ->get();


        return view('dashboard.headcrane.checksheet.check', compact('latestCheckSheetHeadCranes'));
    }

    public function processForm(Request $request)
    {
        if (auth()->user()->role != 'Admin' && auth()->user()->role != 'MTE') {
            return back()->with('error', 'Hanya admin dan mte yang dapat melakukan check');
        }

        $headcraneNumber = $request->input('headcrane_number');

        $headcrane = HeadCrane::where('no_headcrane', $headcraneNumber)->first();

        if (!$headcrane) {
            return back()->with('error', 'Head Crane Number tidak ditemukan.');
        }

        $headcraneNumber = strtoupper($headcraneNumber);

        return redirect()->route('CheckSheetHeadCrane', compact('headcraneNumber'));
    }

    public function createForm($headcraneNumber)
    {
        $latestCheckSheetHeadCranes = CheckSheetHeadCrane::orderBy('updated_at', 'desc')->take(10)->get();

        // Mencari entri HeadCrane berdasarkan nomor headcrane
        $headcrane = HeadCrane::where('no_headcrane', $headcraneNumber)->first();
        if (!$headcrane) {
            return redirect()->route('headcrane.show.form', compact('latestCheckSheetHeadCranes'))
                ->with('error', 'Head Crane Number tidak ditemukan.');
        }

        $headcraneNumber = strtoupper($headcraneNumber);

        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Menghitung musim berdasarkan bulan saat ini
        $season = match (true) {
            $currentMonth >= 4 && $currentMonth <= 6 => 1,
            $currentMonth >= 7 && $currentMonth <= 9 => 2,
            $currentMonth >= 10 && $currentMonth <= 12 => 3,
            default => 4,
        };

        // Menghitung bulan awal musim untuk melakukan pengecekan
        $startMonth = match ($season) {
            1 => 4,
            2 => 7,
            3 => 10,
            4 => 1,
        };

        // Mencari entri CheckSheetHeadCrane berdasarkan nomor headcrane dan triwulan
        $existingCheckSheet = CheckSheetHeadCrane::whereHas('headcrane', function ($query) use ($headcraneNumber) {
            $query->where('no_headcrane', $headcraneNumber); // Menggunakan kolom no_headcrane dari tm_headcranes
        })
        ->whereYear('created_at', $currentYear)
        ->whereMonth('created_at', '>=', $startMonth)
        ->whereMonth('created_at', '<=', $startMonth + 2)
        ->first();
    
        $existingCheckSheet = CheckSheetHeadCrane::whereHas('headcrane', function ($query) use ($headcraneNumber) {
            $query->where('no_headcrane', $headcraneNumber);
        })
        ->whereYear('created_at', $currentYear)
        ->whereMonth('created_at', '>=', $startMonth)
        ->whereMonth('created_at', '<=', $startMonth + 2)
        ->first();
    
    if ($existingCheckSheet) {
        return redirect()->route('headcrane.checksheetheadcrane.edit', $existingCheckSheet->id)
            ->with('error', 'Check Sheet headcrane sudah ada untuk headcrane ' . $headcraneNumber . ' pada triwulan ini. Silahkan edit.');
    } else {
        // Ambil semua item checksheet dan prosedur terkait
        $itemChecksheets = ItemCheckHeadCrane::all();
        // Mengambil data prosedur terkait melalui relasi
        return view('dashboard.headcrane.checksheet.checkheadcrane', compact('headcraneNumber', 'itemChecksheets'));
    }
    }
    public function store(Request $request)
{
    // dd($request);
    // Validasi input utama
    $validated = $request->validate([
        'tanggal_pengecekan' => 'required|date',
        'npk' => 'required|string',
        'headcrane_number' => 'required|string',
    ]);

    // Ambil headcrane_id berdasarkan headcrane_number
    $headcrane = HeadCrane::where('no_headcrane', $request->headcrane_number)->firstOrFail();

    // Simpan data ke tabel tm_check_sheet_head_crane
    $checkSheet = CheckSheetHeadCrane::create([
        'tanggal_pengecekan' => $validated['tanggal_pengecekan'],
        'npk' => $validated['npk'],
        'headcrane_id' => $headcrane->id,
    ]);

    // Ambil semua item check
    $itemChecksheets = ItemCheckHeadCrane::all();

    // Simpan setiap item checksheet ke tabel checksheet_item_headcrane
    foreach ($itemChecksheets as $item) {
        $photoPath = null;

        // Simpan foto jika ada file upload untuk item ini
        if ($request->hasFile("photo.$item->id")) {
            $photoPath = $request->file("photo.$item->id")->store('photos/headcrane', 'public');
        }

        ChecksheetItemHeadcrane::create([
            'check_sheet_id' => $checkSheet->id,
            'item_check_id' => $item->id,
            'check' => $request->input("check.$item->id"), // Nilai check sesuai item
            'catatan' => $request->input("note.$item->id"), // Catatan sesuai item
            'photo' => $photoPath, // Path foto sesuai item
        ]);
    }

    return redirect()->route('headcrane.checksheet.index')->with('success', 'Check sheet berhasil disimpan.');
}
    public function show($id)
{
    // Cek apakah check_sheet_id ada di database
    $checkSheet = CheckSheetHeadCrane::find($id);

    // Validasi jika data tidak ditemukan
    if (!$checkSheet) {
        return redirect()->route('headcrane.checksheetheadcrane.index')->with('error', 'Check Sheet tidak ditemukan');
    }

    // Ambil data checksheetItems dengan relasi checkSheet, headcrane, dan itemCheck
    $checksheetItems = ChecksheetItemHeadcrane::with(['checkSheet.headcrane', 'itemCheck'])
        ->where('check_sheet_id', $id)
        ->get();

    // Validasi jika tidak ada item pada checkSheet
    if ($checksheetItems->isEmpty()) {
        return redirect()->route('headcrane.checksheetheadcrane.index')->with('error', 'Data Item Check tidak ditemukan');
    }

    // Kirim data ke view
    return view('dashboard.headcrane.checksheet.show', compact('checksheetItems'));
}

public function edit($id)
{
    // Temukan data CheckSheetHeadCrane berdasarkan ID
    $checkSheetheadcrane = CheckSheetHeadCrane::findOrFail($id);

    // Ambil item checksheet terkait
    $itemChecksheets = CheckSheetItemHeadCrane::with('checkSheet.headcrane','itemCheck')->where('check_sheet_id', $id)->get();

    // Kirim data ke view
    return view('dashboard.headcrane.checksheet.edit', compact('checkSheetheadcrane', 'itemChecksheets'));
}
public function update(Request $request, $id)
{
    // dd($request);
    try {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal_pengecekan' => 'required|date',
            'check' => 'required|array',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'note' => 'nullable|array',
        ]);

        // Ambil CheckSheet berdasarkan ID
        $checkSheet = CheckSheetHeadCrane::findOrFail($id);

        // Iterasi setiap item checksheet
        foreach ($request->check as $itemId => $checkStatus) {
            // Ambil item checksheet berdasarkan ID
            $itemChecksheet = CheckSheetItemHeadCrane::where('check_sheet_id', $checkSheet->id)
                ->where('id', $itemId)
                ->firstOrFail();

            // Perbarui data item checksheet
            $itemChecksheet->check = $checkStatus;

            // Perbarui photo jika ada
            if ($request->hasFile("photo.$itemId")) {
                $photo = $request->file("photo.$itemId");

                // Simpan file ke direktori public/storage/photos
                $photoPath = $photo->store('photos', 'public');

                // Hapus photo lama jika ada
                if ($itemChecksheet->photo) {
                    Storage::disk('public')->delete($itemChecksheet->photo);
                }

                // Simpan path photo baru
                $itemChecksheet->photo = $photoPath;
            }

            // Perbarui catatan
            $itemChecksheet->catatan = $request->note[$itemId] ?? null;

            // Simpan perubahan
            $itemChecksheet->save();
        }

        return redirect()->route('headcrane.checksheet.index')
            ->with('success', 'Checksheet berhasil diperbarui.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    public function destroy($id)
    {
        $CheckSheetHeadCrane = CheckSheetHeadCrane::find($id);

        if ($CheckSheetHeadCrane->photo_cross_travelling || $CheckSheetHeadCrane->photo_long_travelling || $CheckSheetHeadCrane->photo_button_up || $CheckSheetHeadCrane->photo_button_down || $CheckSheetHeadCrane->photo_button_push || $CheckSheetHeadCrane->photo_wire_rope || $CheckSheetHeadCrane->photo_block_hook || $CheckSheetHeadCrane->photo_hom || $CheckSheetHeadCrane->photo_emergency_stop) {
            Storage::delete($CheckSheetHeadCrane->photo_cross_travelling);
            Storage::delete($CheckSheetHeadCrane->photo_long_travelling);
            Storage::delete($CheckSheetHeadCrane->photo_button_up);
            Storage::delete($CheckSheetHeadCrane->photo_button_down);
            Storage::delete($CheckSheetHeadCrane->photo_button_push);
            Storage::delete($CheckSheetHeadCrane->photo_wire_rope);
            Storage::delete($CheckSheetHeadCrane->photo_block_hook);
            Storage::delete($CheckSheetHeadCrane->photo_hom);
            Storage::delete($CheckSheetHeadCrane->photo_emergency_stop);
        }

        $CheckSheetHeadCrane->delete();

        return back()->with('success1', 'Data Check Sheet Head Crane berhasil dihapus');
    }

    public function index(Request $request)
{
    // Mengambil filter tanggal jika ada
    $tanggal_filter = $request->input('tanggal_filter');

    // Ambil data checksheet dan join dengan tabel tm_item_check_head_crane
    $checksheetheadcrane = ChecksheetItemHeadcrane::select('tt_check_sheet_item_headcrane.*', 'tm_item_check_head_crane.item_check', 'tm_check_sheet_head_crane.tanggal_pengecekan', 'tm_check_sheet_head_crane.npk', 'tm_headcranes.no_headcrane')
        ->join('tm_item_check_head_crane', 'tt_check_sheet_item_headcrane.item_check_id', '=', 'tm_item_check_head_crane.id')
        ->join('tm_check_sheet_head_crane', 'tt_check_sheet_item_headcrane.check_sheet_id', '=', 'tm_check_sheet_head_crane.id')
        ->join('tm_headcranes', 'tm_check_sheet_head_crane.headcrane_id', '=', 'tm_headcranes.id')
        ->when($tanggal_filter, function ($query) use ($tanggal_filter) {
            // Jika filter tanggal ada, tambahkan kondisi filter berdasarkan tanggal
            return $query->whereDate('tt_check_sheet_item_headcrcrane.created_at', $tanggal_filter);
        })
        ->get();

    // Group by 'check_sheet_id', lalu di dalamnya group by 'item_check'
    $groupedChecksheet = $checksheetheadcrane->groupBy('check_sheet_id')->map(function ($group) {
        return $group->groupBy('item_check')->map(function ($itemsByItemCheck) {
            $countOk = $itemsByItemCheck->where('check', 'OK')->count(); // Jumlah OK 
            $countNg = $itemsByItemCheck->where('check', 'NG')->count(); // Jumlah NG
            $total = $itemsByItemCheck->count(); // Jumlah total

            return [
                'items' => $itemsByItemCheck,
                'countOk' => $countOk,
                'countNg' => $countNg,
                'total' => $total,
            ];
        });
    });
// dd($groupedChecksheet);
    // Kirim data ke view
    return view('dashboard.headcrane.checksheet.index', compact('groupedChecksheet'));
}



    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $headcraneData = CheckSheetItemHeadCrane::all();
            // dd($headcraneData);


        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredheadcraneData = $headcraneData->filter(function ($headcrane) use ($selectedYear) {
            return $headcrane->tanggal_pengecekan !== null &&
                date('Y', strtotime($headcrane->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedheadcraneData = $filteredheadcraneData->groupBy('headcrane_number')->map(function ($headcraneGroup) {
            $headcraneNumber = $headcraneGroup[0]['headcrane_number'];
            $headcranePengecekan = $headcraneGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($headcraneGroup as $headcrane) {
                $month = date('n', strtotime($headcrane['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($headcrane['cross_travelling'] === 'NG') $issueCodes[] = 'a';
                if ($headcrane['long_travelling'] === 'NG') $issueCodes[] = 'b';
                if ($headcrane['button_up'] === 'NG') $issueCodes[] = 'c';
                if ($headcrane['button_down'] === 'NG') $issueCodes[] = 'd';
                if ($headcrane['button_push'] === 'NG') $issueCodes[] = 'e';
                if ($headcrane['wire_rope'] === 'NG') $issueCodes[] = 'f';
                if ($headcrane['block_hook'] === 'NG') $issueCodes[] = 'g';
                if ($headcrane['hom'] === 'NG') $issueCodes[] = 'h';
                if ($headcrane['emergency_stop'] === 'NG') $issueCodes[] = 'i';

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }


                $months[$month] = $issueCodes;
            }

            return [
                'headcrane_number' => $headcraneNumber,
                'tanggal_pengecekan' => $headcranePengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedheadcraneData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('headcrane_data.json', $jsonString);

        return view('dashboard.headcrane.reports.index', [
            'headcraneData' => $mappedheadcraneData,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function exportExcelWithTemplate(Request $request)
    {
        // Load the template Excel file
        $templatePath = public_path('templates/template-checksheet-headcrane.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Retrieve tag_number from the form
        $headcraneNumber = $request->input('headcrane_number');

        // Retrieve the selected year from the form
        $selectedYear = $request->input('tahun');


        // Retrieve data from the checksheetsco2 table for the selected year and tag_number
        $data = CheckSheetHeadCrane::with('HeadCranes')
            ->select('tanggal_pengecekan', 'headcrane_number', 'cross_travelling', 'long_travelling', 'button_up', 'button_down', 'button_push', 'wire_rope', 'block_hook', 'hom', 'emergency_stop')
            ->where(function ($query) use ($selectedYear, $headcraneNumber) {
                // Kondisi untuk memanggil data berdasarkan tahun dan tag_number
                $query->whereYear('tanggal_pengecekan', $selectedYear)
                    ->where('headcrane_number', $headcraneNumber);
            })
            // ->orWhere(function ($query) use ($selectedYear, $headcraneNumber) {
            //     // Kondisi untuk memanggil data bulan Januari tahun selanjutnya
            //     $query->whereMonth('tanggal_pengecekan', 1)
            //         ->whereYear('tanggal_pengecekan', $selectedYear + 1)
            //         ->where('headcrane_number', $headcraneNumber);
            // })
            ->get();


        // Quartal mapping ke kolom
        $quartalKolom = [
            1 => 'AQ',  // Quartal 1 -> Kolom Y
            2 => 'AT', // Quartal 2 -> Kolom AB
            3 => 'AW', // Quartal 3 -> Kolom AE
            4 => 'AN', // Quartal 4 -> Kolom AH
        ];

        $worksheet->setCellValue('AU' . 2, $data[0]->headcrane_number);
        $worksheet->setCellValue('AU' . 3, $data[0]->HeadCranes->locations->location_name);

        foreach ($data as $item) {

            // Ambil bulan dari tanggal_pengecekan menggunakan Carbon
            $bulan = Carbon::parse($item->tanggal_pengecekan)->month;

            if ($bulan >= 4 && $bulan <= 6) {
                $quartal = 1;
            } elseif ($bulan >= 7 && $bulan <= 9) {
                $quartal = 2;
            } elseif ($bulan >= 10 && $bulan <= 12) {
                $quartal = 3;
            } else {
                $quartal = 4;
            }



            // Tentukan kolom berdasarkan bulan
            $col = $quartalKolom[$quartal];

            // Set value based on $item->pressure
            if ($item->cross_travelling === 'OK') {
                $worksheet->setCellValue($col . 9, '√');
            } else if ($item->cross_travelling === 'NG') {
                $worksheet->setCellValue($col . 9, 'X');
            }

            // Set value based on $item->hose
            if ($item->long_travelling === 'OK') {
                $worksheet->setCellValue($col . 12, '√');
            } else if ($item->long_travelling === 'NG') {
                $worksheet->setCellValue($col . 12, 'X');
            }

            // Set value based on $item->corong
            if ($item->button_up === 'OK') {
                $worksheet->setCellValue($col . 15, '√');
            } else if ($item->button_up === 'NG') {
                $worksheet->setCellValue($col . 15, 'X');
            }

            // Set value based on $item->tabung
            if ($item->button_down === 'OK') {
                $worksheet->setCellValue($col . 18, '√');
            } else if ($item->button_down === 'NG') {
                $worksheet->setCellValue($col . 18, 'X');
            }

            // Set value based on $item->regulator
            if ($item->button_push === 'OK') {
                $worksheet->setCellValue($col . 21, '√');
            } else if ($item->button_push === 'NG') {
                $worksheet->setCellValue($col . 21, 'X');
            }

            if ($item->wire_rope === 'OK') {
                $worksheet->setCellValue($col . 24, '√');
            } else if ($item->wire_rope === 'NG') {
                $worksheet->setCellValue($col . 24, 'X');
            }

            if ($item->block_hook === 'OK') {
                $worksheet->setCellValue($col . 27, '√');
            } else if ($item->block_hook === 'NG') {
                $worksheet->setCellValue($col . 27, 'X');
            }

            if ($item->hom === 'OK') {
                $worksheet->setCellValue($col . 30, '√');
            } else if ($item->hom === 'NG') {
                $worksheet->setCellValue($col . 30, 'X');
            }

            if ($item->emergency_stop === 'OK') {
                $worksheet->setCellValue($col . 33, '√');
            } else if ($item->emergency_stop === 'NG') {
                $worksheet->setCellValue($col . 33, 'X');
            }
            // Increment row for the next data
            $col++;
        }


        // Create a new Excel writer and save the modified spreadsheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputPath = public_path('templates/checksheet-head-crane.xlsx');
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
