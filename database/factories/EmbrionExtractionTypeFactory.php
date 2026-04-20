<?php

namespace Database\Factories;

use App\Models\EmbrionExtractionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmbrionExtractionType>
 */
class EmbrionExtractionTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        $code = mb_strtoupper(mb_substr($name, 0, 2));

        return [
            'code' => $code,
            'name' => $name,
        ];
    }
}
