<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\ProposeEventMail;
use App\Models\EventLocation;
use App\Models\Region;
use App\Models\SizeVolunteers;
use App\Models\User;
use App\Models\UserEventLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use mysql_xdevapi\Exception;
use Vinkla\Hashids\Facades\Hashids;

class ProposeEventController extends Controller
{

    public function sitemap_xml()
    {

        $approved_events = UserEventLocation::where('users_event_locations.status', 'aprobat')->get();
        dump($approved_events[0]->url);

        return response()->view('index', [
            'posts' => $approved_events
        ])->header('Content-Type', 'text/xml');
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $eventLocations = UserEventLocation::withCount('eventRegistrations');

            if (Auth::user()->role == 'partner') {
                $eventLocations = $eventLocations->whereHas('eventLocation', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                });
            }

            if (Auth::user()->role == 'coordinator') {
                $eventLocations = $eventLocations->where('coordinator_id', $user_id);
            }

            $eventLocations = $eventLocations->orderBy('id', 'DESC')
                ->paginate(10);
        }


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

            'description' => 'required',
            'event_location_id' => 'required',
            'due_date' => 'required',
            'terms_site' => 'required',
            'terms_workshop' => 'required',
            'volunteering_contract' => 'required',
        ]);

        if (Auth::check()) {
            $validatedData['coordinator_id'] = Auth::user()->id;
        } else {

            $validatedData += $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'phone' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
                'gender' => 'required',
            ]);

            try {
                $response = Http::asForm()->post(env('LOGIN_URL') . 'register', [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'pass' => $request['password'],
                    'gender' => $request['gender']
                ]);

            } catch (\PharIo\Version\Exception) {
                return redirect()->route('home')->withErrors([
                    'error' => 'Inregistrarea  ta a esuat.',
                ]);
            }
            if ($response->body() === "1") {

                /*login in created user and update propose event with coordinator_id */
                $auth_controller = new AuthenticatedSessionController;
                $data = [
                    'email' => $request['email'],
                    'password' => $request['password']
                ];
                $login_request = new LoginRequest($data);
                $auth_controller->store($login_request);

                $validatedData += ['coordinator_id' => Auth::user()->id];
                $eventLocation = UserEventLocation::create($validatedData);

                session()->flash('success', 'Datele au fost salvate cu succes!');
                return redirect()->route('home');
            }
        }

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

        $status = 'Inactive';

        if ($validatedData['status'] == 'aprobat') {
            $status = "Active";
        }

        if ($userEventLocation->crm_propose_event_id) {
            $response = Http::asForm()->post(env('LOGIN_URL') . 'update_action', [
                'Id' => $userEventLocation->crm_propose_event_id,
                'Latitudine' => $userEventLocation->eventLocation->longitude,
                'Longitudine' => $userEventLocation->eventLocation->latitude,
                'Description' => $validatedData['description'],
                'JudetID' => $userEventLocation->eventLocation->city->region_id,
                'LocationID' => $userEventLocation->eventLocation->cities_id,
                'Number' => $userEventLocation->eventLocation->size_volunteer_id,
                'Date' => $validatedData['due_date'],
                'Name' => $validatedData['name'],
                'Status' => $status
            ]);

            if ($response && $response->body() == "Actiune actualizata cu success!") {
                $userEventLocation->update($validatedData);

                session()->flash('success', 'Datele au fost salvate cu succes!');
                return redirect()->route('propose-locations.index');
            }

        } else {
            $userEventLocation->update($validatedData);
            session()->flash('success', 'Datele au fost salvate cu succes!');
            return redirect()->route('propose-locations.index');
        }

        session()->flash('error', 'Datele nu au fost actualizate');
        return redirect()->route('propose-locations.index');
    }

    public function show(UserEventLocation $userEventLocation)
    {

        if ($userEventLocation && Auth::check()) {

            $data = [];

            $user_id = $userEventLocation->eventLocation->user->id;
            try {
                $partner_resp = Http::post(env('LOGIN_URL') . '/get_partners/' . $user_id . '/' . 0 . '/' . 0);
            } catch (Exception) {

                return response()->json(['status' => false, 'error', 'Eroarea la conectare']);

            }

            if ($partner_resp->getStatusCode() == 200 && json_decode($partner_resp->getBody(), true)) {
                $partner = json_decode($partner_resp->getBody(), true)[0];

                $data = [
                    'institution_name' => $partner['name'] ?? '',
                    'institution_phone' => $partner['phone'] ?? '',
                    'institution_email' => $partner['email'] ?? '',

                ];
            }

            $data += [
                'due_date' => $userEventLocation->due_date,
                'description' => $userEventLocation->description,
                'address' => $userEventLocation->eventLocation->address,
                'relief_type' => $userEventLocation->eventLocation->relief_type,
                'size_volunteer_id' => $userEventLocation->eventLocation->sizeVolunteer->name,
                'status' => $userEventLocation->status,
            ];

            return response()->json(['status' => true, 'data' => $data]);

        }
        return response()->json(['status' => false]);

    }

    public function home(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $share_link_data = array();
        if ($request->id) {
            $decrypted = base64_decode(trim($request->id));
            $decrypted = (int)$decrypted;

            $event = UserEventLocation::where('id', $decrypted)
                ->first();

            $share_link_data = [
                'event_id' => $decrypted,
                'region_id' => $event->eventLocation->city->region->id,
            ];
        }

        $count_events = UserEventLocation::where('status', 'aprobat')->count();

        $events_regions = EventLocation::with(['city.region', 'usersEventLocations'])
            ->select('cities_id')
            ->get()
            ->pluck('city.region')
            ->unique();

        $accepted_regions = EventLocation::with(['city.region', 'usersEventLocations'])
            ->select('cities_id')
            ->whereHas('usersEventLocations', function ($query) {
                $query->where('status', 'aprobat');
            })
            ->get()
            ->pluck('city.region')
            ->unique();

        $regions = Region::all();

        return view('propose-event.index', compact('count_events', 'regions', 'events_regions', 'accepted_regions', 'share_link_data'));
    }

    public function approve_or_decline_propose_event(Request $request)
    {
        if ($request->location_id && $request->val) {
            $userEventLocation = UserEventLocation::with('eventLocation.city')
                ->where('id', $request->location_id)
                ->first();

            // check if event exists in crm or not...
            $update_crm = false;
            if (($userEventLocation->crm_propose_event_id && $request->val == 'refuzat') || $request->val == 'aprobat') {
                $update_crm = true;
            }

            $userEventLocationArray = $userEventLocation->toArray();
            if ($userEventLocation && $request->val && $request->val != $userEventLocation->status && $update_crm) {
                $status = '';
                if ($request->val == 'aprobat') {
                    $status = 'Active';
                } else if ($userEventLocationArray['crm_propose_event_id']) {
                    $status = 'Inactive';
                }
                $crm_id = $userEventLocationArray['crm_propose_event_id'];

                //specify type if is create or update
                $action_type = 'add_action';
                if ($crm_id) {
                    $action_type = 'update_action';
                }
                $response = Http::asForm()->post(env('LOGIN_URL') . $action_type, [
                    'id' => $userEventLocationArray['crm_propose_event_id'],
                    'Coordinator' => json_encode(array($userEventLocationArray['coordinator_id'])),
                    'Latitudine' => $userEventLocationArray['event_location']['longitude'],
                    'Longitudine' => $userEventLocationArray['event_location']['latitude'],
                    'Description' => $userEventLocationArray['description'],
                    'JudetID' => $userEventLocationArray['event_location']['city']['region_id'],
                    'LocationID' => $userEventLocationArray['event_location']['cities_id'],
                    'Number' => $userEventLocationArray['event_location']['size_volunteer_id'],
                    'Date' => $userEventLocationArray['due_date'],
                    'Name' => $userEventLocationArray['name'],
                    'Status' => $status
                ]);

                if (is_numeric($response->body())) {
                    $userEventLocation->crm_propose_event_id = intval($response->body());
                } else if ($response->body() != 'Actiune actualizata cu success!') {
                    return response()->json(['success' => false, 'message' => 'Actiunea nu a reusit contacteaza echipa de suport pentru mai multe detalii!']);
                }

                $mailData = [
                    'due_date' => $userEventLocation->due_date,
                    'name' => $userEventLocation->name
                ];

                if ($request->val == 'aprobat') {
                    /* pana se rezolva problema cu mail-ul*/
//                    $result = Mail::to($userEventLocation->user->email)->send(new ProposeEventMail($mailData));
                    $result = true;
                    if ($result) {
                        $response_msg['email'] = 'Email-ul a fost trimis cu succes';
                    } else {
                        $response_msg['email'] = false;
                    }
                }
            }
            $userEventLocation->status = $request->val;
            $userEventLocation->save();

            $response_msg = [
                'success' => true,
                'status' => ucfirst($userEventLocation->status),
                'message' => 'Statusul a fost modificat cu success'
            ];
            return response()->json($response_msg);
        }
        return response()->json(['success' => false, 'message' => 'Actiunea nu a reusit']);
    }

    public function generate_unique_url(UserEventLocation $userEventLocation)
    {
        if ($userEventLocation->id) {

            $encrypted = base64_encode((string)$userEventLocation->id);

            $uniqueUrl = url('/event') . '/' . $encrypted;
            return response()->json(['message' => true, 'uniqueUrl' => $uniqueUrl]);
        }

        return response()->json(['message' => false]);
    }

}
