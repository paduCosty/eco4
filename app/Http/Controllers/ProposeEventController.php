<?php

namespace App\Http\Controllers;

use App\Mail\ProposeEventMail;
use App\Models\City;
use App\Models\EventLocation;
use App\Models\Region;
use App\Models\SizeVolunteers;
use App\Models\UserEventLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ProposeEventController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $eventLocations = UserEventLocation::withCount('eventRegistrations')
            ->orderBy('id', 'DESC')
            ->paginate(10);
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
            'description' => 'required',
            'event_location_id' => 'required',
            'due_date' => 'required',
            'terms_site' => 'required',
            'terms_workshop' => 'required',
            'volunteering_contract' => 'required',
        ]);

        $eventLocation = UserEventLocation::create($validatedData);

        session()->flash('success', 'Datele au fost salvate cu succes!');
        return redirect()->route('home');
    }

    public function update(Request $request, UserEventLocation $userEventLocation): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'status' => 'required',

        ]);

        $userEventLocation->update($validatedData);

        session()->flash('success', 'Datele au fost salvate cu succes!');
        return redirect()->route('propose-locations.index');
    }

    public function home(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $events = EventLocation::all();
        $regions = Region::all();

        return view('propose-event.index', compact('events', 'regions'));
    }

    public function approve_or_decline_propose_event(Request $request)
    {

        if ($request->location_id && $request->val) {
            $userEventLocation = UserEventLocation::with('eventLocation.city')
                ->where('id', $request->location_id)
                ->first();

            if ($userEventLocation && $request->val && $request->val != $userEventLocation->status) {
                if ($request->val == 'aprobat') {
                    $userEventLocationArray = $userEventLocation->toArray();
                    $response = Http::post(env('LOGIN_URL') . 'add_action', [
                        'id' => $userEventLocationArray['crm_propose_event_id'] ?? '',
                        'Latitudine' => $userEventLocationArray['event_location']['longitude'],
                        'Longitudine' => $userEventLocationArray['event_location']['latitude'],
                        'Description' => $userEventLocationArray['description'],
                        'JudetID' => $userEventLocationArray['event_location']['city']['region_id'],
                        'LocationID' => $userEventLocationArray['event_location']['cities_id'],
                        'Number' => $userEventLocationArray['event_location']['size_volunteer_id'],
                        'Date' => $userEventLocationArray['due_date'],
                        'Name' => $userEventLocationArray['name'],
                    ]);

                    if ($response->body()) {
                        $userEventLocation->crm_propose_event_id = intval($response->body());
                    } else {
                        return response()->json(['success' => false]);
                    }
                    $userEventLocation->status = $request->val;
                    $userEventLocation->save();

                    $mailData = [
                        'due_date' => $userEventLocation->due_date,
                        'name' => $userEventLocation->name
                    ];

                    $result = Mail::to($userEventLocation->email)->send(new ProposeEventMail($mailData));

                    if ($result) {
                        $response_msg['email'] = 'Email-ul a fost trimis cu succes';
                    } else {
                        $response_msg['email'] = false;
                    }
                }

                $response_msg = [
                    'success' => true,
                    'status' => ucfirst($userEventLocation->status)
                ];
                return response()->json($response_msg);
            }
        }
        return response()->json(['success' => false]);
    }

}
