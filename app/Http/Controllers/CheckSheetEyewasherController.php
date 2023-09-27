<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetEyewasher;
use App\Models\CheckSheetEyewasherShower;
use App\Models\Eyewasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckSheetEyewasherController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_filter = $request->input('tanggal_filter');


        $checksheeteyewasher = CheckSheetEyewasher::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        $checksheetshower = CheckSheetEyewasherShower::when($tanggal_filter, function ($query) use ($tanggal_filter) {
            return $query->where('tanggal_pengecekan', $tanggal_filter);
        })->get();

        return view('dashboard.eyewasher.checksheet.index', compact('checksheeteyewasher', 'checksheetshower'));
    }

    public function showForm()
    {
        $latestCheckSheetEyewashers = CheckSheetEyewasher::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetShower = CheckSheetEyewasherShower::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetEyewashers->merge($latestCheckSheetShower);

        return view('dashboard.eyewasher.checksheet.check', compact('combinedLatestCheckSheets'));
    }

    public function processForm(Request $request)
    {
        $eyewasherNumber = $request->input('eyewasher_number');

        $eyewasherNumber = strtoupper($eyewasherNumber);

        $eyewasher = Eyewasher::where('no_eyewasher', $eyewasherNumber)->first();

        if (!$eyewasher) {
            return back()->with('error', 'Eyewasher Number tidak ditemukan.');
        }

        $type = $eyewasher->type;

        if ($type === 'Eyewasher') {
            return redirect()->route('checksheeteyewasher', compact('eyewasherNumber'));
        } elseif ($type === 'Shower') {
            return redirect()->route('checksheetshower', compact('eyewasherNumber'));
        } else {
            return back()->with('error', 'Tipe tidak dikenali');
        }
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $eyewasherData = Eyewasher::leftJoin('tm_locations', 'tm_eyewashers.location_id', '=', 'tm_locations.id')
            ->leftJoin('tt_check_sheet_eye_washer_showers', 'tm_eyewashers.no_eyewasher', '=', 'tt_check_sheet_eye_washer_showers.eyewasher_number')
            ->leftJoin('tt_check_sheet_eye_washers', 'tm_eyewashers.no_eyewasher', '=', 'tt_check_sheet_eye_washers.eyewasher_number')
            ->select(
                'tm_eyewashers.no_eyewasher as eyewasher_number',
                'tm_eyewashers.type',
                'tm_locations.location_name',
                DB::raw('COALESCE(tt_check_sheet_eye_washer_showers.tanggal_pengecekan, tt_check_sheet_eye_washers.tanggal_pengecekan) AS tanggal_pengecekan'),
                DB::raw('COALESCE(tt_check_sheet_eye_washer_showers.pipa_saluran_air, tt_check_sheet_eye_washers.pipa_saluran_air) AS pipa_saluran_air'),
                DB::raw('COALESCE(tt_check_sheet_eye_washer_showers.wastafel_eye_wash, tt_check_sheet_eye_washers.wastafel) AS wastafel_eye_wash'),
                DB::raw('COALESCE(tt_check_sheet_eye_washer_showers.kran_eye_wash, tt_check_sheet_eye_washers.kran_air) AS kran_eye_wash'),
                DB::raw('COALESCE(tt_check_sheet_eye_washer_showers.tuas_eye_wash, tt_check_sheet_eye_washers.tuas) AS tuas_eye_wash'),
                'tt_check_sheet_eye_washer_showers.instalation_base',
                'tt_check_sheet_eye_washer_showers.tuas_shower',
                'tt_check_sheet_eye_washer_showers.sign',
                'tt_check_sheet_eye_washer_showers.shower_head',
                'tt_check_sheet_eye_washers.pijakan'
            )
            ->get();

        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredEyewasherData = $eyewasherData->filter(function ($eyewasher) use ($selectedYear) {
            return $eyewasher->tanggal_pengecekan !== null &&
                date('Y', strtotime($eyewasher->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedEyewasherData = $filteredEyewasherData->groupBy('eyewasher_number')->map(function ($eyewasherGroup) {
            $eyewasherNumber = $eyewasherGroup[0]['eyewasher_number'];
            $eyewasherType = $eyewasherGroup[0]['type'];
            $location_name = $eyewasherGroup[0]['location_name'];
            $eyewasherPengecekan = $eyewasherGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($eyewasherGroup as $eyewasher) {
                $month = date('n', strtotime($eyewasher['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for Outdoor type
                if ($eyewasher['type'] === 'Shower') {
                    if ($eyewasher['instalation_base'] === 'NG') $issueCodes[] = 'f';
                    if ($eyewasher['pipa_saluran_air'] === 'NG') $issueCodes[] = 'a';
                    if ($eyewasher['wastafel_eye_wash'] === 'NG') $issueCodes[] = 'b';
                    if ($eyewasher['kran_eye_wash'] === 'NG') $issueCodes[] = 'c';
                    if ($eyewasher['tuas_eye_wash'] === 'NG') $issueCodes[] = 'd';
                    if ($eyewasher['tuas_shower'] === 'NG') $issueCodes[] = 'g';
                    if ($eyewasher['sign'] === 'NG') $issueCodes[] = 'h';
                    if ($eyewasher['shower_head'] === 'NG') $issueCodes[] = 'i';
                }

                // Map issue codes for Indoor type
                if ($eyewasher['type'] === 'Eyewashers') {
                    if ($eyewasher['pijakan'] === 'NG') $issueCodes[] = 'e';
                    if ($eyewasher['pipa_saluran_air'] === 'NG') $issueCodes[] = 'a';
                    if ($eyewasher['wastafel_eye_wash'] === 'NG') $issueCodes[] = 'b';
                    if ($eyewasher['kran_eye_wash'] === 'NG') $issueCodes[] = 'c';
                    if ($eyewasher['tuas_eye_wash'] === 'NG') $issueCodes[] = 'd';
                }

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }

                $months[$month] = $issueCodes;
            }

            return [
                'eyewasher_number' => $eyewasherNumber,
                'type' => $eyewasherType,
                'location_name' => $location_name,
                'tanggal_pengecekan' => $eyewasherPengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedEyewasherData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('eyewasher_data.json', $jsonString);

        return view('dashboard.combined_eyewasher_report', [
            'eyewasherData' => $mappedEyewasherData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
