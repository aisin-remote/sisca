<?php

use App\Http\Controllers\AparController;
use App\Http\Controllers\BodyharnestController;
use App\Http\Controllers\ChainblockController;
use App\Http\Controllers\CheckSheetChainblockController;
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
use App\Models\Apar;
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

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.grafik');

Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('dashboard')->middleware('auth');

// Route Apar
Route::resource('/dashboard/master/apar', AparController::class)->except('update')->middleware('auth');
Route::put('/dashboard/master/apar/{data_apar}', [AparController::class, 'update'])->name('apar.update');


// lokasi Apar
Route::get('/dashboard/location/apar', [AparController::class, 'location'])->name('apar.location.index')->middleware('auth');
Route::get('/dashboard/location/all-equipment', function () {
    return view('dashboard.location.mapping');
})->middleware('auth');
Route::get('/dashboard/location/apar/body', function () {
    return view('dashboard.apar.location.body');
})->middleware('auth');
Route::get('/dashboard/location/apar/kantin', function () {
    return view('dashboard.apar.location.kantin');
})->middleware('auth');
Route::get('/dashboard/location/apar/loker-pos', function () {
    return view('dashboard.apar.location.loker');
})->middleware('auth');
Route::get('/dashboard/location/apar/main-station', function () {
    return view('dashboard.apar.location.main');
})->middleware('auth');
Route::get('/dashboard/location/apar/masjid', function () {
    return view('dashboard.apar.location.masjid');
})->middleware('auth');
Route::get('/dashboard/location/apar/office', function () {
    return view('dashboard.apar.location.office');
})->middleware('auth');
Route::get('/dashboard/location/apar/pump-room', function () {
    return view('dashboard.apar.location.pump');
})->middleware('auth');
Route::get('/dashboard/location/apar/storage-chemical', function () {
    return view('dashboard.apar.location.storage');
})->middleware('auth');
Route::get('/dashboard/location/apar/unit', function () {
    return view('dashboard.apar.location.unit');
})->middleware('auth');
Route::get('/dashboard/location/apar/wwt', function () {
    return view('dashboard.apar.location.wwt');
})->middleware('auth');


// lokasi Hydrant
Route::get('/dashboard/location/hydrant', [HydrantController::class, 'location'])->name('hydrant.location.index')->middleware('auth');
Route::get('/dashboard/location/hydrant/outdoor', function () {
    return view('dashboard.hydrant.location.outdoor');
})->middleware('auth');
Route::get('/dashboard/location/hydrant/indoor', function () {
    return view('dashboard.hydrant.location.indoor');
})->middleware('auth');


// Route Hydrant
Route::resource('/dashboard/master/hydrant', HydrantController::class)->except('update')->middleware('auth');
Route::put('/dashboard/master/hydrant/{data_hydrant}', [HydrantController::class, 'update'])->name('hydrant.update');

//Route Nitrogen
Route::resource('/dashboard/master/nitrogen', NitrogenController::class)->except('update')->middleware('auth');
Route::put('/dashboard/master/nitrogen/{data_nitrogen}', [NitrogenController::class, 'update'])->name('nitrogen.update');

// Route Co2
Route::resource('/dashboard/master/co2', Co2Controller::class)->except('update')->middleware('auth');
Route::put('/dashboard/master/co2/{data_co2}', [Co2Controller::class, 'update'])->name('co2.update');

// Route Tandu
Route::resource('/dashboard/master/tandu', TanduController::class)->except('update')->middleware('auth');
Route::put('/dashboard/master/tandu/{data_tandu}', [TanduController::class, 'update'])->name('tandu.update');

// Route Eye Washer
Route::resource('/dashboard/master/eye-washer', EyewasherController::class)->except('update')->middleware('auth');
Route::put('/dashboard/master/eye-washer/{data_eyewasher}', [EyewasherController::class, 'update'])->name('eye-washer.update');

// Route Sling
Route::resource('/dashboard/master/sling', SlingController::class)->except('update')->middleware('auth');
Route::put('/dashboard/master/sling/{data_sling}', [SlingController::class, 'update'])->name('sling.update');

// Route Tembin
Route::resource('/dashboard/master/tembin', TembinController::class)->except('update')->middleware('auth');
Route::put('/dashboard/master/tembin/{data_tembin}', [TembinController::class, 'update'])->name('tembin.update');

