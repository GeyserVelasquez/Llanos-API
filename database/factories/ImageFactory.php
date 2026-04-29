<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Livestock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'path' => 'images/' . $this->faker->uuid() . '.jpg',
            'description' => $this->faker->sentence(),
            'livestock_id' => Livestock::factory(),
        ];
    }
}
