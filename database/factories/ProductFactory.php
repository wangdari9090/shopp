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
       $fakeImageUrl = $this->faker->imageUrl(640, 480, 'products', true, 'FakerProduct');
        
        return [
            'title' => $this->faker->words(3, true), // Generates 3 random words
            'description' => $this->faker->paragraph(3), // Generates 3 sentences
            'quantity' => $this->faker->numberBetween(1, 100), // Random number between 1 and 100
            'price' => $this->faker->randomFloat(2, 10, 500), // Random price between 10.00 and 500.00
            'image' => 'https://picsum.photos/640/480?random=' . $this->faker->unique()->randomNumber(5),
            
        ];
    }
}
