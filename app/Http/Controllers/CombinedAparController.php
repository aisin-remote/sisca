<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Apar;
use App\Models\Location;
use App\Models\CheckSheetPowder;
use App\Models\CheckSheetCo2;

class CombinedAparController extends Controller
{
    protected function getMonthFromDate($date)
    {
        return date('n', strtotime($date));
    }

    public function index(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $aparData = Apar::leftJoin('locations', 'apars.location_id', '=', 'locations.id')
            ->leftJoin('tt_check_sheet_powders', 'apars.tag_number', '=', 'tt_check_sheet_powders.apar_number')
            ->leftJoin('tt_check_sheet_co2s', 'apars.tag_number', '=', 'tt_check_sheet_co2s.apar_number')
            ->select(
                'apars.tag_number as apar_number',
                'apars.type',
                'locations.location_name',
                DB::raw('COALESCE(tt_check_sheet_powders.tanggal_pengecekan, tt_check_sheet_co2s.tanggal_pengecekan) AS tanggal_pengecekan'),
                DB::raw('COALESCE(tt_check_sheet_powders.pressure, tt_check_sheet_co2s.pressure) AS pressure'),
                DB::raw('COALESCE(tt_check_sheet_powders.hose, tt_check_sheet_co2s.hose) AS hose'),
                DB::raw('COALESCE(tt_check_sheet_powders.tabung, tt_check_sheet_co2s.tabung) AS tabung'),
                DB::raw('COALESCE(tt_check_sheet_powders.regulator, tt_check_sheet_co2s.regulator) AS regulator'),
                DB::raw('COALESCE(tt_check_sheet_powders.lock_pin, tt_check_sheet_co2s.lock_pin) AS lock_pin'),
                'tt_check_sheet_powders.powder',
                'tt_check_sheet_co2s.corong',
                'tt_check_sheet_co2s.berat_tabung'
            )
            ->get();

        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredAparData = $aparData->filter(function ($apar) use ($selectedYear) {
            return $apar->tanggal_pengecekan !== null &&
                date('Y', strtotime($apar->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedAparData = $filteredAparData->groupBy('apar_number')->map(function ($aparGroup) {
            $aparNumber = $aparGroup[0]['apar_number'];
            $aparType = $aparGroup[0]['type'];
            $location_name = $aparGroup[0]['location_name'];
            $months = [];

            foreach ($aparGroup as $apar) {
                $month = date('n', strtotime($apar['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for powder type
                if ($apar['type'] === 'powder') {
                    if ($apar['pressure'] === 'NG') $issueCodes[] = 'a';
                    if ($apar['lock_pin'] === 'NG') $issueCodes[] = 'b';
                    if ($apar['regulator'] === 'NG') $issueCodes[] = 'c';
                    if ($apar['tabung'] === 'NG') $issueCodes[] = 'd';
                    if ($apar['hose'] === 'NG') $issueCodes[] = 'f';
                    if ($apar['powder'] === 'NG') $issueCodes[] = 'g';
                }

                // Map issue codes for co2 type
                if ($apar['type'] === 'co2') {
                    if ($apar['pressure'] === 'NG') $issueCodes[] = 'a';
                    if ($apar['lock_pin'] === 'NG') $issueCodes[] = 'b';
                    if ($apar['regulator'] === 'NG') $issueCodes[] = 'c';
                    if ($apar['tabung'] === 'NG') $issueCodes[] = 'd';
                    if ($apar['corong'] === 'NG') $issueCodes[] = 'e';
                    if ($apar['hose'] === 'NG') $issueCodes[] = 'f';
                    if ($apar['berat_tabung'] === 'NG') $issueCodes[] = 'h';
                }

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }

                $months[$month] = $issueCodes;
            }

            return [
                'apar_number' => $aparNumber,
                'type' => $aparType,
                'location_name' => $location_name,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedAparData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('apar_data.json', $jsonString);

        return view('dashboard.combined_apar_report', [
            'aparData' => $mappedAparData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
