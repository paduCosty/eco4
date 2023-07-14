<?php

namespace App\Http\Controllers;

use App\Mail\VolunteersMail;
use App\Models\EventRegistration;
use App\Models\User;
use App\Models\UserEventLocation;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Mailer\Exception\TransportException;

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

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
//        dd($request->all());
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
            $children = $request->children;
            if ($event_location->crm_propose_event_id) {
                $response = Http::asForm()->post('https://crm.cri.org.ro/api/add.php', [
                    'type' => 'v',
                    'name' => $request->name,
                    'email' => $request->email,
                    'judet' => $request->region,
                    'localitate' => $request->city,
                    'telefon' => $request->phone,
                    'santier' => $event_location->crm_propose_event_id,
                    'copii' => $children,
                    'ProjectID' => 10
                ]);
            }
        }

        if ($response->getStatusCode() == 200) {
            $body = json_decode($response->getBody()->getContents());
            if ($body->voluntarID) {
                $volunteer = $validatedData;
            } else {
                return redirect()->route('home')->with('error', 'Inscrierea a esuat, contactatine sau incercati mai tarziu.');

            }
        }
        if ($volunteer) {
            $eventLocation = EventRegistration::create($volunteer);

            $coordinator_data = UserEventLocation::where('id', $request->users_event_location_id)
                    ->select('id', 'coordinator_id')->first();

            session()->flash('show_volunteer_action_success_modal');
            session()->flash('coordinator-name', $coordinator_data->coordinator->name);
            session()->flash('coordinator_phone', $coordinator_data->coordinator->phone);

            return redirect()->route('home');
        }
        return redirect()->route('home')->with('error', 'Inscrierea a esuat, contactatine sau incercati mai tarziu.');

    }

    public function mail_to_volunteers(Request $request, UserEventLocation $event_location_id)
    {


        $email_success = true;
        if ($request->volunteers_selected) {
            $volunteersIds = $request->volunteers_selected;
            $i = 1;

            foreach ($volunteersIds as $volunteerId) {
                $volunteer = EventRegistration::select('id', 'email', 'name')
                    ->where('users_event_location_id', $event_location_id->id)
                    ->findOrFail($volunteerId);

                try {
                    Mail::to($volunteer->email)->send(new VolunteersMail($request->message, $event_location_id->name));
                } catch (Exception $e) {
                    Log::error('Eroare la trimiterea emailului către voluntarul cu ID-ul: ' . $volunteer->id);
                    $errorMessage = 'A apărut o eroare la trimiterea emailului, pentru mai multe detalii contactati echipa de suprot!';
                    return response()->json(['error' => $errorMessage], 500);
                }

                if ($i === 25) {
                    sleep(30);
                    $i = 1;
                }
                ++$i;
            }
        } else if ($request->to_all) {

            $volunteers = EventRegistration::select('id', 'email', 'name')
                ->where('users_event_location_id', $event_location_id->id)
                ->get();

            $i = 0;
            foreach ($volunteers as $volunteer) {
                try {
                    Mail::to($volunteer->email)->send(new VolunteersMail($request->message, $event_location_id->name));
                } catch (Exception $e) {
                    Log::error('Eroare la trimiterea emailului către voluntarul cu ID-ul: ' . $volunteer->id);
                    $errorMessage = 'A apărut o eroare la trimiterea emailului, pentru mai multe detalii contactati echipa de suprot!';
                    return response()->json(['error' => $errorMessage], 500);
                }

                if ($i === 25) {
                    sleep(30);
                    $i = 1;
                }
                ++$i;
            }

        }

        if ($email_success) {
            return response()->json(['status' => true, 'message' => 'Acțiunea a fost efectuată cu succes!']);
        }

        return response()->json(['status' => false, 'error' => 'Acțiunea a fost efectuată va rog contactati echipa de suport!']);

    }


}
