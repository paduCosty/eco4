<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\EventDateChangePartnerEmail;
use App\Mail\MailToPartner;
use App\Mail\ProposeEventMail;
use App\Mail\VolunteersMail;
use App\Models\EventLocation;
use App\Models\Region;
use App\Models\SizeVolunteers;
use App\Models\User;
use App\Models\UserEventLocation;
use App\Services\ApiService;
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

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function sitemap_xml()
    {

        $approved_events = UserEventLocation::where('users_event_locations.status', 'aprobat')->get();

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
            }
        }

        $event = UserEventLocation::create($validatedData);
        /*take partner email and name form crm*/
        $partner_data = $this->apiService->getPartnersFromCrm($event->eventLocation->user->id);

        if ($event && isset($partner_data['institution_email'])) {
            /*send mail to partner*/
            Mail::to($partner_data['institution_email'])
                ->send(new MailToPartner(
                    $partner_data['institution_name'] ?? '',
                    $event->due_date,
                    $event->eventLocation->address,
                    $event->user->name, /*coordinator name*/
                    url('/admin/propose-locations')
                ));

        }
        session()->flash('success', 'Datele au fost salvate cu succes!');
        return redirect()->route('home');
    }

    public function update(Request $request, UserEventLocation $userEventLocation): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'description' => 'required',
            'due_date' => 'required',
            'status' => 'required',
        ]);

        $data_modified = false;
        if ($userEventLocation->due_date != $validatedData['due_date']) {
            $data_modified = true;
        }

        /*add to event updated data*/
        $userEventLocation->due_date = $validatedData['due_date'];
        $userEventLocation->description = $validatedData['description'];
        $userEventLocation->status = $validatedData['status'];

        $status = 'Inactive';
        if ($validatedData['status'] == 'aprobat' || $validatedData['status'] == 'in desfasurare') {
            $status = "Active";
        }
        $crm_response['status'] = false;
        if ($userEventLocation->crm_propose_event_id || (!$userEventLocation->crm_propose_event_id && $status === 'Active')) {
            /*send data to crm*/
            $crm_response = $this->apiService->sendEventToCrm($userEventLocation, $status);
            if ($crm_response['status'] && $data_modified) {

                $partner = $this->apiService->getPartnersFromCrm($userEventLocation->eventLocation->user->id);
                if ($partner['institution_email']) {
                    /*Send Mail to Partner to inform that the due date was changed*/
                    $result = Mail::to($userEventLocation->coordinator->email)->send(new EventDateChangePartnerEmail(
                        $userEventLocation->coordinator->name,
                        $userEventLocation->eventLocation->address,
                        $validatedData['due_date'],
                        $userEventLocation->coordinator->phone,
                    ));

                }

            }
        }

        if ((isset($crm_response['message']) && $crm_response['status']) || !$userEventLocation->crm_propose_event_id) {

            $userEventLocation->crm_propose_event_id = $crm_response['crm_id'] ?? $userEventLocation->crm_propose_event_id;
            $userEventLocation->update();
            session()->flash('success', $crm_response['message'] ?? 'Datele au fost salvate cu succes!');
            if (Auth::user()->role === 'coordinator')
                return redirect()->route('coordinator.event');
            return redirect()->route('propose-locations.index');
        }
        session()->flash('error', $crm_response['messsage'] ?? 'Datele nu au fost actualizate');
        if (Auth::user()->role === 'coordinator')
            return redirect()->route('coordinator.event');
        return redirect()->route('propose-locations.index');
    }

    public function show(UserEventLocation $userEventLocation)
    {

        if ($userEventLocation && Auth::check()) {

            $data = $this->apiService->getPartnersFromCrm($userEventLocation->eventLocation->user->id);

            $data += [
                'coordinator_name' => $userEventLocation->coordinator->name,
                'coordinator_phone' => $userEventLocation->coordinator->phone,
                'coordinator_email' => $userEventLocation->coordinator->email,
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
            ->unique()
            ->sort();

        $accepted_regions = EventLocation::with(['city.region', 'usersEventLocations'])
            ->select('cities_id')
            ->whereHas('usersEventLocations', function ($query) {
                $query->where('status', 'aprobat');
            })
            ->get()
            ->pluck('city.region')
            ->unique()
            ->sort();

        $regions = Region::all();

        return view('propose-event.index', compact('count_events', 'regions', 'events_regions', 'accepted_regions', 'share_link_data'));
    }

    public function approve_or_decline_propose_event(Request $request)
    {

        if ($request->location_id && $request->val) {
            $userEventLocation = UserEventLocation::where('id', $request->location_id)
                ->first();

            // check if event exists in crm or not...
            $update_crm = false;
            if (($userEventLocation->crm_propose_event_id && $request->val == 'refuzat') || $request->val == 'aprobat') {
                $update_crm = true;
            }
            $crm_response['status'] = false;
            if ($userEventLocation && $request->val && $request->val != $userEventLocation->status && $update_crm) {
                $crm_response = $this->apiService->sendEventToCrm($userEventLocation, $request->val);
                if (!$crm_response['status']) {
                    return response()->json(['success' => false, 'message' => $crm_response['message']]);
                }

                if ($crm_response['status'] && isset($crm_response['crm_id'])) {
                    //add crm id
                    $userEventLocation->crm_propose_event_id = $crm_response['crm_id'];
                }

                if ($request->val == 'aprobat' && $crm_response['status']) {
                    $mailData = [
                        'due_date' => $userEventLocation->due_date,
                        'name' => $userEventLocation->name
                    ];

                    $result = Mail::to($userEventLocation->coordinatror->email)->send(new ProposeEventMail($mailData));
                    if ($result) {
                        $response_msg['email'] = 'Email-ul a fost trimis cu succes';
                    } else {
                        $response_msg['email'] = false;
                    }
                }

            }

            $resp_success = false;
            if ((isset($crm_response['message']) && $crm_response['status']) || !$update_crm) {
                $userEventLocation->status = $request->val;
                $userEventLocation->save();
                $resp_success = true;
            }

            $response_msg = [
                'success' => $resp_success,
                'status' => ucfirst($userEventLocation->status),
                'message' => $crm_response['message'] ?? 'Statusul a fost modificat cu success',
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

    public function count_events_by_regions_id(Request $request)
    {
        $region_id = $request->region_id;
        if ($region_id) {
            $count_data = UserEventLocation::where('status', 'aprobat')
                ->whereHas('eventLocation.city.region', function ($query) use ($region_id) {
                    $query->where('id', $region_id);
                })
                ->count();

            return response()->json([
                'message' => '200 success',
                'status' => true,
                'count_data' => $count_data
            ]);
        }
        return response()->json([
            'message' => '203 success',
            'status' => false,
        ]);
    }

}