// Route Chain Block
Route::resource('/dashboard/master/chain-block', ChainblockController::class)->middleware('auth');
Route::put('/dashboard/master/chain-block/{data_chainblock}', [ChainblockController::class, 'update'])->name('data-chainblock.update');

// Route Body Harnest
Route::resource('/dashboard/master/body-harnest', BodyharnestController::class)->middleware('auth');
Route::put('/dashboard/master/body-harnest/{data_bodyharnest}', [BodyharnestController::class, 'update'])->name('data-bodyharnest.update');

// Route Location
Route::resource('/dashboard/master/location', LocationController::class)->except('show', 'destroy')->middleware('auth');
Route::delete('/dashboard/master/location/{data_location}', [LocationController::class, 'destroy'])->name('location.destroy');
// Route::put('/dashboard/apar/data_location/{data_location}', [LocationController::class, 'update'])->name('data_location.update');

use App\Http\Controllers\CheckSheetController;
use App\Http\Controllers\CheckSheetEyewasherController;
use App\Http\Controllers\CheckSheetEyewasherOnlyController;
use App\Http\Controllers\CheckSheetEyewasherShowerController;
use App\Http\Controllers\CheckSheetNitrogenServerController;
use App\Http\Controllers\CheckSheetHydrantController;
use App\Http\Controllers\CheckSheetSlingBeltController;
use App\Http\Controllers\CheckSheetSlingController;
use App\Http\Controllers\CheckSheetSlingWireController;
use App\Http\Controllers\CheckSheetTabungCo2Controller;
use App\Http\Controllers\CheckSheetTanduController;
use App\Http\Controllers\CheckSheetTembinController;
use App\Models\CheckSheetEyewasherShower;

// checksheet
Route::get('/dashboard/check-sheet/apar', [CheckSheetController::class, 'showForm'])->name('show.form');
Route::get('/dashboard/check-sheet/hydrant', [CheckSheetHydrantController::class, 'showForm'])->name('hydrant.show.form');
Route::get('/dashboard/check-sheet/nitrogen', [CheckSheetNitrogenServerController::class, 'showForm'])->name('nitrogen.show.form');
Route::get('/dashboard/check-sheet/co2', [CheckSheetTabungCo2Controller::class, 'showForm'])->name('co2.show.form');
Route::get('/dashboard/check-sheet/tandu', [CheckSheetTanduController::class, 'showForm'])->name('tandu.show.form');
Route::get('/dashboard/check-sheet/eye-washer', [CheckSheetEyewasherController::class, 'showForm'])->name('eyewasher.show.form');
Route::get('/dashboard/check-sheet/sling', [CheckSheetSlingController::class, 'showForm'])->name('sling.show.form');
Route::get('/dashboard/check-sheet/tembin', [CheckSheetTembinController::class, 'showForm'])->name('tembin.show.form');
Route::get('/dashboard/check-sheet/chainblock', [CheckSheetChainblockController::class, 'showForm'])->name('chainblock.show.form');
Route::get('/dashboard/check-sheet/bodyharnest', [CheckSheetBodyHarnestController::class, 'showForm'])->name('bodyharnest.show.form');






Route::post('/dashboard/apar/process-checksheet', [CheckSheetController::class, 'processForm'])->name('process.form');
Route::get('/dashboard/check-sheet/apar/all-check-sheet', [CheckSheetController::class, 'index'])->name('checksheet.index');

Route::get('/dashboard/hydrant/checksheet', [CheckSheetHydrantController::class, 'showForm'])->name('hydrant.show.form');
Route::post('/dashboard/hydrant/process-checksheet', [CheckSheetHydrantController::class, 'processForm'])->name('hydrant.process.form');
Route::get('/dashboard/hydrant/checksheet/all-check-sheet', [CheckSheetHydrantController::class, 'index'])->name('hydrant.checksheet.index');

Route::get('/dashboard/nitrogen/checksheet/all-check-sheet', [CheckSheetNitrogenServerController::class, 'index'])->name('nitrogen.checksheet.index');
Route::post('/dashboard/nitrogen/process-checksheet', [CheckSheetNitrogenServerController::class, 'processForm'])->name('nitrogen.process.form');

Route::post('/dashboard/co2/process-checksheet', [CheckSheetTabungCo2Controller::class, 'processForm'])->name('co2.process.form');
Route::get('/dashboard/co2/checksheet/all-check-sheet', [CheckSheetTabungCo2Controller::class, 'index'])->name('co2.checksheet.index');

