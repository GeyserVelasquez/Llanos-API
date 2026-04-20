<?php

namespace Database\Factories;

use App\Models\Herd;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Herd>
 */
class HerdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->city;
        $code = mb_strtoupper(mb_substr($name, 0, 2));

        return [
            'code' => $code,
            'name' => $name,
        ];
    }
}
