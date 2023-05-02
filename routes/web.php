<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\EventLocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposeEventController;
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

Route::get('/', function () {
    return view('welcome');
});

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

    /*ajax calls city*/
    Route::get('/cities-if-event-exists', [CityController::class, 'get_cities_by_event_locations'])
        ->name('cities-if-event-exists.get_cities_by_event_locations');
    //});

/*ajax calls  event locations*/
Route::get('get-event-locations/{city_id}', [EventLocationController::class, 'get_event_locations'])
    ->name('get-event-locations.get_event_locations');

Route::get('/home', [ProposeEventController::class, 'home'])->name('home.home');
Route::post('/home', [ProposeEventController::class, 'store'])->name('home.store');

require __DIR__.'/auth.php';

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