Route::post('/dashboard/tandu/process-checksheet', [CheckSheetTanduController::class, 'processForm'])->name('tandu.process.form');
Route::get('/dashboard/tandu/checksheet/all-check-sheet', [CheckSheetTanduController::class, 'index'])->name('tandu.checksheet.index');

Route::post('/dashboard/eyewasher/process-checksheet', [CheckSheetEyewasherController::class, 'processForm'])->name('eyewasher.process.form');
Route::get('/dashboard/eyewasher/checksheet/all-check-sheet', [CheckSheetEyewasherController::class, 'index'])->name('eyewasher.checksheet.index');

Route::post('/dashboard/sling/process-checksheet', [CheckSheetSlingController::class, 'processForm'])->name('sling.process.form');
Route::get('/dashboard/sling/checksheet/all-check-sheet', [CheckSheetSlingController::class, 'index'])->name('sling.checksheet.index');

Route::post('/dashboard/tembin/process-checksheet', [CheckSheetTembinController::class, 'processForm'])->name('tembin.process.form');
Route::get('/dashboard/tembin/checksheet/all-check-sheet', [CheckSheetTembinController::class, 'index'])->name('tembin.checksheet.index');

Route::post('/dashboard/chainblock/process-checksheet', [CheckSheetChainblockController::class, 'processForm'])->name('chainblock.process.form');
Route::get('/dashboard/chainblock/checksheet/all-check-sheet', [CheckSheetChainblockController::class, 'index'])->name('chainblock.checksheet.index');




//lagi fix ini (hapus jika indoor sudah kelar)
// Menggunakan middleware auth untuk routes terkait checksheetco2


//Checksheet Tandu

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/tandu/checksheettandu/{tanduNumber}', [CheckSheetTanduController::class, 'createForm'])->name('checksheettandu');
    Route::post('/dashboard/tandu/process-checksheet-tandu/{tanduNumber}', [CheckSheetTanduController::class, 'store'])->name('process.checksheet.tandu');
    Route::delete('/dashboard/check-sheet/tandu/{id}', [CheckSheetTanduController::class, 'destroy'])->name('tandu.checksheettandu.destroy');
    Route::get('/dashboard/check-sheet/tandu/{id}/edit', [CheckSheetTanduController::class, 'edit'])->name('tandu.checksheettandu.edit');
    Route::put('/dashboard/check-sheet/tandu/{id}', [CheckSheetTanduController::class, 'update'])->name('tandu.checksheettandu.update');
    Route::get('/dashboard/check-sheet/tandu/{id}/show', [CheckSheetTanduController::class, 'show'])->name('tandu.checksheettandu.show');

});



//Checksheet Chain Block

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/chainblock/checksheetchainblock/{chainblockNumber}', [CheckSheetChainblockController::class, 'createForm'])->name('checksheetchainblock');
    Route::post('/dashboard/chainblock/process-checksheet-chainblock/{chainblockNumber}', [CheckSheetChainblockController::class, 'store'])->name('process.checksheet.chainblock');
    Route::delete('/dashboard/check-sheet/chainblock/{id}', [CheckSheetChainblockController::class, 'destroy'])->name('chainblock.checksheetchainblock.destroy');
    Route::get('/dashboard/check-sheet/chainblock/{id}/edit', [CheckSheetChainblockController::class, 'edit'])->name('chainblock.checksheetchainblock.edit');
    Route::put('/dashboard/check-sheet/chainblock/{id}', [CheckSheetChainblockController::class, 'update'])->name('chainblock.checksheetchainblock.update');
    Route::get('/dashboard/check-sheet/chainblock/{id}/show', [CheckSheetChainblockController::class, 'show'])->name('chainblock.checksheetchainblock.show');

});



//Checksheet Tembin

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/tembin/checksheettembin/{tembinNumber}', [CheckSheetTembinController::class, 'createForm'])->name('checksheettembin');
    Route::post('/dashboard/tembin/process-checksheet-tembin/{tembinNumber}', [CheckSheetTembinController::class, 'store'])->name('process.checksheet.tembin');
    Route::delete('/dashboard/check-sheet/tembin/{id}', [CheckSheetTembinController::class, 'destroy'])->name('tembin.checksheettembin.destroy');
    Route::get('/dashboard/check-sheet/tembin/{id}/edit', [CheckSheetTembinController::class, 'edit'])->name('tembin.checksheettembin.edit');
    Route::put('/dashboard/check-sheet/tembin/{id}', [CheckSheetTembinController::class, 'update'])->name('tembin.checksheettembin.update');
    Route::get('/dashboard/check-sheet/tembin/{id}/show', [CheckSheetTembinController::class, 'show'])->name('tembin.checksheettembin.show');

});



