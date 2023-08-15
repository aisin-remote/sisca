<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AparReportController extends Controller
{
    protected function getMonthFromDate($date)
    {
        return date('n', strtotime($date));
    }

    public function index()
    {
        // Logic to generate CO2 issue codes and store in a temporary JSON file
        $co2DataFromDatabase = DB::table('check_sheet_co2s')->get(); // Replace 'nama_tabel' with your table name

        $co2IssueCodes = [];

        foreach ($co2DataFromDatabase as $row) {
            $issueCode = [];
            if ($row->pressure !== 'OK') $issueCode[] = 'a';
            if ($row->lock_pin !== 'OK') $issueCode[] = 'b';
            if ($row->regulator !== 'OK') $issueCode[] = 'c';
            if ($row->tabung !== 'OK') $issueCode[] = 'd';
            if ($row->corong !== 'OK') $issueCode[] = 'e';
            if ($row->hose !== 'OK') $issueCode[] = 'f';

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
        $powderDataFromDatabase = DB::table('check_sheet_powders')->get(); // Replace 'nama_tabel' with your table name

        $powderIssueCodes = [];

        foreach ($powderDataFromDatabase as $row) {
            $issueCode = [];
            if ($row->pressure !== 'OK') $issueCode[] = 'a';
            if ($row->lock_pin !== 'OK') $issueCode[] = 'b';
            if ($row->regulator !== 'OK') $issueCode[] = 'c';
            if ($row->tabung !== 'OK') $issueCode[] = 'd';
            if ($row->hose !== 'OK') $issueCode[] = 'f';

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
        ]);
    }
}
