<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiApplicationTermsService
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

//    public static function get_contract_terms()
//    {
//        $client = new Client();
//        $response = $client->get(env('LOGIN_URL') . '/contract');
//        $data = json_decode($response->getBody()->getContents());
//        if ($data) {
//            return response()->json(['status' => true, 'data' => $data[0]->Name]);
//        }
//        return response()->json(['status' => false, 'message' => 'Server error!']);
//
//    }
}
