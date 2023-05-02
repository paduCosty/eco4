<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = '';

        if ($request->region_id) {
            $cities = City::where('region_id', $request->region_id)->get();
        }
        if ($cities) {
            $response = array(
                'status' => 'success',
                'message' => 'Cererea AJAX a fost procesată cu succes!',
                'data' => $cities
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Ceva nu a mers',
            );
        }
        return response()->json($response);

    }

    public function get_cities_by_event_locations(Request $request): \Illuminate\Http\JsonResponse
    {
        $cities = '';

        if ($request->region_id) {
            $region_id = $request->region_id;
            $cities = City::whereHas('eventLocations', function ($query) use ($region_id) {
                $query->where('region_id', $region_id);
            })->get()->toArray();
        }

        if ($cities) {
            $response = array(
                'status' => 'success',
                'message' => 'Cererea AJAX a fost procesată cu succes!',
                'data' => $cities
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Ceva nu a mers',
            );
        }

        return response()->json($response);
    }
}
