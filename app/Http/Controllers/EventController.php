<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\EventDateChangePartnerEmail;
use App\Mail\MailToPartner;
use App\Mail\ProposeEventMail;
use App\Models\EventLocation;
use App\Models\PreGreeningEventImages;
use App\Models\Region;
use App\Models\SizeVolunteers;
use App\Models\User;
use App\Models\UserEventLocation;
use App\Models\UserEventLocationsPhotos;
use App\Services\ApiService;
use App\Services\CdnService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Throwable;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class EventController extends Controller
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
        $cdnUrl = (new \App\Services\CdnService)->cdn_path();
        return view('users.events.index', compact('eventLocations', 'cdnUrl'));
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
        $event->name = 'L' . $event->eventLocation->id . '/A' . $event->id . ' - ' . $event->eventLocation->city->name . ',' . $event->eventLocation->city->region->name;
        $event->save();

        /*send image to cdn*/
        $images = $request->file('event_images');
        $cdn = new CdnService;
        foreach ($images as $image) {
            $filename = $cdn->sendPhotoToCdn($image, $event->id . '/before');
            PreGreeningEventImages::create([
                'event_location_id' => $event->id,
                'path' => '/before/' . $filename
            ]);
        }

        /*take partner email and name form crm*/
        $partner_data = $this->apiService->getPartnersFromCrm($event->eventLocation->user->id);
        if ($event && isset($partner_data['institution_email'])) {
            /*send mail to partner*/
            try {
                Mail::to($partner_data['institution_email'])
                    ->send(new MailToPartner(
                        $partner_data['institution_name'] ?? '',
                        $event->due_date,
                        $event->eventLocation->address,
                        $event->coordinator->name,
                        url('/admin/events')
                    ));
            } catch (Throwable $exception) {
                return redirect()->back()->with('error', 'Eroare la trimiterea mail-ului');
            }

        }

        session()->flash('show_propose_event_confirmation_modal');
        return redirect()->route('home');
    }

    public function update(Request $request, UserEventLocation $userEventLocation): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'description' => 'required',
            'due_date' => 'required',
        ]);

        if (Auth::user()->role !== 'coordinator') {
            $validatedData += $request->validate([
                'status' => 'required',
            ]);
        }

        if ($request->hasFile('event_images')) {
            $images = $request->file('event_images');

            foreach ($images as $image) {
                $cdn_image = (new \App\Services\CdnService)->sendPhotoToCdn($image, $userEventLocation->id . '/after');
                if ($cdn_image) {
                    UserEventLocationsPhotos::create([
                        'path' => '/after/' . $cdn_image,
                        'event_location_id' => $userEventLocation->id,
                    ]);
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'Imaginea- "' . $image->getClientOriginalName() . '" nu a putut fi adaugata!');
                }
            }
        }

        $data_modified = false;
        if ($userEventLocation->due_date != $validatedData['due_date']) {
            $data_modified = true;
        }

        /*add to event updated data*/
        $userEventLocation->due_date = $validatedData['due_date'];
        $userEventLocation->description = $validatedData['description'];

        if (isset($validatedData['status'])) {
            $userEventLocation->status = $validatedData['status'];
        }

        $status = 'Inactive';
        if ($userEventLocation->status == 'aprobat' || $userEventLocation->status == 'in desfasurare') {
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
            return redirect()->route('events.index');
        }
        session()->flash('error', $crm_response['messsage'] ?? 'Datele nu au fost actualizate');
        if (Auth::user()->role === 'coordinator')
            return redirect()->route('coordinator.event');
        return redirect()->route('events.index');
    }

    public function show(UserEventLocation $userEventLocation)
    {

        if ($userEventLocation && Auth::check()) {
            $data = $this->apiService->getPartnersFromCrm($userEventLocation->eventLocation->user->id);
            $event_data = $this->apiService->getEventFromCrm($userEventLocation->crm_propose_event_id);
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
                'waste' => $event_data->Deseuri ?? '',
                'bags' => $event_data->Saci ?? '',
                'before_images' => $userEventLocation->preGreeningEventImages,
                'cdn_api' => (new \App\Services\CdnService)->cdn_path($userEventLocation->id),
                'uploaded_images' => $userEventLocation->eventLocationImages,
                'table' => $userEventLocation->eventLocationImages()->getRelated()->getTable(),

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

        return view('home.index', compact('count_events', 'regions', 'events_regions', 'accepted_regions', 'share_link_data'));
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
                if ($request->val == 'aprobat' || $request->val == 'in asteptare') {
                    $status = 'Active';
                } else {
                    $status = 'Inactive';
                }
                $crm_response = $this->apiService->sendEventToCrm($userEventLocation, $status);
                if (!$crm_response['status']) {
                    return response()->json(['success' => false, 'message' => $crm_response['message']]);
                }

                if ($crm_response['status'] && isset($crm_response['crm_id'])) {
                    //add crm id
                    $userEventLocation->crm_propose_event_id = $crm_response['crm_id'];
                }

                if ($request->val == 'aprobat' && $crm_response['status']) {

                    $partner_details = $this->apiService->getPartnersFromCrm($userEventLocation->eventLocation->user->crm_propose_event_id);
                    $mail_data = [
                        'coordinator_name' => $userEventLocation->coordinator->name,
                        'due_date' => $userEventLocation->due_date,
                        'institution_name' => $partner_details['institution_name'],
                        'institution_phone' => $partner_details['institution_phone'],
                        'institution_email' => $partner_details['institution_email'],
                        'event_name' => $userEventLocation->name
                    ];

                    $result = Mail::to($userEventLocation->coordinator->email)
                        ->send(new ProposeEventMail($mail_data));
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
            'message' => '203',
            'status' => false,
        ]);
    }

    public function update_unfolded_event(UserEventLocation $userEventLocation, Request $request)
    {
        if ($request->event_images) {
            $validator = Validator::make($request->all(), [
                'event_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

//        $images_for_delete = request()->input('images_for_delete');
        //remove photo if is deleted from frontend
//        if ($images_for_delete) {
//            $image_ids = json_decode($images_for_delete, true);
//            foreach ($image_ids as $image_id) {
//                $image = UserEventLocationsPhotos::find($image_id);
//                if ($image) {
//                    $image->delete();
//                }
//            }
//        }

        if ($request->hasFile('event_images')) {
            $images = $request->file('event_images');

            foreach ($images as $image) {
                $cdn_image = (new \App\Services\CdnService)->sendPhotoToCdn($image, $userEventLocation->id . '/after');
                if ($cdn_image) {
                    UserEventLocationsPhotos::create([
                        'path' => '/after/' . $cdn_image,
                        'event_location_id' => $userEventLocation->id,
                    ]);
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'Imaginea- "' . $image->getClientOriginalName() . '" nu a putut fi adaugata!');
                }
            }
        }

        $userEventLocation->waste = $request->waste;
        $userEventLocation->bags = $request->bags;

        $crm_status = $this->apiService->sendEventToCrm($userEventLocation, 'Inactive');
        if ($crm_status['status']) {
            return redirect()->back()->with('success', 'Datele au fost salvate cu succes.');
        }


        return redirect()->back()->with(['error' => 'Nu au fost găsite imagini în cerere.']);
    }

    public function get_for_edit_unfolded_event(UserEventLocation $userEventLocation)
    {
        $crm_event_data = $this->apiService->getEventFromCrm($userEventLocation->crm_propose_event_id);
        if ($crm_event_data) {
            $data = [
                'waste' => $crm_event_data['Deseuri'] ?? '',
                'bags' => $crm_event_data['Saci'] ?? '',
                'images' => $userEventLocation->eventLocationImages
            ];
            return response()->json([
                'message' => '200 success',
                'status' => true,
                'count_data' => $data
            ]);
        }
        return response()->json([
            'message' => '203',
            'status' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserEventLocation $userEventLocation): RedirectResponse
    {
        if (Auth::user()->role == 'admin') {
            $userEventLocation->eventLocationImages()->delete();
            $userEventLocation->preGreeningEventImages()->delete();
            $userEventLocation->eventRegistrations()->delete();

            $userEventLocation->delete();
        } else {
            return redirect()->back()
                ->with('error', 'Nu ai suficiete permisii pentru a efectua aceasta actiune');
        }
        return redirect()->back()
            ->with('success', 'Product deleted successfully');
    }

    public function destroy_image(Request $request)
    {
        $file = DB::table($request->table)->where('id', $request->file_id)->first();
        $cdn_response = (new \App\Services\CdnService)
            ->removeCdnFile($file->event_location_id . $request->file_path);
        if ($cdn_response) {
            $query = DB::table($request->table)->where('id', $request->file_id)->delete();
        }
        return response()->json($cdn_response);
    }
}
