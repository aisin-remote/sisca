<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use Illuminate\Http\Request;
use App\Http\Controllers\array_except;
use App\Models\CheckSheetCo2;
use App\Models\CheckSheetPowder;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $selectedYear = $request->input('year', date('Y'));

        $notOkData = [];
        $okData = [];

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
            $notOkData[] = $notOkCountCo2 + $notOkCountPowder;

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

            $okData[] = $okCountCo2 + $okCountPowder;
        }

        $data = [
            'labels' => $labels,
            'okData' => $okData,
            'notOkData' => $notOkData,
        ];

        $availableYears = range(date('Y'), date('Y') + 1);

        return view('dashboard.index', compact('data', 'availableYears'));
    }
}
