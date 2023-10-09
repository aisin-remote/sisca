<?php

namespace App\Http\Controllers;

use App\Models\CheckSheetSlingBelt;
use App\Models\CheckSheetSlingWire;
use App\Models\Sling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckSheetSlingController extends Controller
{
    public function showForm()
    {
        $latestCheckSheetWires = CheckSheetSlingWire::orderBy('updated_at', 'desc')->take(10)->get();
        $latestCheckSheetBelt = CheckSheetSlingBelt::orderBy('updated_at', 'desc')->take(10)->get();

        $combinedLatestCheckSheets = $latestCheckSheetWires->merge($latestCheckSheetBelt);

        return view('dashboard.sling.checksheet.check', compact('combinedLatestCheckSheets'));
    }

    public function processForm(Request $request)
    {
        $slingNumber = $request->input('sling_number');

        $slingNumber = strtoupper($slingNumber);

        $sling = Sling::where('no_sling', $slingNumber)->first();

        if (!$sling) {
            return back()->with('error', 'Sling Number tidak ditemukan.');
        }

        $type = $sling->type;

        if ($type === 'Sling Wire') {
            return redirect()->route('checksheetwire', compact('slingNumber'));
        } elseif ($type === 'Sling Belt') {
            return redirect()->route('checksheetbelt', compact('slingNumber'));
        } else {
            return back()->with('error', 'Tipe tidak dikenali');
        }
    }

    public function report(Request $request)
    {
        $selectedYear = $request->input('selected_year', date('Y'));

        $slingData = Sling::leftJoin('tm_locations', 'tm_slings.location_id', '=', 'tm_locations.id')
            ->leftJoin('tt_check_sheet_sling_belts', 'tm_slings.no_sling', '=', 'tt_check_sheet_sling_belts.sling_number')
            ->leftJoin('tt_check_sheet_sling_wires', 'tm_slings.no_sling', '=', 'tt_check_sheet_sling_wires.sling_number')
            ->select(
                'tm_slings.no_sling as sling_number',
                'tm_slings.type',
                'tm_slings.plant',
                'tm_locations.location_name',
                DB::raw('COALESCE(tt_check_sheet_sling_belts.tanggal_pengecekan, tt_check_sheet_sling_wires.tanggal_pengecekan) AS tanggal_pengecekan'),
                DB::raw('COALESCE(tt_check_sheet_sling_belts.hook_wire, tt_check_sheet_sling_wires.hook_wire) AS hook_wire'),
                DB::raw('COALESCE(tt_check_sheet_sling_belts.pengunci_hook, tt_check_sheet_sling_wires.pengunci_hook) AS pengunci_hook'),
                'tt_check_sheet_sling_belts.kelengkapan_tag_sling_belt',
                'tt_check_sheet_sling_belts.bagian_pinggir_belt_robek',
                'tt_check_sheet_sling_belts.pengecekan_lapisan_belt_1',
                'tt_check_sheet_sling_belts.pengecekan_jahitan_belt',
                'tt_check_sheet_sling_belts.pengecekan_permukaan_belt',
                'tt_check_sheet_sling_belts.pengecekan_lapisan_belt_2',
                'tt_check_sheet_sling_belts.pengecekan_aus',
                'tt_check_sheet_sling_wires.serabut_wire',
                'tt_check_sheet_sling_wires.bagian_wire_1',
                'tt_check_sheet_sling_wires.bagian_wire_2',
                'tt_check_sheet_sling_wires.kumpulan_wire_1',
                'tt_check_sheet_sling_wires.diameter_wire',
                'tt_check_sheet_sling_wires.kumpulan_wire_2',
                'tt_check_sheet_sling_wires.mata_sling'
            )
            ->get();

        // Filter out entries with tanggal_pengecekan = null and matching selected year
        $filteredSlingData = $slingData->filter(function ($sling) use ($selectedYear) {
            return $sling->tanggal_pengecekan !== null &&
                date('Y', strtotime($sling->tanggal_pengecekan)) == $selectedYear;
        });

        $mappedSlingData = $filteredSlingData->groupBy('sling_number')->map(function ($slingGroup) {
            $slingNumber = $slingGroup[0]['sling_number'];
            $slingType = $slingGroup[0]['type'];
            $location_name = $slingGroup[0]['location_name'];
            $slingPlant = $slingGroup[0]['plant'];
            $slingPengecekan = $slingGroup[0]['tanggal_pengecekan'];
            $months = [];

            foreach ($slingGroup as $sling) {
                $month = date('n', strtotime($sling['tanggal_pengecekan']));
                $issueCodes = [];

                // Map issue codes for Outdoor type
                if ($sling['type'] === 'Sling Belt') {
                    if ($sling['hook_wire'] === 'NG') $issueCodes[] = 'a';
                    if ($sling['pengunci_hook'] === 'NG') $issueCodes[] = 'b';
                    if ($sling['kelengkapan_tag_sling_belt'] === 'NG') $issueCodes[] = 'c';
                    if ($sling['bagian_pinggir_belt_robek'] === 'NG') $issueCodes[] = 'd';
                    if ($sling['pengecekan_lapisan_belt_1'] === 'NG') $issueCodes[] = 'e';
                    if ($sling['pengecekan_jahitan_belt'] === 'NG') $issueCodes[] = 'f';
                    if ($sling['pengecekan_permukaan_belt'] === 'NG') $issueCodes[] = 'g';
                    if ($sling['pengecekan_lapisan_belt_2'] === 'NG') $issueCodes[] = 'h';
                    if ($sling['pengecekan_aus'] === 'NG') $issueCodes[] = 'h';
                }

                // Map issue codes for Indoor type
                if ($sling['type'] === 'Sling Wire') {
                    if ($sling['hook_wire'] === 'NG') $issueCodes[] = 'a';
                    if ($sling['pengunci_hook'] === 'NG') $issueCodes[] = 'b';
                    if ($sling['serabut_wire'] === 'NG') $issueCodes[] = 'i';
                    if ($sling['bagian_wire_1'] === 'NG') $issueCodes[] = 'j';
                    if ($sling['bagian_wire_2'] === 'NG') $issueCodes[] = 'k';
                    if ($sling['kumpulan_wire_1'] === 'NG') $issueCodes[] = 'l';
                    if ($sling['diameter_wire'] === 'NG') $issueCodes[] = 'm';
                    if ($sling['kumpulan_wire_2'] === 'NG') $issueCodes[] = 'n';
                    if ($sling['mata_sling'] === 'NG') $issueCodes[] = 'o';
                }

                if (empty($issueCodes)) {
                    $issueCodes[] = 'OK';
                }

                $months[$month] = $issueCodes;
            }

            return [
                'sling_number' => $slingNumber,
                'type' => $slingType,
                'location_name' => $location_name,
                'plant' => $slingPlant,
                'tanggal_pengecekan' => $slingPengecekan,
                'months' => $months,
            ];
        });

        // Convert to JSON
        $jsonString = json_encode($mappedSlingData, JSON_PRETTY_PRINT);

        // Save JSON to a file
        Storage::disk('local')->put('sling_data.json', $jsonString);

        return view('dashboard.combined_sling_report', [
            'slingData' => $mappedSlingData,
            'selectedYear' => $selectedYear,
        ]);
    }
}
