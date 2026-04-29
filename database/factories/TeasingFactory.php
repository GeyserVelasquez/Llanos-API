<?php

namespace Database\Factories;

use App\Models\Abort;
use App\Models\AbortType;
use App\Models\Livestock;
use App\Models\Technique;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Abort>
 */
class TeasingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'livestock_id' => Livestock::factory(),
            'technique_id' => Technique::factory(),
            'detected_at' => $this->faker->date(),
        ];
    }
}
