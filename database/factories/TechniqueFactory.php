<?php

namespace Database\Factories;

use App\Models\Technique;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Technique>
 */
class TechniqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('V-##.###.###'),
            'name' => $this->faker->name(),
            'telephone' => $this->faker->phoneNumber(),
        ];
    }
}
