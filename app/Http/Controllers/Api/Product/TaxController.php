<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Tax;
use App\Http\Requests\RegisterTaxRequest;
use App\Http\Requests\UpdateTaxRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaxController extends Controller
{
    public function viewTaxList()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        return response()->json(Tax::all(), 200);
    }

    public function registerTax(RegisterTaxRequest $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $tax = Tax::create($request->validated());

        return response()->json($tax, 201);
    }

    public function viewTax($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $tax = Tax::find($id);

        if (!$tax) {
            return response()->json(['message' => 'Tax not found'], 404);
        }

        return response()->json($tax, 200);
    }

    public function updateTax($id, UpdateTaxRequest $request)
    {
        $tax = Tax::find($id);

        if (!$tax) {
            return response()->json(['message' => 'Tax not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $tax->update($request->validated());

        return response()->json($tax, 200);
    }

    public function deleteTax($id)
    {
        $tax = Tax::find($id);

        if (!$tax) {
            return response()->json(['message' => 'Tax not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $tax->delete();

        return response()->json(['message' => 'Tax deleted successfully'], 200);
    }
}
