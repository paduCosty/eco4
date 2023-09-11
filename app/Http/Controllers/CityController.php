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
        $region_id = $request->region_id;
        $approved_events = UserEventLocation::where('users_event_locations.status', 'aprobat');
        if (is_numeric($region_id)) {
            $approved_events = $approved_events->whereHas('eventLocation.city', function ($query) use ($region_id) {
                $query->where('region_id', $region_id);
            });
        }

        $approved_events = $approved_events->with([
            'eventLocation:id,name,cities_id,size_volunteer_id,relief_type,address',
            'eventLocation.city:id,name,region_id',
            'eventLocation.city.region:id,name',
            'eventLocation.sizeVolunteer:id,name',
        ])
            ->join('event_locations', 'users_event_locations.event_location_id', '=', 'event_locations.id')
            ->join('size_volunteers', 'event_locations.size_volunteer_id', '=', 'size_volunteers.id')
            ->select(
                'users_event_locations.*',
                'size_volunteers.name as size_volunteer_name',
            );

        if (!is_numeric($region_id)) {
            $approved_events = $approved_events
                ->orderBy('due_date', 'desc')
                ->take(3);
        }
            $approved_events = $approved_events->get();

        if ($approved_events) {
            $response = array(
                'status' => 'success',
                'message' => 'Cererea AJAX a fost procesată cu succes!',
                'data' => $approved_events,
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
//        dd($request->all());
        $response = array(
            'status' => false,
            'message' => 'Ceva nu a mers',
        );

        if ($request->region_id) {
            $region_id = $request->region_id;
            $cities = City::whereHas('eventLocations.approvedUsersEventLocations', function ($query) use ($region_id) {
                $query->where('region_id', $region_id);
            })->get()
                ->toArray();

            $response = array(
                'status' => true,
                'message' => 'Cererea AJAX a fost procesată cu succes!',
                'data' => $cities
            );
        }
        return response()->json($response);
    }

}
