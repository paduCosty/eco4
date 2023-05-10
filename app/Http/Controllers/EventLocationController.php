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
        $events = EventLocation::withCount('usersEventLocations')
            ->with('city.region')
            ->with('city')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $size_volunteers = SizeVolunteers::all();
        $regions = Region::all();
//        dd($events->toArray());
        return view('admin.event.index',
            compact('events', 'regions', 'size_volunteers')
        );
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
//        dd($request->all());

        $validatedData = $request->validate([
            'cities_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'address' => 'required',
            'relief_type' => 'required',
            'size_volunteer_id' => 'required',
        ]);
        $validatedData['user_id'] = $user_id;
        $eventLocation = EventLocation::create($validatedData);
        return redirect()->route('event-locations.index')
            ->with('success', 'Locul de ecologizare a fost creat cu succes!');
    }

    public function show(EventLocation $eventLocation): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
//        return view('event-locations.show', compact('eventLocation'));
        dd('show');
    }

    public function edit(EventLocation $event_location): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        dd($event_location->id);
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
            'longitude' => 'required',
            'latitude' => 'required',
            'address' => 'required',
            'relief_type' => 'required',
            'size_volunteer_id' => 'required',
        ]);

        $validatedData['user_id'] = $user_id;
//        dump($validatedData);
//        dd($eventLocation->toArray());

        $eventLocation->update($validatedData);
        return redirect()->route('event-locations.index')
            ->with('success', 'Locul de ecologizare a fost editat cu succes!');
    }

    public function destroy(EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
    {
        $eventLocation->delete();

        return redirect()->route('event-locations.index')
            ->with('success', 'Locul de ecologizare a fost șters cu succes!');
    }

    public function get_event_locations(Request $request)
    {
        if ($request->city_id) {
            $event_locations = EventLocation::with('sizeVolunteer')->where('cities_id', $request->city_id)
                ->get();
            $city = City::where('id', $request->city_id)->first();

//            dd($event_locations[0]->toArray());
            return response()->json(['event_locations' => $event_locations, 'city' => $city]);
        }
        return response()->json(['message' => false]);
    }
}
