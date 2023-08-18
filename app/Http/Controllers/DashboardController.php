<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use Illuminate\Http\Request;
use App\Http\Controllers\array_except;
use App\Models\CheckSheetCo2;

class DashboardController extends Controller
{
    public function index()
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; // Contoh label bulan

        $notOkData = [];
        $okData = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkCount = CheckSheetCo2::whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
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
            $notOkData[] = $notOkCount;

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okCount = CheckSheetCo2::whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                          ->where(function ($query) {
                                $query->where('pressure', '<>', 'OK')
                                      ->orWhere('hose', '<>', 'OK')
                                      ->orWhere('corong', '<>', 'OK')
                                      ->orWhere('tabung', '<>', 'OK')
                                      ->orWhere('regulator', '<>', 'OK')
                                      ->orWhere('lock_pin', '<>', 'OK')
                                      ->orWhere('berat_tabung', '<>', 'OK');
                            })
                             ->count();
            $okData[] = $okCount;
        }

        $data = [
            'labels' => $labels,
            'okData' => $okData,
            'notOkData' => $notOkData,
        ];

        return view('dashboard.index', compact('data'));
    }
}
