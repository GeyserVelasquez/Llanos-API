<?php

namespace Database\Factories;

use App\Models\GrowthType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GrowthType>
 */
class GrowthTypeFactory extends Factory
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
