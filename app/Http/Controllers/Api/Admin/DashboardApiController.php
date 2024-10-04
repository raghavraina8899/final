<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends Controller
{
    public function getDashboardStats(): JsonResponse
    {
        $userCount = User::count();
        $productCount = Product::count();

        return response()->json([
            'userCount' => $userCount,
            'productCount' => $productCount,
        ]);
    }
}
