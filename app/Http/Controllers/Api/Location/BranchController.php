<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Http\Requests\RegisterBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function viewBranchList()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        return response()->json(Branch::all(), 200);
    }

    public function registerBranch(RegisterBranchRequest $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $branch = Branch::create($request->all());

        return response()->json($branch, 201);
    }

    public function viewBranch($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $branch = Branch::find($id);

        if (!$branch) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        return response()->json($branch, 200);
    }

    public function updateBranch($id, UpdateBranchRequest $request)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $branch->update($request->validated());

        return response()->json($branch, 200);
    }

    public function deleteBranch($id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $branch->delete();

        return response()->json(['message' => 'Branch deleted successfully'], 200);
    }

    public function getBranchesByCities($cityId) {
        $branches = Branch::where('city_id', $cityId)->get();
        return response()->json($branches);
    }
}
