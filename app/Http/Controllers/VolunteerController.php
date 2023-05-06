<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $eventLocations = UserEventLocation::all();
        return view('admin.propose-event.index', compact('eventLocations',));
    }

//    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
//    {
//
//        $size_volunteers = SizeVolunteers::all();
//        $regions = Region::all();
//
//        return view('admin.event.create', compact('regions', 'size_volunteers'));
//    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
//dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'region_id' => 'required',
            'city_id' => 'required',
            'terms_site' => 'required',
            'terms_workshop' => 'required',
            'volunteering_contract' => 'required',
            'users_event_location_id' => 'required',
        ]);
//        dd($request->all());
//        dd($request->all());

        $eventLocation = EventRegistration::create($validatedData);
        return redirect()->route('home.home');
    }

//    public function show(EventLocation $eventLocation): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
//    {
////        return view('event-locations.show', compact('eventLocation'));
//        dd('show');
//    }

//    public function edit(EventLocation $event_location): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
//    {
//        $size_volunteers = SizeVolunteers::all();
//        $regions = Region::all();
//
//        $event_location = EventLocation::with('city')->findOrFail($event_location->id);
//
//        return view('admin.event.edit', compact('event_location', 'regions', 'size_volunteers'));
//    }

//    public function update(Request $request, EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
//    {
//        $validatedData = $request->validate([
////            'name' => 'required',
//            'cities_id' => 'required',
//            'user_id' => 'required',
//            'longitude' => 'required',
//            'latitude' => 'required',
//            'relief_type' => 'required',
////            'status' => 'required',
//        ]);
//
//        $eventLocation->update($validatedData);
//
//        return redirect()->route('event-locations.index');
//    }
//
//    public function destroy(EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
//    {
//        $eventLocation->delete();
//
//        return redirect()->route('event-locations.index');
//    }
}
