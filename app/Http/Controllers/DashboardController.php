<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use Illuminate\Http\Request;
use App\Http\Controllers\array_except;
use App\Models\CheckSheetCo2;
use App\Models\CheckSheetHydrantIndoor;
use App\Models\CheckSheetHydrantOutdoor;
use App\Models\CheckSheetNitrogenServer;
use App\Models\CheckSheetPowder;
use App\Models\CheckSheetTabungCo2;
use App\Models\CheckSheetTandu;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $selectedYear = $request->input('year', date('Y'));


        // Grafik Apar


        $notOkData_Apar = [];
        $okData_Apar = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkCountCo2 = CheckSheetCo2::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pressure', 'NG')
                        ->orWhere('hose', 'NG')
                        ->orWhere('corong', 'NG')
                        ->orWhere('tabung', 'NG')
                        ->orWhere('regulator', 'NG')
                        ->orWhere('lock_pin', 'NG')
                        ->orWhere('berat_tabung', 'NG');
                })
                ->count();

            $notOkCountPowder = CheckSheetPowder::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pressure', 'NG')
                        ->orWhere('hose', 'NG')
                        ->orWhere('tabung', 'NG')
                        ->orWhere('regulator', 'NG')
                        ->orWhere('lock_pin', 'NG')
                        ->orWhere('powder', 'NG');
                })
                ->count();
            $notOkData_Apar[] = $notOkCountCo2 + $notOkCountPowder;

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okCountCo2 = CheckSheetCo2::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pressure', 'OK')
                        ->where('hose', 'OK')
                        ->where('corong', 'OK')
                        ->where('tabung', 'OK')
                        ->where('regulator', 'OK')
                        ->where('lock_pin', 'OK')
                        ->where('berat_tabung', 'OK');
                })
                ->count();

            $okCountPowder = CheckSheetPowder::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pressure', 'OK')
                        ->where('hose', 'OK')
                        ->where('tabung', 'OK')
                        ->where('regulator', 'OK')
                        ->where('lock_pin', 'OK')
                        ->where('powder', 'OK');
                })
                ->count();

            $okData_Apar[] = $okCountCo2 + $okCountPowder;
        }

        $data_Apar = [
            'labels' => $labels,
            'okData_Apar' => $okData_Apar,
            'notOkData_Apar' => $notOkData_Apar,
        ];



        // Grafik Hydrant


        $notOkData_Hydrant = [];
        $okData_Hydrant = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkCountIndoor = CheckSheetHydrantIndoor::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pintu', 'NG')
                        ->orWhere('lampu', 'NG')
                        ->orWhere('emergency', 'NG')
                        ->orWhere('nozzle', 'NG')
                        ->orWhere('selang', 'NG')
                        ->orWhere('valve', 'NG')
                        ->orWhere('coupling', 'NG')
                        ->orWhere('pressure', 'NG')
                        ->orWhere('kupla', 'NG');
                })
                ->count();

            $notOkCountOutdoor = CheckSheetHydrantOutdoor::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pintu', 'NG')
                        ->orWhere('nozzle', 'NG')
                        ->orWhere('selang', 'NG')
                        ->orWhere('tuas', 'NG')
                        ->orWhere('pilar', 'NG')
                        ->orWhere('penutup', 'NG')
                        ->orWhere('rantai', 'NG')
                        ->orWhere('kupla', 'NG');
                })
                ->count();
            $notOkData_Hydrant[] = $notOkCountIndoor + $notOkCountOutdoor;

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okCountIndoor = CheckSheetHydrantIndoor::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pintu', 'OK')
                        ->where('lampu', 'OK')
                        ->where('emergency', 'OK')
                        ->where('nozzle', 'OK')
                        ->where('selang', 'OK')
                        ->where('valve', 'OK')
                        ->where('coupling', 'OK')
                        ->where('pressure', 'OK')
                        ->where('kupla', 'OK');
                })
                ->count();

            $okCountOutdoor = CheckSheetHydrantOutdoor::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pintu', 'OK')
                        ->where('nozzle', 'OK')
                        ->where('selang', 'OK')
                        ->where('tuas', 'OK')
                        ->where('pilar', 'OK')
                        ->where('penutup', 'OK')
                        ->where('rantai', 'OK')
                        ->where('kupla', 'OK');
                })
                ->count();

            $okData_Hydrant[] = $okCountIndoor + $okCountOutdoor;
        }

        $data_Hydrant = [
            'labels' => $labels,
            'okData_Hydrant' => $okData_Hydrant,
            'notOkData_Hydrant' => $notOkData_Hydrant,
        ];



        // Grafik Nitrogen


        $notOkData_Nitrogen = [];
        $okData_Nitrogen = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkData_Nitrogen[] = CheckSheetNitrogenServer::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('operasional', 'NG')
                        ->orWhere('selector_mode', 'NG')
                        ->orWhere('pintu_tabung', 'NG')
                        ->orWhere('pressure_pilot', 'NG')
                        ->orWhere('pressure_no1', 'NG')
                        ->orWhere('pressure_no2', 'NG')
                        ->orWhere('pressure_no3', 'NG')
                        ->orWhere('pressure_no4', 'NG')
                        ->orWhere('pressure_no5', 'NG');
                })
                ->count();

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okData_Nitrogen[] = CheckSheetNitrogenServer::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('operasional', 'OK')
                        ->where('selector_mode', 'OK')
                        ->where('pintu_tabung', 'OK')
                        ->where('pressure_pilot', 'OK')
                        ->where('pressure_no1', 'OK')
                        ->where('pressure_no2', 'OK')
                        ->where('pressure_no3', 'OK')
                        ->where('pressure_no4', 'OK')
                        ->where('pressure_no5', 'OK');
                })
                ->count();
        }


        $data_Nitrogen = [
            'labels' => $labels,
            'okData_Nitrogen' => $okData_Nitrogen,
            'notOkData_Nitrogen' => $notOkData_Nitrogen,
        ];



        // Grafik Tabung Co2


        $notOkData_Tabungco2 = [];
        $okData_Tabungco2 = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkData_Tabungco2[] = CheckSheetTabungCo2::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('cover', 'NG')
                        ->orWhere('tabung', 'NG')
                        ->orWhere('lock_pin', 'NG')
                        ->orWhere('segel_lock_pin', 'NG')
                        ->orWhere('kebocoran_regulator_tabung', 'NG')
                        ->orWhere('selang', 'NG');
                })
                ->count();

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okData_Tabungco2[] = CheckSheetTabungCo2::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('cover', 'OK')
                        ->where('tabung', 'OK')
                        ->where('lock_pin', 'OK')
                        ->where('segel_lock_pin', 'OK')
                        ->where('kebocoran_regulator_tabung', 'OK')
                        ->where('selang', 'OK');
                })
                ->count();
        }


        $data_Tabungco2 = [
            'labels' => $labels,
            'okData_Tabungco2' => $okData_Tabungco2,
            'notOkData_Tabungco2' => $notOkData_Tabungco2,
        ];



        // Grafik Tandi


        $notOkData_Tandu = [];
        $okData_Tandu = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkData_Tandu[] = CheckSheetTandu::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('kunci_pintu', 'NG')
                        ->orWhere('pintu', 'NG')
                        ->orWhere('sign', 'NG')
                        ->orWhere('hand_grip', 'NG')
                        ->orWhere('body', 'NG')
                        ->orWhere('engsel', 'NG')
                        ->orWhere('kaki', 'NG')
                        ->orWhere('belt', 'NG')
                        ->orWhere('rangka', 'NG');

                })
                ->count();

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okData_Tandu[] = CheckSheetTandu::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('kunci_pintu', 'OK')
                        ->where('pintu', 'OK')
                        ->where('sign', 'OK')
                        ->where('hand_grip', 'OK')
                        ->where('body', 'OK')
                        ->where('engsel', 'OK')
                        ->where('kaki', 'OK')
                        ->where('belt', 'OK')
                        ->where('rangka', 'OK');
                })
                ->count();
        }


        $data_Tandu = [
            'labels' => $labels,
            'okData_Tandu' => $okData_Tandu,
            'notOkData_Tandu' => $notOkData_Tandu,
        ];


        $availableYears = range(date('Y'), date('Y') + 1);

        return view('dashboard.index', compact('data_Apar', 'data_Hydrant', 'data_Nitrogen', 'data_Tabungco2', 'data_Tandu', 'availableYears'));
    }
}
