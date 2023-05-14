<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\UserEventLocation;
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
            })->get()
                ->toArray();
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

    public function approved_events(Request $request)
    {
        $city_id = $request->city_id;
        if ($city_id) {
            $approved_events = UserEventLocation::where('users_event_locations.status', 'aprobat')
                ->whereHas('eventLocation.city', function ($query) use ($city_id) {
                    $query->where('id', $city_id);
                })
                ->with([
                    'eventLocation:id,name,cities_id,size_volunteer_id,relief_type',
                    'eventLocation.city:id,name,region_id',
                    'eventLocation.city.region:id,name',
                    'eventLocation.sizeVolunteer:id,name',
                ])
                ->join('event_locations', 'users_event_locations.event_location_id', '=', 'event_locations.id')
                ->join('size_volunteers', 'event_locations.size_volunteer_id', '=', 'size_volunteers.id')
                ->select(
                    'users_event_locations.*',
                    'size_volunteers.name as size_volunteer_name',
                )
                ->get();

            $response = array(
                'status' => 'success',
                'message' => 'Cererea AJAX a fost procesată cu succes!',
                'data' => $approved_events
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Ceva nu a mers',
            );
        }

        return response()->json($response);
    }

    public function get_cities_by_region_id(Request $request)
    {
        $response = array(
            'status' => false,
            'message' => 'Ceva nu a mers',
        );

        if ($request->region_id) {
            $cities_by_region = City::with('region')->where('region_id', $request->region_id)->get();
            $response = array(
                'status' => 'success',
                'message' => 'Cererea AJAX a fost procesată cu succes!',
                'data' => $cities_by_region
            );
        }
        return response()->json($response);
    }

    public function get_cities_with_propose_event_by_region_id(Request $request)
    {
        $response = array(
            'status' => false,
            'message' => 'Ceva nu a mers',
        );
//verifica ruta daca merge
        // vezi daca ai relationare intre citi si userEventLocation
        //fa queri-ul sa ia toate orasele unde sunt propuse evenimente

        if ($request->region_id) {
            $region_id = $request->region_id;
            $cities = City::whereHas('eventLocations.approvedUsersEventLocations', function ($query) use ($region_id) {
                $query->where('region_id', $region_id);
            })->get()
                ->toArray();
        }

//        if ($cities) {
//            $response = array(
//                'status' => 'success',
//                'message' => 'Cererea AJAX a fost procesată cu succes!',
//                'data' => $cities
//            );
//        } else {
            $response = array(
                'status' => false,
                'message' => 'Ceva nu a mers',
                'data' => $cities
            );
//        }
//        $response = array(
//            'status' => 'success',
//            'message' => 'Cererea AJAX a fost procesată cu succes!',
//            'data' => $cities_by_region
//        );

        return response()->json($response);
    }

}
