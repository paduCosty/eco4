<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use mysql_xdevapi\Exception;

class ApiService
{
    public function getPartnersFromCrm($user_id)
    {
       $data = [];
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
        return $data;
    }

}
