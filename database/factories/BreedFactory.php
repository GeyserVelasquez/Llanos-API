<?php

namespace Database\Factories;

use App\Models\Breed;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Breed>
 */
class BreedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(['Brahman', 'Angus', 'GYR']);
        $code = mb_strtoupper(mb_substr($name, 0, 2));

        return [
            'code' => $code,
            'name' => $name,
        ];
    }
}
