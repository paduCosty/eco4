<?php

namespace App\Http\Controllers;

use App\Mail\ProposeEventMail;
use App\Models\City;
use App\Models\EventLocation;
use App\Models\Region;
use App\Models\UserEventLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProposeEventController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $eventLocations = UserEventLocation::withCount('eventRegistrations')
            ->orderBy('id', 'DESC')
            ->paginate(10);
//        dd($eventLocations->toArray());
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

        session()->flash('success', 'Datele au fost salvate cu succes!');
        return redirect()->route('home.home');
    }

//    public function show(UserEventLocation $location): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
//    {
////        return view('event-locations.show', compact('eventLocation'));
//        dd($location->id);
//    }

    public function edit(UserEventLocation $userEventLocation)
    {

//        dd($userEventLocation->id);

//
//        $user = EventLocation::first();
        return view('admin.propose-event.edit', compact(
            'userEventLocation'
        ));
    }

    public function update(Request $request, UserEventLocation $userEventLocation): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'due_date' => 'required',
            'status' => 'required',

        ]);

        $userEventLocation->update($validatedData);

        return redirect()->route('propose-locations.index');
    }

    public function destroy(UserEventLocation $eventLocation): \Illuminate\Http\RedirectResponse
    {
        dd($eventLocation->id);
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

            if ($userEventLocation && $request->val && $request->val != $userEventLocation->status) {
                $userEventLocation->status = $request->val;
                $userEventLocation->save();

                $mailData = [
                    'title' => 'Mail from ItSolutionStuff.com',
                    'body' => 'This is for testing email using smtp.',
                    'propose_event_status' => $userEventLocation->status
                ];

                $result = Mail::to($userEventLocation->email)->send(new ProposeEventMail($mailData));

                if ($result) {
                    $response['email'] = 'Email-ul a fost trimis cu succes';
                } else {
                    $response['email'] = false;
                }
                $response = [
                    'success' => true,
                    'status' => ucfirst($userEventLocation->status)
                ];
                return response()->json($response);
            }
        }
        return response()->json(['success' => false]);
    }

}
