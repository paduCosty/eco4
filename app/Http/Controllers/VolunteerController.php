<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\UserEventLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VolunteerController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page');
        /*take items by page index*/
        $volunteers = EventRegistration::where('users_event_location_id', $request->event_location_id)
            ->skip(($page - 1) * 10)
            ->take(10)
            ->get()->toArray();

        /*take total pages*/
        $totalVolunteers = EventRegistration::where('users_event_location_id', $request->event_location_id)
            ->paginate(10)->toArray();

        return response()->json([
            'data' => $volunteers,
            'total_pages' => $totalVolunteers['last_page']
        ]);
    }

//    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
//    {
//
//        $size_volunteers = SizeVolunteers::all();
//        $regions = Region::all();
//
//        return view('admin.event.create', compact('regions', 'size_volunteers'));
//    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'terms_site' => 'required',
            'terms_workshop' => 'required',
            'volunteering_contract' => 'required',
            'users_event_location_id' => 'required',
        ]);

        if ($request->users_event_location_id) {

            $event_location = UserEventLocation::where('id', $request->users_event_location_id)
                ->first();

            $response = false;
            if ($event_location->crm_propose_event_id) {
                $response = Http::asForm()->post('https://crm.cri.org.ro/api/add.php', [
                    'type' => 'v',
                    'name' => $request->name,
                    'judet' => $request->region,
                    'localitate' => $request->city,
                    'telefon' => $request->phone,
                    'santier' => $event_location->crm_propose_event_id,
                ]);
            }
        }
//dd($event_location->crm_propose_event_id);
        if ($response) {
            $eventLocation = EventRegistration::create($validatedData);
            session()->flash('success', 'Datele au fost salvate cu succes!');
            return redirect()->route('home');
        }
        return redirect()->route('home')->with('error', 'Inscrierea a esuat, contactatine sau incercati mai tarziu.');

    }

//    public function show(EventLocation $eventLocation): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
//    {
////        return view('event-locations.show', compact('eventLocation'));
//        dd('show');
//    }

//    public function edit(EventLocation $event_location): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
//    {
//        $size_volunteers = SizeVolunteers::all();
//        $regions = Region::all();
//
//        $event_location = EventLocation::with('city')->findOrFail($event_location->id);
//
//        return view('admin.event.edit', compact('event_location', 'regions', 'size_volunteers'));
//    }

//    public function update(Request $request, EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
//    {
//        $validatedData = $request->validate([
////            'name' => 'required',
//            'cities_id' => 'required',
//            'user_id' => 'required',
//            'longitude' => 'required',
//            'latitude' => 'required',
//            'relief_type' => 'required',
////            'status' => 'required',
//        ]);
//
//        $eventLocation->update($validatedData);
//
//        return redirect()->route('event-locations.index');
//    }
//
//    public function destroy(EventLocation $eventLocation): \Illuminate\Http\RedirectResponse
//    {
//        $eventLocation->delete();
//
//        return redirect()->route('event-locations.index');
//    }
}
