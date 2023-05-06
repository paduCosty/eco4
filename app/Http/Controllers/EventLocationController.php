<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\EventLocation;
use App\Models\Region;
use App\Models\SizeVolunteers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventLocationController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $events = EventLocation::paginate(10);

        return view('admin.event.index', compact('events'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {

        $size_volunteers = SizeVolunteers::all();
        $regions = Region::all();

        return view('admin.event.create', compact('regions', 'size_volunteers'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user_id = Auth::id();

        if (!$user_id) {
            redirect()->route('event-locations.index');
        }

        $validatedData = $request->validate([
            'cities_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'relief_type' => 'required',
            'size_volunteer_id' => 'required',
        ]);
        $validatedData['user_id'] = $user_id;
        $eventLocation = EventLocation::create($validatedData);

        return redirect()->route('event-locations.index');
    }

    public function show(EventLocation $eventLocation): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
//        return view('event-locations.show', compact('eventLocation'));
        dd('show');
    }

    public function edit(EventLocation $event_location): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $size_volunteers = SizeVolunteers::all();
        $city = City::select('id', 'name', 'region_id')->where('id', $event_location->cities_id)
            ->first();
        $region = Region::select('id', 'name')->where('id', $city->region_id)->first();

        $event_location = EventLocation::with('city')->findOrFail($event_location->id);

        return view('admin.event.edit',
            compact(
                'event_location',
                'region',
                'city',
                'size_volunteers',
            )
        );
    }

    public function update(Request $request, EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
    {
        $user_id = Auth::id();

        if (!$user_id) {
            redirect()->route('event-locations.index');
        }
        $validatedData = $request->validate([
            'cities_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'relief_type' => 'required',
            'size_volunteer_id' => 'required',
        ]);

        $validatedData['user_id'] = $user_id;
        $eventLocation->update($validatedData);

        return redirect()->route('event-locations.index');
    }

    public function destroy(EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
    {
        $eventLocation->delete();

        return redirect()->route('event-locations.index');
    }

    public function get_event_locations(Request $request)
    {
        if ($request->city_id) {
            $event_locations = EventLocation::where('cities_id', $request->city_id)
                ->get();
            $city = City::where('id', $request->city_id)->first();

            return response()->json(['event_locations' => $event_locations, 'city' => $city]);
        }
        return response()->json(['message' => false]);
    }
}
