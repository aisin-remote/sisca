<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use Illuminate\Http\Request;
use App\Http\Controllers\array_except;
use App\Models\CheckSheetBodyHarnest;
use App\Models\CheckSheetChainblock;
use App\Models\CheckSheetCo2;
use App\Models\CheckSheetEyewasher;
use App\Models\CheckSheetEyewasherShower;
use App\Models\CheckSheetFacp;
use App\Models\CheckSheetHeadCrane;
use App\Models\CheckSheetHydrantIndoor;
use App\Models\CheckSheetHydrantOutdoor;
use App\Models\CheckSheetNitrogenServer;
use App\Models\CheckSheetPowder;
use App\Models\CheckSheetSafetyBelt;
use App\Models\CheckSheetSlingBelt;
use App\Models\CheckSheetSlingWire;
use App\Models\CheckSheetTabungCo2;
use App\Models\CheckSheetTandu;
use App\Models\CheckSheetTembin;
use App\Models\CheckSheetItemHeadCrane;
use Auth;

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



        // Grafik Tandu


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



        // Grafik Eyewasher


        $notOkData_Eyewasher = [];
        $okData_Eyewasher = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkCountEyewasher = CheckSheetEyewasher::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pijakan', 'NG')
                        ->orWhere('pipa_saluran_air', 'NG')
                        ->orWhere('wastafel', 'NG')
                        ->orWhere('kran_air', 'NG')
                        ->orWhere('tuas', 'NG');
                })
                ->count();

            $notOkCountShower = CheckSheetEyewasherShower::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('instalation_base', 'NG')
                        ->orWhere('pipa_saluran_air', 'NG')
                        ->orWhere('wastafel_eye_wash', 'NG')
                        ->orWhere('tuas_eye_wash', 'NG')
                        ->orWhere('kran_eye_wash', 'NG')
                        ->orWhere('tuas_shower', 'NG')
                        ->orWhere('sign', 'NG')
                        ->orWhere('shower_head', 'NG');
                })
                ->count();
            $notOkData_Eyewasher[] = $notOkCountEyewasher + $notOkCountShower;

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okCountEyewasher = CheckSheetEyewasher::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('pijakan', 'OK')
                        ->where('pipa_saluran_air', 'OK')
                        ->where('wastafel', 'OK')
                        ->where('kran_air', 'OK')
                        ->where('tuas', 'OK');
                })
                ->count();

            $okCountShower = CheckSheetEyewasherShower::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('instalation_base', 'OK')
                        ->where('pipa_saluran_air', 'OK')
                        ->where('wastafel_eye_wash', 'OK')
                        ->where('tuas_eye_wash', 'OK')
                        ->where('kran_eye_wash', 'OK')
                        ->where('tuas_shower', 'OK')
                        ->where('sign', 'OK')
                        ->where('shower_head', 'OK');
                })
                ->count();

            $okData_Eyewasher[] = $okCountEyewasher + $okCountShower;
        }

        $data_Eyewasher = [
            'labels' => $labels,
            'okData_Eyewasher' => $okData_Eyewasher,
            'notOkData_Eyewasher' => $notOkData_Eyewasher,
        ];



        // Grafik Sling


        $notOkData_Sling = [];
        $okData_Sling = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkCountWire = CheckSheetSlingWire::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('serabut_wire', 'NG')
                        ->orWhere('bagian_wire_1', 'NG')
                        ->orWhere('bagian_wire_2', 'NG')
                        ->orWhere('kumpulan_wire_1', 'NG')
                        ->orWhere('diameter_wire', 'NG')
                        ->orWhere('kumpulan_wire_2', 'NG')
                        ->orWhere('hook_wire', 'NG')
                        ->orWhere('pengunci_hook', 'NG')
                        ->orWhere('mata_sling', 'NG');
                })
                ->count();

            $notOkCountBelt = CheckSheetSlingBelt::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('kelengkapan_tag_sling_belt', 'NG')
                        ->orWhere('bagian_pinggir_belt_robek', 'NG')
                        ->orWhere('pengecekan_lapisan_belt_1', 'NG')
                        ->orWhere('pengecekan_jahitan_belt', 'NG')
                        ->orWhere('pengecekan_permukaan_belt', 'NG')
                        ->orWhere('pengecekan_lapisan_belt_2', 'NG')
                        ->orWhere('pengecekan_aus', 'NG')
                        ->orWhere('hook_wire', 'NG')
                        ->orWhere('pengunci_hook', 'NG');
                })
                ->count();
            $notOkData_Sling[] = $notOkCountWire + $notOkCountBelt;

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okCountWire = CheckSheetSlingWire::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('serabut_wire', 'OK')
                        ->where('bagian_wire_1', 'OK')
                        ->where('bagian_wire_2', 'OK')
                        ->where('kumpulan_wire_1', 'OK')
                        ->where('diameter_wire', 'OK')
                        ->where('kumpulan_wire_2', 'OK')
                        ->where('hook_wire', 'OK')
                        ->where('pengunci_hook', 'OK')
                        ->where('mata_sling', 'OK');
                })
                ->count();

            $okCountBelt = CheckSheetSlingBelt::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('kelengkapan_tag_sling_belt', 'OK')
                        ->where('bagian_pinggir_belt_robek', 'OK')
                        ->where('pengecekan_lapisan_belt_1', 'OK')
                        ->where('pengecekan_jahitan_belt', 'OK')
                        ->where('pengecekan_permukaan_belt', 'OK')
                        ->where('pengecekan_lapisan_belt_2', 'OK')
                        ->where('pengecekan_aus', 'OK')
                        ->where('hook_wire', 'OK')
                        ->where('pengunci_hook', 'OK');
                })
                ->count();

            $okData_Sling[] = $okCountWire + $okCountBelt;
        }

        $data_Sling = [
            'labels' => $labels,
            'okData_Sling' => $okData_Sling,
            'notOkData_Sling' => $notOkData_Sling,
        ];



        // Grafik Tembin


        $notOkData_Tembin = [];
        $okData_Tembin = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkData_Tembin[] = CheckSheetTembin::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('master_link', 'NG')
                        ->orWhere('body_tembin', 'NG')
                        ->orWhere('mur_baut', 'NG')
                        ->orWhere('shackle', 'NG')
                        ->orWhere('hook_atas', 'NG')
                        ->orWhere('pengunci_hook_atas', 'NG')
                        ->orWhere('mata_chain', 'NG')
                        ->orWhere('chain', 'NG')
                        ->orWhere('hook_bawah', 'NG')
                        ->orWhere('pengunci_hook_bawah', 'NG');
                })
                ->count();

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okData_Tembin[] = CheckSheetTembin::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('master_link', 'OK')
                        ->where('body_tembin', 'OK')
                        ->where('mur_baut', 'OK')
                        ->where('shackle', 'OK')
                        ->where('hook_atas', 'OK')
                        ->where('pengunci_hook_atas', 'OK')
                        ->where('mata_chain', 'OK')
                        ->where('chain', 'OK')
                        ->where('hook_bawah', 'OK')
                        ->where('pengunci_hook_bawah', 'OK');
                })
                ->count();
        }


        $data_Tembin = [
            'labels' => $labels,
            'okData_Tembin' => $okData_Tembin,
            'notOkData_Tembin' => $notOkData_Tembin,
        ];



        // Grafik Chain Block


        $notOkData_Chainblock = [];
        $okData_Chainblock = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkData_Chainblock[] = CheckSheetChainblock::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('geared_trolley', 'NG')
                        ->orWhere('chain_geared_trolley_1', 'NG')
                        ->orWhere('chain_geared_trolley_2', 'NG')
                        ->orWhere('hooking_geared_trolly', 'NG')
                        ->orWhere('latch_hook_atas', 'NG')
                        ->orWhere('hook_atas', 'NG')
                        ->orWhere('hand_chain', 'NG')
                        ->orWhere('load_chain', 'NG')
                        ->orWhere('latch_hook_bawah', 'NG')
                        ->orWhere('hook_bawah', 'NG');
                })
                ->count();

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okData_Chainblock[] = CheckSheetChainblock::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('geared_trolley', 'OK')
                        ->where('chain_geared_trolley_1', 'OK')
                        ->where('chain_geared_trolley_2', 'OK')
                        ->where('hooking_geared_trolly', 'OK')
                        ->where('latch_hook_atas', 'OK')
                        ->where('hook_atas', 'OK')
                        ->where('hand_chain', 'OK')
                        ->where('load_chain', 'OK')
                        ->where('latch_hook_bawah', 'OK')
                        ->where('hook_bawah', 'OK');
                })
                ->count();
        }


        $data_Chainblock = [
            'labels' => $labels,
            'okData_Chainblock' => $okData_Chainblock,
            'notOkData_Chainblock' => $notOkData_Chainblock,
        ];



        // Grafik Body Harnest


        $notOkData_Bodyharnest = [];
        $okData_Bodyharnest = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkData_Bodyharnest[] = CheckSheetBodyHarnest::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('shoulder_straps', 'NG')
                        ->orWhere('hook', 'NG')
                        ->orWhere('buckles_waist', 'NG')
                        ->orWhere('buckles_chest', 'NG')
                        ->orWhere('leg_straps', 'NG')
                        ->orWhere('buckles_leg', 'NG')
                        ->orWhere('back_d_ring', 'NG')
                        ->orWhere('carabiner', 'NG')
                        ->orWhere('straps_rope', 'NG')
                        ->orWhere('shock_absorber', 'NG');
                })
                ->count();

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okData_Bodyharnest[] = CheckSheetBodyHarnest::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('shoulder_straps', 'OK')
                        ->where('hook', 'OK')
                        ->where('buckles_waist', 'OK')
                        ->where('buckles_chest', 'OK')
                        ->where('leg_straps', 'OK')
                        ->where('buckles_leg', 'OK')
                        ->where('back_d_ring', 'OK')
                        ->where('carabiner', 'OK')
                        ->where('straps_rope', 'OK')
                        ->where('shock_absorber', 'OK');
                })
                ->count();
        }


        $data_Bodyharnest = [
            'labels' => $labels,
            'okData_Bodyharnest' => $okData_Bodyharnest,
            'notOkData_Bodyharnest' => $notOkData_Bodyharnest,
        ];



        // Grafik Safety Belt


        $notOkData_Safetybelt = [];
        $okData_Safetybelt = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkData_Safetybelt[] = CheckSheetSafetyBelt::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('buckle', 'NG')
                        ->orWhere('seams', 'NG')
                        ->orWhere('reel', 'NG')
                        ->orWhere('shock_absorber', 'NG')
                        ->orWhere('ring', 'NG')
                        ->orWhere('torso_belt', 'NG')
                        ->orWhere('strap', 'NG')
                        ->orWhere('rope', 'NG')
                        ->orWhere('seam_protection_tube', 'NG')
                        ->orWhere('hook', 'NG');
                })
                ->count();

            // Menghitung jumlah data tanpa nilai "NG" berdasarkan tag_number dan bulan
            $okData_Safetybelt[] = CheckSheetSafetyBelt::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->where(function ($query) {
                    $query->where('buckle', 'OK')
                        ->where('seams', 'OK')
                        ->where('reel', 'OK')
                        ->where('shock_absorber', 'OK')
                        ->where('ring', 'OK')
                        ->where('torso_belt', 'OK')
                        ->where('strap', 'OK')
                        ->where('rope', 'OK')
                        ->where('seam_protection_tube', 'OK')
                        ->where('hook', 'OK');
                })
                ->count();
        }


        $data_Safetybelt = [
            'labels' => $labels,
            'okData_Safetybelt' => $okData_Safetybelt,
            'notOkData_Safetybelt' => $notOkData_Safetybelt,
        ];



        // Grafik FACP

        $notOkData_Smoke_detector = [];
        $okData_Smoke_detector = [];

        $notOkData_Heat_detector = [];
        $okData_Heat_detector = [];

        $notOkData_Beam_detector = [];
        $okData_Beam_detector = [];

        $notOkData_Push_button = [];
        $okData_Push_button = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan tag_number dan bulan
            $notOkData_Smoke_detector[] = CheckSheetFacp::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->sum('ng_smoke_detector');
            $okData_Smoke_detector[] = CheckSheetFacp::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->sum('ok_smoke_detector');

            $notOkData_Heat_detector[] = CheckSheetFacp::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->sum('ng_heat_detector');
            $okData_Heat_detector[] = CheckSheetFacp::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->sum('ok_heat_detector');

            $notOkData_Beam_detector[] = CheckSheetFacp::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->sum('ng_beam_detector');
            $okData_Beam_detector[] = CheckSheetFacp::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->sum('ok_beam_detector');

            $notOkData_Push_button[] = CheckSheetFacp::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->sum('ng_push_button');
            $okData_Push_button[] = CheckSheetFacp::whereYear('tanggal_pengecekan', $selectedYear)
                ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)))
                ->sum('ok_push_button');
        }


        $data_Facp = [
            'labels' => $labels,
            'okData_Smoke_detector' => $okData_Smoke_detector,
            'notOkData_Smoke_detector' => $notOkData_Smoke_detector,
            'okData_Heat_detector' => $okData_Heat_detector,
            'notOkData_Heat_detector' => $notOkData_Heat_detector,
            'okData_Beam_detector' => $okData_Beam_detector,
            'notOkData_Beam_detector' => $notOkData_Beam_detector,
            'okData_Push_button' => $okData_Push_button,
            'notOkData_Push_button' => $notOkData_Push_button,
        ];

        // Grafik HeadCrane
        $notOkData_HeadCrane = [];
        $okData_HeadCrane = [];

        foreach ($labels as $label) {
            // Menghitung jumlah data dengan nilai "NG" berdasarkan bulan dan tahun
            $notOkData_HeadCrane[] = CheckSheetItemHeadCrane::whereHas('checkSheet', function ($query) use ($selectedYear, $label) {
                $query->whereYear('tanggal_pengecekan', $selectedYear)
                    ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)));
            })->where('check', 'NG') // Menggunakan "Failed" untuk NG
            ->count();
        
            // Menghitung jumlah data dengan nilai "OK" berdasarkan bulan dan tahun
            $okData_HeadCrane[] = CheckSheetItemHeadCrane::whereHas('checkSheet', function ($query) use ($selectedYear, $label) {
                $query->whereYear('tanggal_pengecekan', $selectedYear)
                    ->whereMonth('tanggal_pengecekan', date('m', strtotime($label)));
            })->where('check', 'OK') // Menggunakan "Passed" untuk OK
            ->count();
        }


        $data_HeadCrane = [
            'labels' => $labels,
            'okData_HeadCrane' => $okData_HeadCrane,
            'notOkData_HeadCrane' => $notOkData_HeadCrane,
        ];
        // dd($data_HeadCrane);


        $availableYears = range(date('Y') - 1, date('Y') + 1);

        return view('dashboard.index', compact('data_Apar', 'data_Hydrant', 'data_Nitrogen', 'data_Tabungco2', 'data_Tandu', 'data_Eyewasher', 'data_Sling', 'data_Tembin', 'data_Chainblock', 'data_Bodyharnest', 'data_Safetybelt', 'data_Facp','data_HeadCrane', 'availableYears'));
    }
}
