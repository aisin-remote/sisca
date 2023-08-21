<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AparReportController extends Controller
{
    protected function getMonthFromDate($date)
    {
        return date('n', strtotime($date));
    }

    public function index(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $co2IssueCodesWithLocation = DB::table('tt_check_sheet_co2s')
            ->join('apars', 'tt_check_sheet_co2s.apar_number', '=', 'apars.tag_number')
            ->join('locations', 'apars.location_id', '=', 'locations.id')
            ->whereYear('tt_check_sheet_co2s.tanggal_pengecekan', $selectedYear)
            ->select('tt_check_sheet_co2s.apar_number', 'locations.location_name')
            ->get();

        $powderIssueCodesWithLocation = DB::table('tt_check_sheet_powders')
            ->join('apars', 'tt_check_sheet_powders.apar_number', '=', 'apars.tag_number')
            ->join('locations', 'apars.location_id', '=', 'locations.id')
            ->whereYear('tt_check_sheet_powders.tanggal_pengecekan', $selectedYear)
            ->select('tt_check_sheet_powders.apar_number', 'locations.location_name')
            ->get();

        // Logic to generate CO2 issue codes and store in a temporary JSON file
        $co2DataFromDatabase = DB::table('tt_check_sheet_co2s')
            ->whereYear('tanggal_pengecekan', $selectedYear) // Filter data by selected year
            ->get();

        $co2IssueCodes = [];

        foreach ($co2DataFromDatabase as $row) {
            $issueCode = [];
            if ($row->pressure !== 'OK') $issueCode[] = 'a';
            if ($row->lock_pin !== 'OK') $issueCode[] = 'b';
            if ($row->regulator !== 'OK') $issueCode[] = 'c';
            if ($row->tabung !== 'OK') $issueCode[] = 'd';
            if ($row->corong !== 'OK') $issueCode[] = 'e';
            if ($row->hose !== 'OK') $issueCode[] = 'f';
            if ($row->berat_tabung !== 'OK') $issueCode[] = 'h';

            $aparNumber = $row->apar_number;
            $month = $this->getMonthFromDate($row->tanggal_pengecekan);

            if (!isset($co2IssueCodes[$aparNumber])) {
                $co2IssueCodes[$aparNumber] = [
                    'apar_number' => $aparNumber,
                    'months' => [],
                ];
            }

            $co2IssueCodes[$aparNumber]['months'][$month] = !empty($issueCode) ? $issueCode : ['OK'];
        }

        $co2IssueCodesJson = json_encode($co2IssueCodes, JSON_PRETTY_PRINT);

        Storage::put('temporary_co2_issue_codes.json', $co2IssueCodesJson); // Save CO2 JSON in a temporary file

        // Logic to generate Powder issue codes and store in a temporary JSON file
        $powderDataFromDatabase = DB::table('tt_check_sheet_powders')
            ->whereYear('tanggal_pengecekan', $selectedYear) // Filter data by selected year
            ->get();

        $powderIssueCodes = [];

        foreach ($powderDataFromDatabase as $row) {
            $issueCode = [];
            if ($row->pressure !== 'OK') $issueCode[] = 'a';
            if ($row->lock_pin !== 'OK') $issueCode[] = 'b';
            if ($row->regulator !== 'OK') $issueCode[] = 'c';
            if ($row->tabung !== 'OK') $issueCode[] = 'd';
            if ($row->hose !== 'OK') $issueCode[] = 'f';
            if ($row->powder !== 'OK') $issueCode[] = 'g';

            $aparNumber = $row->apar_number;
            $month = $this->getMonthFromDate($row->tanggal_pengecekan);

            if (!isset($powderIssueCodes[$aparNumber])) {
                $powderIssueCodes[$aparNumber] = [
                    'apar_number' => $aparNumber,
                    'months' => [],
                ];
            }

            $powderIssueCodes[$aparNumber]['months'][$month] = !empty($issueCode) ? $issueCode : ['OK'];
        }

        $powderIssueCodesJson = json_encode($powderIssueCodes, JSON_PRETTY_PRINT);

        Storage::put('temporary_powder_issue_codes.json', $powderIssueCodesJson); // Save Powder JSON in a temporary file

        return view('dashboard.apar_report', [
            'co2IssueCodes' => $co2IssueCodes,
            'powderIssueCodes' => $powderIssueCodes,
            'selectedYear' => $selectedYear,
            'co2IssueCodesWithLocation' => $co2IssueCodesWithLocation,
            'powderIssueCodesWithLocation' => $powderIssueCodesWithLocation,
        ]);
    }
}
