<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\RegisterProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function viewProductList(): JsonResponse
    {
        return response()->json(Product::paginate(8), 200);
    }

    public function registerProduct(RegisterProductRequest $request): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $productData = $request->validated();

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('product_images', 'public');

            $productData['image_url'] = $imagePath;
        }

        // Create the product
        $product = Product::create($productData);

        return response()->json($product, 201);
    }

    public function viewProduct($id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    public function updateProduct($id, UpdateProductRequest $request): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $productData = $request->validated();

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Optionally delete the old image here if necessary
            $imagePath = $request->file('image')->store('product_images', 'public');
            $productData['image_url'] = $imagePath; // Add image path to the product data
        }

        // Update the product with new data
        $product->update($productData);

        return response()->json($product, 200);
    }

    public function deleteProduct($id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    public function getProductsByTax($taxId): JsonResponse
    {
        $products = Product::where('country_id', $taxId)->get();
        return response()->json($products);
    }
}
