<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Requests\RegisterCityRequest;
use App\Http\Requests\UpdateCityRequest;

class CityController extends Controller
{
    public function viewCityList()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        return response()->json(City::all(), 200);
    }

    public function registerCity(RegisterCityRequest $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $city = City::create($request->validated());

        return response()->json($city, 201);
    }

    public function viewCity($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $city = City::find($id);

        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }

        return response()->json($city, 200);
    }

    public function updateCity($id, UpdateCityRequest $request)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $city->update($request->validated());

        return response()->json($city, 200);
    }

    public function deleteCity($id)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $city->delete();

        return response()->json(['message' => 'City deleted successfully'], 200);
    }

    public function getCitiesByStates($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();
        return response()->json($cities);
    }
}
