<?php

namespace App\Services;

use App\Models\SizeVolunteers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use mysql_xdevapi\Exception;

class ApiService
{
    protected $crmUrl;

    public function __construct()
    {
        $this->crmUrl = env('LOGIN_URL');
    }

    public function getPartnersFromCrm($user_id)
    {
        $data = [];
        try {
            $partner_resp = Http::post($this->crmUrl . '/get_partners/' . $user_id . '/' . 0 . '/' . 0);
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
        return $data;
    }

    public function sendEventToCrm($userEventLocation, $status): array
    {

        //specify type if is create or update
        $action_type = 'add_action';
        if ($userEventLocation->crm_propose_event_id) {
            $action_type = 'update_action';
        }
        $volunteers_size = SizeVolunteers::select('required_volunteer_level')
            ->where('id', $userEventLocation->eventLocation->size_volunteer_id)
            ->first();

        /*add end date to event 15:00*/
        $end_date = Carbon::parse($userEventLocation->due_date)->setTime(15, 0, 0);
        $end_date = $end_date->format('Y-m-d H:i:s');
        $data = [
            'id' => $userEventLocation->crm_propose_event_id,
            'Coordinator' => json_encode(array($userEventLocation->coordinator_id)),
            'Longitudine' => $userEventLocation->eventLocation->longitude,
            'Latitudine' => $userEventLocation->eventLocation->latitude,
            'Description' => $userEventLocation->description,
            'JudetID' => $userEventLocation->eventLocation->city->region_id,
            'LocationID' => $userEventLocation->eventLocation->cities_id,
            'Number' => $volunteers_size->required_volunteer_level,
            'Date' => $userEventLocation->due_date,
            'Dataend' =>$end_date,
            'Name' => $userEventLocation->eventLocation->address,
            'ProjectID' => 10,
            'EditionID' => 25,
            'Radius' => 2000,
            'Action' => "Ecologizare",
            'Timeframe' => 120,
            'Points' => 20,
            'Type' => 9,
            'Deseuri' => $userEventLocation->waste,
            'Saci' => $userEventLocation->bags

        ];

        if(Auth::user()->role === 'partner' || Auth::user()->role == 'admin') {
            $data['Status'] = $status;
        }
        $response = Http::asForm()->post($this->crmUrl . $action_type, $data);

        $message = 'Actiune actualizata cu success!';

        if (is_numeric($response->body())) {
            return ['status' => true, 'message' => $message, 'crm_id' => intval($response->body())];
        } else if ($response->body() == 'Actiune actualizata cu success!') {
            return ['status' => true, 'message' => $message];

        }
        return ['status' => false, 'message' => 'Actiunea nu a reusit contacteaza echipa de suport pentru mai multe detalii!'];
    }

}
