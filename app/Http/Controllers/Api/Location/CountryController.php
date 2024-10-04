<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Requests\RegisterCountryRequest;
use App\Http\Requests\UpdateCountryRequest;

class CountryController extends Controller
{
    public function viewCountryList()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        return response()->json(Country::all(), 200);
    }

    public function registerCountry(RegisterCountryRequest $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $country = Country::create($request->validated());

        return response()->json($country, 201);
    }

    public function viewCountry($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        return response()->json($country, 200);
    }

    public function updateCountry($id, UpdateCountryRequest $request)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $country->update($request->validated());

        return response()->json($country, 200);
    }

    public function deleteCountry($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $country->delete();

        return response()->json(['message' => 'Country deleted successfully'], 200);
    }
}
