<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\EventLocation;
use App\Models\Region;
use App\Models\SizeVolunteers;
use App\Models\UserEventLocation;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
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

        return view('partners.locations.index',
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
            redirect()->route('locations.index');
        }

        $validatedData = $request->validate([
            'cities_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'address' => 'required',
            'relief_type' => 'required',
            'size_volunteer_id' => 'required',
        ]);

        $crm_size_volunteers = json_decode(Http::get(env('LOGIN_URL') . '/get_volunteer_options')->getBody());
        if ($crm_size_volunteers) {
            foreach ($crm_size_volunteers as $key => $seize) {
                SizeVolunteers::where('required_volunteer_level', $key)->update(['name' => $seize]);
            }
        }

        $validatedData['user_id'] = $user_id;

        EventLocation::create($validatedData);

        return redirect()->route('locations.index')
            ->with('success', 'Locul de ecologizare a fost creat cu succes!');
    }

    public function update(Request $request, EventLocation $location): \Illuminate\Http\RedirectResponse
    {
        $user_id = Auth::id();

        if (!$user_id) {
            redirect()->route('locations.index');
        }
        $validatedData = $request->validate([
            'longitude' => 'required',
            'latitude' => 'required',
            'address' => 'required',
            'relief_type' => 'required',
            'size_volunteer_id' => 'required',
        ]);

        $location->update($validatedData);

        return redirect()->route('locations.index')
            ->with('success', 'Locul de ecologizare a fost editat cu succes!');
    }

    public function destroy(EventLocation $location): \Illuminate\Http\RedirectResponse
    {
        if (Auth::check()) {
            $location->delete();
            return redirect()->route('locations.index')
                ->with('success', 'Locul de ecologizare a fost șters cu succes!');
        }
        return redirect()->route('locations.index')
            ->with('error', 'Nu ai acces pentru a face aceasta actiune');
    }

    public function show(EventLocation $location)
    {
        if ($location) {
            $data = [
                'id' => $location->id,
                'longitude' => $location->longitude,
                'latitude' => $location->latitude,
                'address' => $location->address,
                'relief_type' => $location->relief_type,
                'city_name' => $location->city->name,
                'region_name' => $location->city->region->name,
                'size_volunteer_name' => $location->sizeVolunteer->name . '(' . $location->sizeVolunteer->required_volunteer_level . ')',
                'status' => $location->status,
            ];
            return response()->json(['message' => 'success', 'status' => true, 'data' => $data]);
        }
        return response()->json(['message' => 'A lcatia nu a fost gasita', 'status' => false]);
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
