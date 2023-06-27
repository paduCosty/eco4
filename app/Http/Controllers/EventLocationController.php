<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\EventLocation;
use App\Models\Region;
use App\Models\SizeVolunteers;
use App\Models\UserEventLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventLocationController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $events = EventLocation::withCount('usersEventLocations')
                ->with('city.region')
                ->with('city');

            if (Auth::user()->role != 'admin' && Auth::user()->role == 'partner') {
                $events = $events->where('user_id', $user_id);
            }
            $events = $events
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            redirect()->route('home');
        }

        $size_volunteers = SizeVolunteers::all();
        $regions = Region::all();

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

        $validatedData = $request->validate([
            'cities_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'address' => 'required',
            'relief_type' => 'required',
            'size_volunteer_id' => 'required',
        ]);
        $validatedData['user_id'] = $user_id;

        EventLocation::create($validatedData);

        return redirect()->route('event-locations.index')
            ->with('success', 'Locul de ecologizare a fost creat cu succes!');
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

        $eventLocation->update($validatedData);

        return redirect()->route('event-locations.index')
            ->with('success', 'Locul de ecologizare a fost editat cu succes!');
    }

    public function destroy(EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
    {
        if (Auth::check()) {
            $eventLocation->delete();
            return redirect()->route('event-locations.index')
                ->with('success', 'Locul de ecologizare a fost șters cu succes!');
        }
        return redirect()->route('event-locations.index')
            ->with('error', 'Nu ai acces pentru a face aceasta actiune');
    }

    public function get_event_locations(Request $request)
    {
        if ($request->city_id) {
            $event_locations = EventLocation::with('sizeVolunteer')
                ->where('cities_id', $request->city_id)
                ->get();

            $city = City::where('id', $request->city_id)->first();

            return response()->json(['event_locations' => $event_locations, 'city' => $city]);
        }
        return response()->json(['message' => false]);
    }

    public function get_event_location_by_id(UserEventLocation $userEventLocation)
    {
        if ($userEventLocation) {
            $location_event = [
                'id' => $userEventLocation->id,
                'description' => $userEventLocation->description,
                'region_name' => $userEventLocation->eventLocation->city->region->name,
                'city_name' => $userEventLocation->eventLocation->city->name,
                'lng' => $userEventLocation->eventLocation->longitude,
                'lat' => $userEventLocation->eventLocation->latitude,
                'address' => $userEventLocation->eventLocation->address,
            ];
            return response()->json(['message' => true, 'event' => $location_event]);
        }
        return response()->json(['message' => false]);
    }
}
