<?php

namespace App\Http\Controllers\Api\Location;

use App\Models\State;
use App\Http\Requests\RegisterStateRequest;
use App\Http\Requests\UpdateStateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function viewStateList()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        return response()->json(State::all(), 200);
    }

    public function registerState(RegisterStateRequest $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $state = State::create($request->validated());

        return response()->json($state, 201);
    }

    public function viewState($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $state = State::find($id);

        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        return response()->json($state, 200);
    }

    public function updateState($id, UpdateStateRequest $request)
    {
        $state = State::find($id);

        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $state->update($request->validated());

        return response()->json($state, 200);
    }

    public function deleteState($id)
    {
        $state = State::find($id);

        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $state->delete();

        return response()->json(['message' => 'State deleted successfully'], 200);
    }

    public function getStatesByCountry($countryId)
    {
        $states = State::where('country_id', $countryId)->get();
        return response()->json($states);
    }
}
