<?php

namespace App\Http\Controllers;

use App\Models\EventLocation;
use App\Models\Region;
use App\Models\UserEventLocation;
use Illuminate\Http\Request;

class ProposeEventController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $eventLocations = UserEventLocation::all();
        return view('admin.propose-event.index', compact('eventLocations', ));
    }
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {

        $size_volunteers = SizeVolunteers::all();
        $regions = Region::all();

        return view('admin.event.create', compact('regions', 'size_volunteers'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'event_location_id' => 'required',
            'due_date' => 'required',
            'terms_site' => 'required',
            'terms_workshop' => 'required',
            'volunteering_contract' => 'required',
        ]);
//        dd($request->all());

        $eventLocation = UserEventLocation::create($validatedData);

        return redirect()->route('home.home');
    }

    public function show(EventLocation $eventLocation): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
//        return view('event-locations.show', compact('eventLocation'));
        dd('show');
    }

    public function edit(EventLocation $event_location): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $size_volunteers = SizeVolunteers::all();
        $regions = Region::all();

        $event_location = EventLocation::with('city')->findOrFail($event_location->id);

        return view('admin.event.edit', compact('event_location', 'regions', 'size_volunteers'));
    }

    public function update(Request $request, EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
//            'name' => 'required',
            'cities_id' => 'required',
            'user_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'relief_type' => 'required',
//            'status' => 'required',
        ]);

        $eventLocation->update($validatedData);

        return redirect()->route('event-locations.index');
    }

    public function destroy(EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
    {
        $eventLocation->delete();

        return redirect()->route('event-locations.index');
    }

    public function home(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $events = EventLocation::all();
        $regions = Region::all();
        return view('propose-event.index', compact('events', 'regions'));
    }

}
