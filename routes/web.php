<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\EventLocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposeEventController;
use App\Http\Controllers\VolunteerController;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware(['auth', 'role:admin'])->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

/*admin prefix*/
Route::prefix('admin')->group(function () {
    Route::resource('event-locations', EventLocationController::class);
    Route::get('/propose-locations', [ProposeEventController::class, 'index'])->name('admin.propose-locations.home');
    /*ajax calls city*/
    Route::get('get-cities', [CityController::class, 'index'])->name('admin.get-cities.index');
});
//});

/*ajax calls city*/
Route::get('/cities-if-event-exists', [CityController::class, 'get_cities_by_event_locations'])
    ->name('cities-if-event-exists.get_cities_by_event_locations');

Route::get('/approved-events/{city_id}', [CityController::class, 'approved_events'])
    ->name('approved-events.approved_events');

Route::get('/cities_by_region_id', [CityController::class, 'get_cities_by_region_id'])
    ->name('cities_by_region_id.get_cities_by_region_id');
/*ajax calls city END*/


/*ajax calls  event locations*/
Route::get('get-event-locations/{city_id}', [EventLocationController::class, 'get_event_locations'])
    ->name('get-event-locations.get_event_locations');

Route::get('/', [ProposeEventController::class, 'home'])->name('home.home');
Route::post('/home', [ProposeEventController::class, 'store'])->name('home.store');
/*ajax calls  event locations END*/

/*Ajax volunteer*/
Route::post('/volunteer_registration', [VolunteerController::class, 'store'])
    ->name('volunteer_registration.store');

/*Ajax volunteer END*/

require __DIR__ . '/auth.php';

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
