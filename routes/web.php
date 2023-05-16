<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\EventLocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposeEventController;
use App\Http\Controllers\VolunteerController;
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
Route::middleware(['auth', 'role:user'])->group(function () {
    /*admin prefix*/
    Route::prefix('admin')->group(function () {
        Route::resource('event-locations', EventLocationController::class);
        Route::post('event-locations/update/{eventLocation}', [EventLocationController::class, 'update']);


        Route::resource('propose-locations', ProposeEventController::class)->parameters([
            'propose-locations' => 'userEventLocation'
        ]);
        Route::post('propose-locations/update/{userEventLocation}', [ProposeEventController::class, 'update']);

//        Route::get('/propose-locations', [ProposeEventController::class, 'index'])->name('admin.propose-locations.home');

        /*ajax calls city*/
        Route::get('get-cities', [CityController::class, 'index'])->name('admin.get-cities.index');
        Route::get('approve-or-decline-propose-event/{location_id}', [ProposeEventController::class, 'approve_or_decline_propose_event'])
            ->name('admin.approve_or_decline_propose_event');
    });
});

/*ajax calls city*/
Route::get('/cities-if-event-exists', [CityController::class, 'get_cities_by_event_locations'])
    ->name('cities-if-event-exists.get_cities_by_event_locations');

Route::get('/approved-events/{city_id}', [CityController::class, 'approved_events'])
    ->name('approved-events.approved_events');

Route::get('/cities_by_region_id', [CityController::class, 'get_cities_by_region_id'])
    ->name('cities_by_region_id.get_cities_by_region_id');

Route::get('/get-cities-if-propose-event-exists', [CityController::class, 'get_cities_with_propose_event_by_region_id']);
/*ajax calls city END*/


/*ajax calls  event locations*/
Route::get('get-event-locations/{city_id}', [EventLocationController::class, 'get_event_locations'])
    ->name('get-event-locations.get_event_locations');

Route::get('/home', [ProposeEventController::class, 'home'])->name('home');
Route::get('/', [ProposeEventController::class, 'home']);

Route::post('/home/store', [ProposeEventController::class, 'store'])->name('home.store');
/*ajax calls  event locations END*/

/*Ajax volunteer*/
Route::post('/volunteer_registration', [VolunteerController::class, 'store'])
    ->name('volunteer_registration.store');

/*Ajax volunteer END*/

require __DIR__ . '/auth.php';