//Checksheet Sling Belt
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/sling/checksheetbelt/{slingNumber}', [CheckSheetSlingBeltController::class, 'showForm'])->name('checksheetbelt');
    Route::post('/dashboard/sling/process-checksheet-belt/{slingNumber}', [CheckSheetSlingBeltController::class, 'store'])->name('process.checksheet.belt');

    Route::delete('/dashboard/check-sheet/sling-belt/{id}', [CheckSheetSlingBeltController::class, 'destroy'])->name('sling.checksheetbelt.destroy');
    Route::get('/dashboard/check-sheet/sling-belt/{id}/edit', [CheckSheetSlingBeltController::class, 'edit'])->name('sling.checksheetbelt.edit');
    Route::put('/dashboard/check-sheet/sling-belt/{id}', [CheckSheetSlingBeltController::class, 'update'])->name('sling.checksheetbelt.update');
    Route::get('/dashboard/check-sheet/sling-belt/{id}/show', [CheckSheetSlingBeltController::class, 'show'])->name('sling.checksheetbelt.show');

});



//Checksheet Sling Wire
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/sling/checksheetwire/{slingNumber}', [CheckSheetSlingWireController::class, 'showForm'])->name('checksheetwire');
    Route::post('/dashboard/sling/process-checksheet-wire/{slingNumber}', [CheckSheetSlingWireController::class, 'store'])->name('process.checksheet.wire');

    Route::delete('/dashboard/check-sheet/sling-wire/{id}', [CheckSheetSlingWireController::class, 'destroy'])->name('sling.checksheetwire.destroy');
    Route::get('/dashboard/check-sheet/sling-wire/{id}/edit', [CheckSheetSlingWireController::class, 'edit'])->name('sling.checksheetwire.edit');
    Route::put('/dashboard/check-sheet/sling-wire/{id}', [CheckSheetSlingWireController::class, 'update'])->name('sling.checksheetwire.update');
    Route::get('/dashboard/check-sheet/sling-wire/{id}/show', [CheckSheetSlingWireController::class, 'show'])->name('sling.checksheetwire.show');

});




//Checksheet Eyewasher
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/eyewasher/checksheeteyewasher/{eyewasherNumber}', [CheckSheetEyewasherOnlyController::class, 'showForm'])->name('checksheeteyewasher');
    Route::post('/dashboard/eyewasher/process-checksheet-eyewasher/{eyewasherNumber}', [CheckSheetEyewasherOnlyController::class, 'store'])->name('process.checksheet.eyewasher');

    Route::delete('/dashboard/check-sheet/eyewasher/{id}', [CheckSheetEyewasherOnlyController::class, 'destroy'])->name('eyewasher.checksheeteyewasher.destroy');
    Route::get('/dashboard/check-sheet/eyewasher/{id}/edit', [CheckSheetEyewasherOnlyController::class, 'edit'])->name('eyewasher.checksheeteyewasher.edit');
    Route::put('/dashboard/check-sheet/eyewasher/{id}', [CheckSheetEyewasherOnlyController::class, 'update'])->name('eyewasher.checksheeteyewasher.update');
    Route::get('/dashboard/check-sheet/eyewasher/{id}/show', [CheckSheetEyewasherOnlyController::class, 'show'])->name('eyewasher.checksheeteyewasher.show');

});

//Checksheet Eyewasher Shower
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/eyewasher/checksheetshower/{eyewasherNumber}', [CheckSheetEyewasherShowerController::class, 'showForm'])->name('checksheetshower');
    Route::post('/dashboard/eyewasher/process-checksheet-shower/{eyewasherNumber}', [CheckSheetEyewasherShowerController::class, 'store'])->name('process.checksheet.shower');

    Route::delete('/dashboard/check-sheet/eyewasher-show/{id}', [CheckSheetEyewasherShowerController::class, 'destroy'])->name('eyewasher.checksheetshower.destroy');
    Route::get('/dashboard/check-sheet/eyewasher-shower/{id}/edit', [CheckSheetEyewasherShowerController::class, 'edit'])->name('eyewasher.checksheetshower.edit');
    Route::put('/dashboard/check-sheet/eyewasher-shower/{id}', [CheckSheetEyewasherShowerController::class, 'update'])->name('eyewasher.checksheetshower.update');
    Route::get('/dashboard/check-sheet/eyewasher-shower/{id}/show', [CheckSheetEyewasherShowerController::class, 'show'])->name('eyewasher.checksheetshower.show');

});


