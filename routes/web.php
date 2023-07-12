<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventLocationController;
use App\Http\Controllers\NetopiaController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProposeEventController;
use App\Http\Controllers\VolunteerController;
use App\Services\ApiApplicationTermsService;
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

Route::get('/sitemap.xml', [ProposeEventController::class, 'sitemap_xml']);

Route::middleware(['auth'])->group(function () {
    Route::post('propose-locations/update-unfolded-event/{userEventLocation}', [ProposeEventController::class, 'update_unfolded_event']);
});

Route::middleware(['auth', 'user_role'])->group(function () {
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
        Route::get('approve-or-decline-propose-event/{location_id}', [ProposeEventController::class, 'approve_or_decline_propose_event'])
            ->name('admin.approve_or_decline_propose_event');

        /*Ajax volunteers*/
        Route::get('/volunteers/{event_location_id}', [VolunteerController::class, 'index']);
        Route::post('/mail_to_volunteers/{event_location_id}', [VolunteerController::class, 'mail_to_volunteers']);


    });
});

Route::middleware('coordinator')->group(function () {
    Route::prefix('coordinator')->group(function () {
        Route::post('propose-locations/update/{userEventLocation}', [ProposeEventController::class, 'update']);

        Route::get('/propose-locations/', [ProposeEventController::class, 'index'])->name('coordinator.event');
        Route::get('/propose-locations/{userEventLocation}', [ProposeEventController::class, 'show'])
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


Route::get('/home', [ProposeEventController::class, 'home'])->name('home');
Route::get('/', [ProposeEventController::class, 'home'])->name('/');
Route::get('/event/{id}', [ProposeEventController::class, 'home'])->name('share_link.modal');


/*ajax calls  event locations*/
Route::get('get-event-locations/{city_id}', [EventLocationController::class, 'get_event_locations'])
    ->name('get-event-locations.get_event_locations');
Route::post('/home/store', [ProposeEventController::class, 'store'])->name('home.store');

Route::get('get-event-location/{userEventLocation}', [EventLocationController::class, 'get_event_location_by_id']);
Route::get('/generate-represent-unique-url/{userEventLocation}', [ProposeEventController::class, 'generate_unique_url']);

Route::get('/take-number-of-events-by-region/{region_id}', [ProposeEventController::class, 'count_events_by_regions_id']);

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
Route::get('get-contract-terms',[ApiApplicationTermsService::class, 'get_contract_terms']);
Route::get('get-privacy-terms',[ApiApplicationTermsService::class, 'get_privacy_terms']);
Route::get('get-terms-site',[ApiApplicationTermsService::class, 'get_terms_site']);
/*TERMS AND CONDITIONS END*/

require __DIR__ . '/auth.php';

