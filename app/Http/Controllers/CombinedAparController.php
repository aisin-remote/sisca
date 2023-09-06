<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Apar;
use App\Models\Location;
use App\Models\CheckSheetPowder;
use App\Models\CheckSheetCo2;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CombinedAparController extends Controller
{
    protected function getMonthFromDate($date)
    {
        return date('n', strtotime($date));
    }

    public function index(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $aparData = Apar::leftJoin('tm_locations', 'tm_apars.location_id', '=', 'tm_locations.id')
            ->leftJoin('tt_check_sheet_powders', 'tm_apars.tag_number', '=', 'tt_check_sheet_powders.apar_number')
            ->leftJoin('tt_check_sheet_co2s', 'tm_apars.tag_number', '=', 'tt_check_sheet_co2s.apar_number')
            ->select(
                'tm_apars.tag_number as apar_number',
                'tm_apars.type',
                'tm_locations.location_name',
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

public function exportExcelWithTemplate(Request $request)
{
    // Load the template Excel file
    $templatePath = public_path('templates/template-checksheet-apar.xlsx');
    $spreadsheet = IOFactory::load($templatePath);
    $worksheet = $spreadsheet->getActiveSheet();

    // Retrieve the selected year from the form
    $selectedYear = $request->input('tahun');

    // Retrieve data from the checksheetsco2 table for the selected year and tag_number
    $data = Apar::leftJoin('tm_locations', 'tm_apars.location_id', '=', 'tm_locations.id')
        ->leftJoin('tt_check_sheet_powders', 'tm_apars.tag_number', '=', 'tt_check_sheet_powders.apar_number')
        ->leftJoin('tt_check_sheet_co2s', 'tm_apars.tag_number', '=', 'tt_check_sheet_co2s.apar_number')
        ->select(
            'tm_apars.tag_number as apar_number',
            'tm_apars.type',
            'tm_apars.expired',
            'tm_apars.post',
            'tm_apars.post',
            'tm_locations.location_name',
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
    $filteredAparData = $data->filter(function ($apar) use ($selectedYear) {
        return $apar->tanggal_pengecekan !== null &&
            date('Y', strtotime($apar->tanggal_pengecekan)) == $selectedYear;
    });

    $mappedAparData = $filteredAparData->groupBy('apar_number')->map(function ($aparGroup) {
        $aparNumber = $aparGroup[0]['apar_number'];
        $aparType = $aparGroup[0]['type'];
        $aparExpired = $aparGroup[0]['expired'];
        $aparPost = $aparGroup[0]['post'];
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
                $issueCodes[] = '√';
            }

            $months[$month] = $issueCodes;
        }

        return [
            'apar_number' => $aparNumber,
            'type' => $aparType,
            'expired' => $aparExpired,
            'post' => $aparPost,
            'location_name' => $location_name,
            'months' => $months,
        ];
    });

    // Start row to populate data in Excel
    $row = 3; // Assuming your data starts from row 2 in Excel

    $iteration = 1;

    foreach ($mappedAparData as $item) {
        $worksheet->setCellValue('A' . $row, $iteration);
        $worksheet->setCellValue('B' . $row, $item['apar_number']);
        $worksheet->setCellValue('C' . $row, $item['location_name']);
        $worksheet->setCellValue('D' . $row, $item['expired']);
        $worksheet->setCellValue('E' . $row, $item['post']);
        $worksheet->setCellValue('F' . $row, $item['type']);

        // Loop through months and issue codes
        for ($month = 1; $month <= 12; $month++) {
            $cellValue = '';

            if (isset($item['months'][$month])) {
                if (in_array('OK', $item['months'][$month])) {
                    $cellValue = 'OK';
                } else {
                    $cellValue = implode('+', $item['months'][$month]);
                }
            }

            $worksheet->setCellValueByColumnAndRow($month + 6, $row, $cellValue);
        }

        // Increment iterasi setiap kali loop berjalan
        $iteration++;

        // Increment row for the next data
        $row++;
    }

    // Create a new Excel writer and save the modified spreadsheet
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $outputPath = public_path('templates/checksheet-apar.xlsx');
    $writer->save($outputPath);

    return response()->download($outputPath)->deleteFileAfterSend(true);
}

}