//Checksheet CO2

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/co2/checksheetco2/{co2Number}', [CheckSheetTabungCo2Controller::class, 'createForm'])->name('checksheettabungco2');
    Route::post('/dashboard/co2/process-checksheet-co2/{tabungNumber}', [CheckSheetTabungCo2Controller::class, 'store'])->name('process.checksheet.tabungco2');

    Route::delete('/dashboard/check-sheet/co2/{id}', [CheckSheetTabungCo2Controller::class, 'destroy'])->name('co2.checksheetco2.destroy');
    Route::get('/dashboard/check-sheet/co2/{id}/edit', [CheckSheetTabungCo2Controller::class, 'edit'])->name('co2.checksheetco2.edit');
    Route::put('/dashboard/check-sheet/co2/{id}', [CheckSheetTabungCo2Controller::class, 'update'])->name('co2.checksheetco2.update');
    Route::get('/dashboard/check-sheet/co2/{id}/show', [CheckSheetTabungCo2Controller::class, 'show'])->name('co2.checksheetco2.show');

});


// Untuk Checksheet Nitrogen
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/nitrogen/checksheetnitrogen/{nitrogenNumber}', [CheckSheetNitrogenServerController::class, 'createForm'])->name('checksheetnitrogen');
    Route::post('/dashboard/hydrant/process-checksheet-nitrogen/{tabungNumber}', [CheckSheetNitrogenServerController::class, 'store'])->name('process.checksheet.nitrogen');

    Route::delete('/dashboard/check-sheet/nitrogen/{id}', [CheckSheetNitrogenServerController::class, 'destroy'])->name('nitrogen.checksheetnitrogen.destroy');
    Route::get('/dashboard/check-sheet/nitrogen/{id}/edit', [CheckSheetNitrogenServerController::class, 'edit'])->name('nitrogen.checksheetnitrogen.edit');
    Route::put('/dashboard/check-sheet/nitrogen/{id}', [CheckSheetNitrogenServerController::class, 'update'])->name('nitrogen.checksheetnitrogen.update');
    Route::get('/dashboard/check-sheet/nitrogen/{id}/show', [CheckSheetNitrogenServerController::class, 'show'])->name('nitrogen.checksheetnitrogen.show');

});


use App\Http\Controllers\CheckSheetHydrantIndoorController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/hydrant/checksheetindoor/{hydrantNumber}', [CheckSheetHydrantIndoorController::class, 'showForm'])->name('checksheetindoor');
    Route::post('/dashboard/hydrant/process-checksheet-hydrant-indoor/{hydrantNumber}', [CheckSheetHydrantIndoorController::class, 'store'])->name('process.checksheet.indoor');

    Route::delete('/dashboard/check-sheet/hydrantindoor/{id}', [CheckSheetHydrantIndoorController::class, 'destroy'])->name('hydrant.checksheetindoor.destroy');
    Route::get('/dashboard/check-sheet/hydrantindoor/{id}/edit', [CheckSheetHydrantIndoorController::class, 'edit'])->name('hydrant.checksheetindoor.edit');
    Route::put('/dashboard/check-sheet/hydrantindoor/{id}', [CheckSheetHydrantIndoorController::class, 'update'])->name('hydrant.checksheetindoor.update');
    Route::get('/dashboard/check-sheet/hydrantindoor/{id}/show', [CheckSheetHydrantIndoorController::class, 'show'])->name('hydrant.checksheetindoor.show');

});


