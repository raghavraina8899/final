<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class BookingTest extends TestCase
{
    protected $user;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        // Create a test product
        $this->product = Product::factory()->create([
            'product_name' => 'Test Product',
            'product_cost' => 100,
        ]);
    }

    public function test_user_can_book_product()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->postJson('/api/book-product', [
            'product_id' => $this->product->id, // Use the created product ID
            'quantity' => 2,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => true, 'message' => 'Product booked successfully']);
    }

    public function test_user_cannot_book_product_if_not_authenticated()
    {
        $response = $this->postJson('/api/book-product', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']); // Match the actual response
    }

    

    public function test_user_can_view_my_bookings()
    {
        $this->actingAs($this->user, 'api');

        // Book a product first
        $this->postJson('/api/book-product', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->getJson('/api/my-bookings');

        $response->assertStatus(200)
                 ->assertJson(['status' => true]);
    }

    public function test_user_cannot_view_my_bookings_if_not_authenticated()
    {
        $response = $this->getJson('/api/my-bookings');

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']); // Match the actual response
    }
}
