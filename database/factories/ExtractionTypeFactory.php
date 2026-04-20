<?php

namespace Database\Factories;

use App\Models\ExtractionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExtractionType>
 */
class ExtractionTypeFactory extends Factory
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