use App\Http\Controllers\CheckSheetHydrantOutdoorController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/hydrant/checksheetoutdoor/{hydrantNumber}', [CheckSheetHydrantOutdoorController::class, 'showForm'])->name('checksheetoutdoor');
    Route::post('/dashboard/hydrant/process-checksheet-hydrant-outdoor/{hydrantNumber}', [CheckSheetHydrantOutdoorController::class, 'store'])->name('process.checksheet.outdoor');

    Route::delete('/dashboard/check-sheet/hydrantoutdoor/{id}', [CheckSheetHydrantOutdoorController::class, 'destroy'])->name('hydrant.checksheetoutdoor.destroy');
    Route::get('/dashboard/check-sheet/hydrantoutdoor/{id}/edit', [CheckSheetHydrantOutdoorController::class, 'edit'])->name('hydrant.checksheetoutdoor.edit');
    Route::put('/dashboard/check-sheet/hydrantoutdoor/{id}', [CheckSheetHydrantOutdoorController::class, 'update'])->name('hydrant.checksheetoutdoor.update');
    Route::get('/dashboard/check-sheet/hydrantoutdoor/{id}/show', [CheckSheetHydrantOutdoorController::class, 'show'])->name('hydrant.checksheetoutdoor.show');

});


use App\Http\Controllers\CheckSheetCo2Controller;

// Menggunakan middleware auth untuk routes terkait checksheetco2
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/check-sheet/aparco2/{tagNumber}', [CheckSheetCo2Controller::class, 'showForm'])->name('checksheetco2');
    Route::post('/dashboard/apar/process-checksheet-co2-af11e/{tagNumber}', [CheckSheetCo2Controller::class, 'store'])->name('process.checksheet.co2');

    Route::delete('/dashboard/check-sheet/aparco2/{id}', [CheckSheetCo2Controller::class, 'destroy'])->name('apar.checksheetco2.destroy');
    Route::get('/dashboard/check-sheet/aparco2/{id}/edit', [CheckSheetCo2Controller::class, 'edit'])->name('apar.checksheetco2.edit');
    Route::put('/dashboard/check-sheet/aparco2/{id}', [CheckSheetCo2Controller::class, 'update'])->name('apar.checksheetco2.update');
    Route::get('/dashboard/check-sheet/aparco2/{id}/show', [CheckSheetCo2Controller::class, 'show'])->name('apar.checksheetco2.show');

});

use App\Http\Controllers\CheckSheetPowderController;

// Menggunakan middleware auth untuk routes terkait checksheetpowder
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/check-sheet/aparpowder/{tagNumber}', [CheckSheetPowderController::class, 'showForm'])->name('checksheetpowder');
    Route::post('/dashboard/apar/process-checksheet-powder/{tagNumber}', [CheckSheetPowderController::class, 'store'])->name('process.checksheet.powder');

    Route::delete('/dashboard/check-sheet/aparpowder/{id}', [CheckSheetPowderController::class, 'destroy'])->name('apar.checksheetpowder.destroy');
    Route::get('/dashboard/check-sheet/aparpowder/{id}/edit', [CheckSheetPowderController::class, 'edit'])->name('apar.checksheetpowder.edit');
    Route::put('/dashboard/check-sheet/aparpowder/{id}', [CheckSheetPowderController::class, 'update'])->name('apar.checksheetpowder.update');
    Route::get('/dashboard/check-sheet/aparpowder/{id}/show', [CheckSheetPowderController::class, 'show'])->name('apar.checksheetpowder.show');
});

use App\Http\Controllers\AparReportController;
use App\Http\Controllers\CheckSheetBodyHarnestController;

Route::get('/apar-report', [AparReportController::class, 'index'])->name('apar.report')->middleware('auth');

use App\Http\Controllers\CombinedAparController;
use App\Http\Controllers\CombinedHydrantController;
use App\Models\CheckSheetEyewasher;

Route::get('/dashboard/report/apar', [CombinedAparController::class, 'index'])->name('home.checksheet.apar')->middleware('auth');
Route::get('/dashboard/report/hydrant', [CombinedHydrantController::class, 'index'])->name('home.checksheet.hydrant')->middleware('auth');
Route::get('/dashboard/report/nitrogen', [CheckSheetNitrogenServerController::class, 'report'])->name('home.checksheet.nitrogen')->middleware('auth');
Route::get('/dashboard/report/co2', [CheckSheetTabungCo2Controller::class, 'report'])->name('home.checksheet.co2')->middleware('auth');
Route::get('/dashboard/report/tandu', [CheckSheetTanduController::class, 'report'])->name('home.checksheet.tandu')->middleware('auth');
Route::get('/dashboard/report/eyewasher', [CheckSheetEyewasherController::class, 'report'])->name('home.checksheet.eyewasher')->middleware('auth');
Route::get('/dashboard/report/sling', [CheckSheetSlingController::class, 'report'])->name('home.checksheet.sling')->middleware('auth');
Route::get('/dashboard/report/tembin', [CheckSheetTembinController::class, 'report'])->name('home.checksheet.tembin')->middleware('auth');
Route::get('/dashboard/report/chainblock', [CheckSheetChainblockController::class, 'report'])->name('home.checksheet.chainblock')->middleware('auth');








