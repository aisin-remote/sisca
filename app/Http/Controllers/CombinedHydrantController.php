<?php

namespace App\Http\Controllers;

use App\Models\Hydrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CombinedHydrantController extends Controller
{
    protected function getMonthFromDate($date)
    {
        return date('n', strtotime($date));
    }

    public function index(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $hydrantData = Hydrant::leftJoin('tm_locations', 'tm_hydrants.location_id', '=', 'tm_locations.id')
            ->leftJoin('tt_check_sheet_hydrant_outdoor', 'tm_hydrants.no_hydrant', '=', 'tt_check_sheet_hydrant_outdoor.hydrant_number')
            ->leftJoin('tt_check_sheet_hydrant_indoor', 'tm_hydrants.no_hydrant', '=', 'tt_check_sheet_hydrant_indoor.hydrant_number')
            ->select(
                'tm_hydrants.no_hydrant as hydrant_number',
                'tm_hydrants.type',
                'tm_hydrants.zona',
                'tm_locations.location_name',
                DB::raw('COALESCE(tt_check_sheet_hydrant_outdoor.tanggal_pengecekan, tt_check_sheet_hydrant_indoor.tanggal_pengecekan) AS tanggal_pengecekan'),
                DB::raw('COALESCE(tt_check_sheet_hydrant_outdoor.pintu, tt_check_sheet_hydrant_indoor.pintu) AS pintu'),
                DB::raw('COALESCE(tt_check_sheet_hydrant_outdoor.nozzle, tt_check_sheet_hydrant_indoor.nozzle) AS nozzle'),
                DB::raw('COALESCE(tt_check_sheet_hydrant_outdoor.selang, tt_check_sheet_hydrant_indoor.selang) AS selang'),
                DB::raw('COALESCE(tt_check_sheet_hydrant_outdoor.kupla, tt_check_sheet_hydrant_indoor.kupla) AS kupla'),
                'tt_check_sheet_hydrant_outdoor.tuas',
                'tt_check_sheet_hydrant_outdoor.pilar',
                'tt_check_sheet_hydrant_outdoor.penutup',
                'tt_check_sheet_hydrant_outdoor.rantai',
                'tt_check_sheet_hydrant_indoor.lampu',
                'tt_check_sheet_hydrant_indoor.emergency',
                'tt_check_sheet_hydrant_indoor.valve',
                'tt_check_sheet_hydrant_indoor.coupling',
                'tt_check_sheet_hydrant_indoor.pressure'
            )
            ->get();

        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredHydrantData = $hydrantData->filter(function ($hydrant) use ($selectedYear) {
            return $hydrant->tanggal_pengecekan !== null &&
                date('Y', strtotime($hydrant->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedHydrantData = $filteredHydrantData->groupBy('hydrant_number')->map(function ($hydrantGroup) {
            $hydrantNumber = $hydrantGroup[0]['hydrant_number'];
            $hydrantType = $hydrantGroup[0]['type'];
            $location_name = $hydrantGroup[0]['location_name'];
            $hydrantZona = $hydrantGroup[0]['zona'];
            $months = [];

            foreach ($hydrantGroup as $hydrant) {
                $month = date('n', strtotime($hydrant['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for Outdoor type
                if ($hydrant['type'] === 'Outdoor') {
                    if ($hydrant['pintu'] === 'NG') $issueCodes[] = 'a';
                    if ($hydrant['nozzle'] === 'NG') $issueCodes[] = 'b';
                    if ($hydrant['selang'] === 'NG') $issueCodes[] = 'c';
                    if ($hydrant['kupla'] === 'NG') $issueCodes[] = 'd';
                    if ($hydrant['pilar'] === 'NG') $issueCodes[] = 'f';
                    if ($hydrant['penutup'] === 'NG') $issueCodes[] = 'g';
                    if ($hydrant['rantai'] === 'NG') $issueCodes[] = 'h';
                    if ($hydrant['tuas'] === 'NG') $issueCodes[] = 'i';
                }

                // Map issue codes for Indoor type
                if ($hydrant['type'] === 'Indoor') {
                    if ($hydrant['pintu'] === 'NG') $issueCodes[] = 'a';
                    if ($hydrant['nozzle'] === 'NG') $issueCodes[] = 'b';
                    if ($hydrant['selang'] === 'NG') $issueCodes[] = 'c';
                    if ($hydrant['kupla'] === 'NG') $issueCodes[] = 'd';
                    if ($hydrant['emergency'] === 'NG') $issueCodes[] = 'e';
                    if ($hydrant['valve'] === 'NG') $issueCodes[] = 'f';
                    if ($hydrant['coupling'] === 'NG') $issueCodes[] = 'g';
                    if ($hydrant['pressure'] === 'NG') $issueCodes[] = 'h';
                    if ($hydrant['lampu'] === 'NG') $issueCodes[] = 'i';
                }

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }

                $months[$month] = $issueCodes;
            }

            return [
                'hydrant_number' => $hydrantNumber,
                'type' => $hydrantType,
                'location_name' => $location_name,
                'zona' => $hydrantZona,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedHydrantData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('hydrant_data.json', $jsonString);

        return view('dashboard.combined_hydrant_report', [
            'hydrantData' => $mappedHydrantData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
