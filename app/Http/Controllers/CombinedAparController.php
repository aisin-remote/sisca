<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Apar; // Assuming the Apar model is defined in 'app/Models/Apar.php'
use App\Models\Location; // Assuming the Location model is defined in 'app/Models/Location.php'
use App\Models\CheckSheetPowder; // Assuming the CheckSheetPowder model is defined
use App\Models\CheckSheetCo2; // Assuming the CheckSheetCo2 model is defined

class CombinedAparController extends Controller
{
    protected function getMonthFromDate($date)
    {
        return date('n', strtotime($date));
    }

    public function index()
    {
        $aparData = Apar::leftJoin('locations', 'apars.location_id', '=', 'locations.id')
            ->leftJoin('check_sheet_powders', 'apars.tag_number', '=', 'check_sheet_powders.apar_number')
            ->leftJoin('check_sheet_co2s', 'apars.tag_number', '=', 'check_sheet_co2s.apar_number')
            ->select(
                'apars.tag_number as apar_number',
                'apars.type',
                'locations.location_name',
                DB::raw('COALESCE(check_sheet_powders.tanggal_pengecekan, check_sheet_co2s.tanggal_pengecekan) AS tanggal_pengecekan'),
                DB::raw('COALESCE(check_sheet_powders.pressure, check_sheet_co2s.pressure) AS pressure'),
                DB::raw('COALESCE(check_sheet_powders.hose, check_sheet_co2s.hose) AS hose'),
                DB::raw('COALESCE(check_sheet_powders.tabung, check_sheet_co2s.tabung) AS tabung'),
                DB::raw('COALESCE(check_sheet_powders.regulator, check_sheet_co2s.regulator) AS regulator'),
                DB::raw('COALESCE(check_sheet_powders.lock_pin, check_sheet_co2s.lock_pin) AS lock_pin'),
                'check_sheet_powders.powder',
                'check_sheet_co2s.corong',
                'check_sheet_co2s.berat_tabung'
            )
            ->get();

        // Filter out entries with tanggal_pengecekan = null
        $filteredAparData = $aparData->filter(function ($apar) {
            return $apar->tanggal_pengecekan !== null;
        });

        $mappedAparData = $filteredAparData->map(function ($apar) {
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

            return [
                'apar_number' => $apar['apar_number'],
                'type' => $apar['type'],
                'location_name' => $apar['location_name'],
                'tanggal_pengecekan' => $apar['tanggal_pengecekan'],
                'issue_codes' => $issueCodes,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedAparData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('apar_data.json', $jsonString);

        return view('dashboard.combined_apar_report', [
            'aparData' => $filteredAparData,
        ]);
    }
}
