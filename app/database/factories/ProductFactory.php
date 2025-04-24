<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'price_sale' => $this->faker->randomFloat(2, 50, 500),
            'price_cost' => $this->faker->randomFloat(2, 30, 400),
            'description' => $this->faker->sentence(),
            'image' => json_encode([$this->faker->image('storage/app/public', 200, 200, null, false)]),
            'active' => $this->faker->boolean(80),
        ];
    }
}
