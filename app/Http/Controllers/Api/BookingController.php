<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\ProductBookedMail;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function bookProduct(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['status' => false, 'message' => 'User is not authenticated']);
    }

    $productId = $request->input('product_id');
    $quantity = $request->input('quantity', 1); 

    $product = Product::find($productId);
    if (!$product) {
        return response()->json(['status' => false, 'message' => 'Product not found']);
    }

    $totalPrice = $product->product_cost * $quantity; 

    // \Log::info("Product Cost: {$product->product_cost}, Quantity: {$quantity}, Total Price: {$totalPrice}");

    
    $user->products()->attach($productId, [
        'quantity' => $quantity,
        'total_price' => $totalPrice,
    ]);

    $product_name = $product->product_name;

    SendEmailJob::dispatch($user->email, new ProductBookedMail($user->name, $product_name, $quantity, $totalPrice));

    return response()->json(['status' => true, 'message' => 'Product booked successfully']);
}


    public function showMyBookings()
    {
        return view('/events/my-bookings');
    }

    public function myBookings(Request $request)
    {
        
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User is not authenticated']);
        }

        
        $bookings = $user->products()->withPivot('quantity', 'total_price')->get();

        return response()->json([
            'status' => true,
            'bookings' => $bookings,
        ]);
    }
}
