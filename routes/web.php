<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NetopiaController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VolunteerController;
use App\Services\ApiApplicationService;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Response;


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

Route::get('/sitemap.xml', [EventController::class, 'sitemap_xml']);

Route::middleware(['auth'])->group(function () {
    Route::post('events/update-unfolded-event/{userEventLocation}', [EventController::class, 'update_unfolded_event']);
    Route::get('events/get-edit-unfolded-event/{userEventLocation}', [EventController::class, 'get_for_edit_unfolded_event']);
});

Route::middleware(['auth', 'user_role'])->group(function () {
    /*admin prefix*/
    Route::prefix('admin')->group(function () {
        Route::resource('locations', LocationController::class);
        Route::post('locations/update/{location}', [LocationController::class, 'update']);


        Route::resource('events', EventController::class)->parameters([
            'events' => 'userEventLocation'
        ]);
        Route::post('events/update/{userEventLocation}', [EventController::class, 'update']);

//        Route::get('/events', [EventController::class, 'index'])->name('admin.events.home');
        /*ajax calls city*/
        Route::get('approve-or-decline-propose-event/{location_id}', [EventController::class, 'approve_or_decline_propose_event'])
            ->name('admin.approve_or_decline_propose_event');

        /*Ajax volunteers*/
        Route::get('/volunteers/{event_location_id}', [VolunteerController::class, 'index']);
        Route::post('/mail_to_volunteers/{event_location_id}', [VolunteerController::class, 'mail_to_volunteers']);


    });
});

Route::middleware('coordinator')->group(function () {
    Route::prefix('coordinator')->group(function () {
        Route::post('events/update/{userEventLocation}', [EventController::class, 'update']);

        Route::get('/events/', [EventController::class, 'index'])->name('coordinator.event');
        Route::get('/events/{userEventLocation}', [EventController::class, 'show'])
            ->name('coordinator.show');
        Route::get('/volunteers/{event_location_id}', [VolunteerController::class, 'index']);
        Route::post('/mail_to_volunteers/{event_location_id}', [VolunteerController::class, 'mail_to_volunteers']);
    });

});


/*ajax calls city*/
Route::get('get-cities', [CityController::class, 'index'])->name('admin.get-cities.index');

Route::get('/cities-if-event-exists', [CityController::class, 'get_cities_by_event_locations'])
    ->name('cities-if-event-exists.get_cities_by_event_locations');

Route::get('/approved-events/{region_id}', [CityController::class, 'approved_events'])
    ->name('approved-events.approved_events');

//Route::get('/approved-events', [CityController::class, 'approved_events'])
//    ->name('approved-events');

Route::get('/cities_by_region_id', [CityController::class, 'get_cities_by_region_id'])
    ->name('cities_by_region_id.get_cities_by_region_id');

Route::get('/get-cities-if-propose-event-exists', [CityController::class, 'get_cities_with_propose_event_by_region_id']);
/*ajax calls city END*/


Route::get('/home', [EventController::class, 'home'])->name('home');
Route::get('/', [EventController::class, 'home'])->name('/');
Route::get('/event/{id}', [EventController::class, 'home'])->name('share_link.modal');


/*ajax calls  event locations*/
Route::get('get-locations/{city_id}', [LocationController::class, 'get_event_locations'])
    ->name('get-locations.get_event_locations');
Route::post('/home/store', [EventController::class, 'store'])->name('home.store');

Route::get('get-event-location/{userEventLocation}', [LocationController::class, 'get_event_location_by_id']);
Route::get('/generate-represent-unique-url/{userEventLocation}', [EventController::class, 'generate_unique_url']);

Route::get('/take-number-of-events-by-region/{region_id}', [EventController::class, 'count_events_by_regions_id']);

/*ajax calls  event locations END*/

/*Ajax volunteer*/
Route::post('/volunteer_registration', [VolunteerController::class, 'store'])
    ->name('volunteer_registration.store');

/*Ajax volunteer END*/

Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send');


/*pay pall routes START*/
Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
/*pay pall routes END*/

/*NETOPIA Payments START*/
Route::get('process-netopia-transaction', [NetopiaController::class, 'index'])->name('netopiaTransaction');
/*NETOPIA Payments END*/

/*TERMS AND CONDITIONS START*/
Route::get('get-contract-terms', [ApiApplicationService::class, 'get_contract_terms']);
Route::get('get-privacy-terms', [ApiApplicationService::class, 'get_privacy_terms']);
Route::get('get-terms-site', [ApiApplicationService::class, 'get_terms_site']);
Route::get('get-app-details-from-crm', [ApiApplicationService::class, 'get_app_details_from_crm']);
/*TERMS AND CONDITIONS END*/

require __DIR__ . '/auth.php';

