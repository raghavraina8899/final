<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    // Fetch all countries
    public function viewCountryList()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }
        return response()->json(Country::all(), 200);
    }

    // Create a new country
    public function registerCountry(Request $request)
    {
        $request->validate([
            'country_name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:countries',
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $country = Country::create($request->all());

        return response()->json($country, 201);
    }

    // Show a specific country
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

    // Update a country
    public function updateCountry($id, Request $request)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'country_name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        // Update the country
        $country->update($validatedData);

        // Return the updated country
        return response()->json($country, 200);
    }


    // Delete a country
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
