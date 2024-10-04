<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->word(),
            'product_cost' => $this->faker->randomFloat(2, 1, 100), // Random cost between 1 and 100
            // Add other fields as necessary
        ];
    }
}
