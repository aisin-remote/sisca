<?php

use App\Http\Controllers\AparController;
use App\Http\Controllers\Co2Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EyewasherController;
use App\Http\Controllers\HydrantController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NitrogenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SlingController;
use App\Http\Controllers\TanduController;
use App\Http\Controllers\TembinController;
use App\Models\Eyewasher;
use App\Models\Hydrant;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard.index');
Route::get('/dashboard/home/grafik-status', [DashboardController::class, 'index'])->name('dashboard.grafik');

Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('dashboard')->middleware('auth');

// Route Apar
Route::resource('/dashboard/apar/data_apar', AparController::class)->except('show')->middleware('auth');
Route::put('/dashboard/apar/data_apar/{data_apar}', [AparController::class, 'update'])->name('data_apar.update');

// Route Hydrant
Route::resource('/dashboard/hydrant/data-hydrant', HydrantController::class)->except('show')->middleware('auth');
Route::put('/dashboard/hydrant/data-hydrant/{data_hydrant}', [HydrantController::class, 'update'])->name('data-hydrant.update');

//Route Nitrogen
Route::resource('/dashboard/nitrogen/data-nitrogen', NitrogenController::class)->except('show')->middleware('auth');
Route::put('/dashboard/nitrogen/data-nitrogen/{data_nitrogen}', [NitrogenController::class, 'update'])->name('data-nitrogen.update');

// Route Co2
Route::resource('/dashboard/co2/data-co2', Co2Controller::class)->except('show')->middleware('auth');
Route::put('/dashboard/co2/data-co2/{data_co2}', [Co2Controller::class, 'update'])->name('data-co2.update');

// Route Tandu
Route::resource('/dashboard/tandu/data-tandu', TanduController::class)->except('show')->middleware('auth');
Route::put('/dashboard/tandu/data-tandu/{data_tandu}', [TanduController::class, 'update'])->name('data-tandu.update');

// Route Eye Washer
Route::resource('/dashboard/eyewasher/data-eyewasher', EyewasherController::class)->except('show')->middleware('auth');
Route::put('/dashboard/eyewasher/data-eyewasher/{data_eyewasher}', [EyewasherController::class, 'update'])->name('data-eyewasher.update');

// Route Sling
Route::resource('/dashboard/sling/data-sling', SlingController::class)->except('show')->middleware('auth');
Route::put('/dashboard/sling/data-sling/{data_sling}', [SlingController::class, 'update'])->name('data-sling.update');

// Route Tembin
Route::resource('/dashboard/tembin/data-tembin', TembinController::class)->except('show')->middleware('auth');
Route::put('/dashboard/tembin/data-tembin/{data_tembin}', [TembinController::class, 'update'])->name('data-tembin.update');

// Route Location
Route::resource('/dashboard/location', LocationController::class)->except('show', 'destroy')->middleware('auth');
Route::delete('/dashboard/location/{data_location}', [LocationController::class, 'destroy'])->name('location.destroy');
// Route::put('/dashboard/apar/data_location/{data_location}', [LocationController::class, 'update'])->name('data_location.update');

use App\Http\Controllers\CheckSheetController;

// checksheet
Route::get('/dashboard/apar/checksheet', [CheckSheetController::class, 'showForm'])->name('show.form');
Route::post('/dashboard/apar/process-checksheet', [CheckSheetController::class, 'processForm'])->name('process.form');

use App\Http\Controllers\CheckSheetCo2Controller;


// Menggunakan middleware auth untuk routes terkait checksheetco2
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/apar/checksheetco2/{tagNumber}', [CheckSheetCo2Controller::class, 'showForm'])->name('checksheetco2');
    Route::post('/dashboard/apar/process-checksheet-co2-af11e/{tagNumber}', [CheckSheetCo2Controller::class, 'store'])->name('process.checksheet.co2');
});

use App\Http\Controllers\CheckSheetPowderController;

