<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SizeVolunteers;
use App\Models\City;
use App\Models\EventLocation;
use App\Models\Region;
use App\Models\UserEventLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposeEventController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $eventLocations = UserEventLocation::paginate(10);
        return view('admin.propose-event.index', compact('eventLocations',));
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

    public function show(UserEventLocation $location): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
//        return view('event-locations.show', compact('eventLocation'));
        dd($location);
    }

    public function edit(UserEventLocation $location): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        dd($location->id);

//
        $user = EventLocation::first();
        return view('admin.propose-event.edit', compact('user'));
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
        $approved_cities = City::has('approvedEventLocations')->select('id', 'name')->get();
        $cities = City::all();


//        dd($cities->toArray());
        return view('propose-event.index', compact('events', 'regions', 'approved_cities', 'cities'));
    }

    public function approve_or_decline_propose_event(Request $request)
    {
        if ($request->location_id && $request->val) {
            $userEventLocation = UserEventLocation::where('id', $request->location_id)
                ->first();

            if ($userEventLocation && $request->val) {
                $userEventLocation->status = $request->val;
                $userEventLocation->save();
                return response()->json(['success' => true, 'status' => ucfirst($userEventLocation->status)]);
            }
        }
        return response()->json(['success' => false]);
    }

}