// Menggunakan middleware auth untuk routes terkait checksheethydrantindoor
Route::middleware(['auth'])->group(function () {
    Route::get('/checksheethydrantindoor', function () {
        return view('dashboard.checkSheet.checkHydrantIndoor');
    })->name('checksheet.hydrantindoor');

    Route::post('/dashboard/apar/process-checksheet-hydrantindoor', [CheckSheetHydrantIndoorController::class, 'store'])->name('process.checksheet.hydrantindoor');
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

// Check Profil & Change Password
Route::get('/dashboard/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/dashboard/profile', [ProfileController::class, 'changePassword'])->middleware('auth');

// Export Checksheet Apar
Route::post('/export-checksheet-co2', [CheckSheetCo2Controller::class, 'exportExcelWithTemplate'])->name('export.checksheetsco2');
Route::post('/export-checksheet-powder', [CheckSheetPowderController::class, 'exportExcelWithTemplate'])->name('export.checksheetspowder');
Route::post('/export-checksheet-apar', [CombinedAparController::class, 'exportExcelWithTemplate'])->name('export.checksheetsapar');


// Export Checksheet Hydrant
Route::post('/export-checksheet-indoor', [CheckSheetHydrantIndoorController::class, 'exportExcelWithTemplate'])->name('export.checksheetsindoor');
Route::post('/export-checksheet-outdoor', [CheckSheetHydrantOutdoorController::class, 'exportExcelWithTemplate'])->name('export.checksheetsoutdoor');
Route::post('/export-checksheet-hydrant', [CombinedHydrantController::class, 'exportExcelWithTemplate'])->name('export.checksheetshydrant');

// Export CheckSheet Nitrogen
Route::post('/export-checksheet-nitrogen', [CheckSheetNitrogenServerController::class, 'exportExcelWithTemplate'])->name('export.checksheetsnitrogen');

// Export CheckSheet Co2
Route::post('/export-checksheet-tabung-co2', [CheckSheetTabungCo2Controller::class, 'exportExcelWithTemplate'])->name('export.checksheetstabung.co2');

// Export CheckSheet Tandu
Route::post('/export-checksheet-tandu', [CheckSheetTanduController::class, 'exportExcelWithTemplate'])->name('export.checksheetstandu');

// Export Checksheet Eyewasher
Route::post('/export-checksheet-eyewasher', [CheckSheetEyewasherOnlyController::class, 'exportExcelWithTemplate'])->name('export.checksheetseyewasher');
Route::post('/export-checksheet-eyewasher-shower', [CheckSheetEyewasherShowerController::class, 'exportExcelWithTemplate'])->name('export.checksheetsshower');
Route::post('/export-checksheet-report-eyewasher', [CheckSheetEyewasherController::class, 'exportExcelWithTemplate'])->name('export.checksheetsreport.eyewasher');

// Export Checksheet Sling
Route::post('/export-checksheet-wire', [CheckSheetSlingWireController::class, 'exportExcelWithTemplate'])->name('export.checksheetswire');
Route::post('/export-checksheet-belt', [CheckSheetSlingBeltController::class, 'exportExcelWithTemplate'])->name('export.checksheetsbelt');
Route::post('/export-checksheet-report-sling', [CheckSheetSlingController::class, 'exportExcelWithTemplate'])->name('export.checksheetsreport.sling');

// Export CheckSheet Tembin
Route::post('/export-checksheet-tembin', [CheckSheetTembinController::class, 'exportExcelWithTemplate'])->name('export.checksheetstembin');

// Export CheckSheet Chain Block
Route::post('/export-checksheet-chainblock', [CheckSheetChainblockController::class, 'exportExcelWithTemplate'])->name('export.checksheetschainblock');

// Export CheckSheet Body Harnest
Route::post('/export-checksheet-bodyharnest', [CheckSheetBodyHarnestController::class, 'exportExcelWithTemplate'])->name('export.checksheetsbodyharnest');
