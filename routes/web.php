<?php

use App\Http\Controllers\AparController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HydrantController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
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

Route::get('/login', function() {
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
Route::put('dashboard/hydrant/data-hydrant/{data_hydrant}', [HydrantController::class, 'update'])->name('data-hydrant.update');


// Route Location
Route::resource('/dashboard/apar/data_location', LocationController::class)->except('show','destroy')->middleware('auth');
Route::delete('/dashboard/apar/data_location/{data_location}', [LocationController::class, 'destroy'])->name('data_location.destroy');
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

Route::get('/checksheethydrantindoor', function() {
    return view('dashboard.checkSheet.checkHydrantIndoor');
});

Route::get('/checksheethydrantoutdoor', function() {
    return view('dashboard.checkSheet.checkHydrantOutdoor');
});


Route::get('/checksheetnitrogenserver', function() {
    return view('dashboard.checkSheet.checkNitrogenServer');
});

Route::get('/checksheettabungco2', function() {
    return view('dashboard.checkSheet.checkTabungCo2');
});

Route::get('/checksheettandu', function() {
    return view('dashboard.checkSheet.checkTandu');
});
