<?php

namespace App\Http\Controllers;

use App\Models\Hydrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            $hydrantPengecekan = $hydrantGroup[0]['tanggal_pengecekan'];
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
                    if ($hydrant['pilar'] === 'NG') $issueCodes[] = 'e';
                    if ($hydrant['penutup'] === 'NG') $issueCodes[] = 'f';
                    if ($hydrant['rantai'] === 'NG') $issueCodes[] = 'g';
                    if ($hydrant['tuas'] === 'NG') $issueCodes[] = 'h';
                }

                // Map issue codes for Indoor type
                if ($hydrant['type'] === 'Indoor') {
                    if ($hydrant['pintu'] === 'NG') $issueCodes[] = 'a';
                    if ($hydrant['nozzle'] === 'NG') $issueCodes[] = 'b';
                    if ($hydrant['selang'] === 'NG') $issueCodes[] = 'c';
                    if ($hydrant['kupla'] === 'NG') $issueCodes[] = 'd';
                    if ($hydrant['emergency'] === 'NG') $issueCodes[] = 'i';
                    if ($hydrant['valve'] === 'NG') $issueCodes[] = 'j';
                    if ($hydrant['coupling'] === 'NG') $issueCodes[] = 'k';
                    if ($hydrant['pressure'] === 'NG') $issueCodes[] = 'l';
                    if ($hydrant['lampu'] === 'NG') $issueCodes[] = 'm';
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
                'tanggal_pengecekan' => $hydrantPengecekan,
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

    public function exportExcelWithTemplate(Request $request)
{
    // Load the template Excel file
    $templatePath = public_path('templates/template-checksheet-hydrant.xlsx');
    $spreadsheet = IOFactory::load($templatePath);
    $worksheet = $spreadsheet->getActiveSheet();

    // Retrieve the selected year from the form
    $selectedYear = $request->input('tahun');

    // Retrieve data from the checksheetsco2 table for the selected year and tag_number
    $data = Hydrant::leftJoin('tm_locations', 'tm_hydrants.location_id', '=', 'tm_locations.id')
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
            'tt_check_sheet_hydrant_indoor.pressure',
        )
        ->get();

    // Filter out entries with tanggal_pengecekan = null and matching selected year
    $filteredHydrantData = $data->filter(function ($hydrant) use ($selectedYear) {
        return $hydrant->tanggal_pengecekan !== null &&
            date('Y', strtotime($hydrant->tanggal_pengecekan)) == $selectedYear;
    });

    $mappedHydrantData = $filteredHydrantData->groupBy('hydrant_number')->map(function ($hydrantGroup) {
        $hydrantNumber = $hydrantGroup[0]['hydrant_number'];
        $hydrantType = $hydrantGroup[0]['type'];
        $hydrantZona = $hydrantGroup[0]['zona'];
        $location_name = $hydrantGroup[0]['location_name'];
        $months = [];

        foreach ($hydrantGroup as $hydrant) {
            $month = date('n', strtotime($hydrant['tanggal_pengecekan']));
            $issueCodes = [];

            // Map issue codes for powder type
            if ($hydrant['type'] === 'Outdoor') {
                if ($hydrant['pintu'] === 'NG') $issueCodes[] = 'a';
                if ($hydrant['nozzle'] === 'NG') $issueCodes[] = 'b';
                if ($hydrant['selang'] === 'NG') $issueCodes[] = 'c';
                if ($hydrant['kupla'] === 'NG') $issueCodes[] = 'd';
                if ($hydrant['pilar'] === 'NG') $issueCodes[] = 'e';
                if ($hydrant['penutup'] === 'NG') $issueCodes[] = 'f';
                if ($hydrant['rantai'] === 'NG') $issueCodes[] = 'g';
                if ($hydrant['tuas'] === 'NG') $issueCodes[] = 'h';
            }

            // Map issue codes for co2 type
            if ($hydrant['type'] === 'Indoor') {
                if ($hydrant['pintu'] === 'NG') $issueCodes[] = 'a';
                if ($hydrant['nozzle'] === 'NG') $issueCodes[] = 'b';
                if ($hydrant['selang'] === 'NG') $issueCodes[] = 'c';
                if ($hydrant['kupla'] === 'NG') $issueCodes[] = 'd';
                if ($hydrant['emergency'] === 'NG') $issueCodes[] = 'i';
                if ($hydrant['valve'] === 'NG') $issueCodes[] = 'j';
                if ($hydrant['coupling'] === 'NG') $issueCodes[] = 'k';
                if ($hydrant['pressure'] === 'NG') $issueCodes[] = 'l';
                if ($hydrant['lampu'] === 'NG') $issueCodes[] = 'm';
            }

            if (empty($issueCodes)) {
                $issueCodes[] = '√';
            }

            $months[$month] = $issueCodes;
        }

        return [
            'hydrant_number' => $hydrantNumber,
            'type' => $hydrantType,
            'zona' => $hydrantZona,
            'location_name' => $location_name,
            'months' => $months,
        ];
    });

    // Start row to populate data in Excel
    $row = 7; // Assuming your data starts from row 2 in Excel

    $iteration = 1;

    foreach ($mappedHydrantData as $item) {
        $worksheet->setCellValue('A' . $row, $iteration);
        $worksheet->setCellValue('B' . $row, $item['hydrant_number']);
        $worksheet->setCellValue('E' . $row, $item['location_name']);
        $worksheet->setCellValue('D' . $row, $item['zona']);
        $worksheet->setCellValue('C' . $row, $item['type']);

        // Loop through months and issue codes
        for ($month = 1; $month <= 12; $month++) {
            $cellValue = '';

            if (isset($item['months'][$month])) {
                if (in_array('√', $item['months'][$month])) {
                    $cellValue = '√';
                } else {
                    $cellValue = 'X';
                }
            }

            // Menghitung huruf kolom berdasarkan indeks $month (dari 1 hingga 12)
            $columnIndex = Coordinate::stringFromColumnIndex($month + 5);

            // Set nilai sel dengan metode setCellValue() dan koordinat kolom dan baris
            $worksheet->setCellValue($columnIndex . $row, $cellValue);
        }


        // Increment iterasi setiap kali loop berjalan
        $iteration++;

        // Increment row for the next data
        $row++;
    }

    // Create a new Excel writer and save the modified spreadsheet
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $outputPath = public_path('templates/checksheet-hydrant.xlsx');
    $writer->save($outputPath);

    return response()->download($outputPath)->deleteFileAfterSend(true);
}
}