// Menggunakan middleware auth untuk routes terkait checksheetpowder
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/apar/checksheetpowder/{tagNumber}', [CheckSheetPowderController::class, 'showForm'])->name('checksheetpowder');
    Route::post('/dashboard/apar/process-checksheet-powder/{tagNumber}', [CheckSheetPowderController::class, 'store'])->name('process.checksheet.powder');
});

use App\Http\Controllers\AparReportController;

Route::get('/apar-report', [AparReportController::class, 'index'])->name('apar.report')->middleware('auth');

use App\Http\Controllers\CombinedAparController;

Route::get('/dashboard/home/checksheet-report-apar', [CombinedAparController::class, 'index'])->name('home.checksheet.apar')->middleware('auth');

use App\Http\Controllers\CheckSheetHydrantIndoorController;

// Menggunakan middleware auth untuk routes terkait checksheethydrantindoor
Route::middleware(['auth'])->group(function () {
    Route::get('/checksheethydrantindoor', function () {
        return view('dashboard.checkSheet.checkHydrantIndoor');
    })->name('checksheet.hydrantindoor');

    Route::post('/dashboard/apar/process-checksheet-hydrantindoor', [CheckSheetHydrantIndoorController::class, 'store'])->name('process.checksheet.hydrantindoor');
});

use App\Http\Controllers\CheckSheetHydrantOutdoorController;

// Menggunakan middleware auth untuk routes terkait checksheethydrantoutdoor
Route::middleware(['auth'])->group(function () {
    Route::get('/checksheethydrantoutdoor', function () {
        return view('dashboard.checkSheet.checkHydrantOutdoor');
    })->name('checksheet.hydrantoutdoor');

    Route::post('/dashboard/apar/process-checksheet-hydrantoutdoor', [CheckSheetHydrantOutdoorController::class, 'store'])->name('process.checksheet.hydrantoutdoor');
});

use App\Http\Controllers\CheckSheetNitrogenServerController;

// Menggunakan middleware auth untuk routes terkait checksheetnitrogenserver
Route::middleware(['auth'])->group(function () {
    Route::get('/checksheetnitrogenserver', function () {
        return view('dashboard.checkSheet.checkNitrogenServer');
    })->name('checksheet.nitrogen.server');

    Route::post('/dashboard/apar/process-checksheet-nitrogen-server', [CheckSheetNitrogenServerController::class, 'store'])->name('process.checksheet.nitrogen.server');
});

Route::get('/checksheettabungco2', function () {
    return view('dashboard.checkSheet.checkTabungCo2');
});

Route::get('/checksheettandu', function () {
    return view('dashboard.checkSheet.checkTandu');
});

Route::get('/checksheeteyewasherwwtp', function () {
    return view('dashboard.checkSheet.checkEyewasherWWTP');
});

Route::get('/checksheeteyewashertps', function () {
    return view('dashboard.checkSheet.checkEyewasherTPS');
});

Route::get('/checksheeteyewasherplant', function () {
    return view('dashboard.checkSheet.checkEyewasherPlant');
});

Route::get('/checksheeteyewasherchemical', function () {
    return view('dashboard.checkSheet.checkEyewasherChemical');
});

Route::get('/checksheetslingwire', function () {
    return view('dashboard.checkSheet.checkSlingWire');
});

Route::get('/checksheetslingbelt', function () {
    return view('dashboard.checkSheet.checkSlingBelt');
});

Route::get('/checksheettembinmonthly', function () {
    return view('dashboard.checkSheet.checkTembinMonthly');
});

Route::get('/checksheettembindaily', function () {
    return view('dashboard.checkSheet.checkTembinDaily');
});

Route::get('/checksheetchainblock', function () {
    return view('dashboard.checkSheet.checkChainBlock');
});

Route::get('/checksheethoistcrane', function () {
    return view('dashboard.checkSheet.checkHoistCrane');
});
