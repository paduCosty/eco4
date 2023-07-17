<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiApplicationService
{
    public static function get_contract_terms()
    {
        $client = new Client();
        $response = $client->get(env('LOGIN_URL') . '/contract');
        $data = json_decode($response->getBody()->getContents());
        if ($data) {
            return response()->json(['status' => true, 'data' => $data[0]->Name]);
        }
        return response()->json(['status' => false, 'message' => 'Server error!']);

    }

    public static function get_privacy_terms()
    {
        $client = new Client();
        $response = $client->get(env('LOGIN_URL') . '/privacy');
        $data = json_decode($response->getBody()->getContents());
        if ($data) {
            return response()->json(['status' => true, 'data' => $data[0]->Name]);
        }
        return response()->json(['status' => false, 'message' => 'Server error!']);

    }
    public static function get_terms_site()
    {
        $client = new Client();
        $response = $client->get(env('LOGIN_URL') . '/terms');
        $data = json_decode($response->getBody()->getContents());
        if ($data) {
            return response()->json(['status' => true, 'data' => $data[0]->Name]);
        }
        return response()->json(['status' => false, 'message' => 'Server error!']);

    }

    public function get_app_details_from_crm() {
        $client = new Client();
        $response = $client->get(env('LOGIN_URL') . 'single_project/10');
        $data = json_decode($response->getBody()->getContents());
        if ($data) {
            return response()->json(['status' => true, 'data' => $data[0]->Name]);
        }
        return response()->json(['status' => false, 'message' => 'Server error!']);
    }
}
