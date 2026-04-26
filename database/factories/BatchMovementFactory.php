<?php

namespace Database\Factories;

use App\Models\Batch;
use App\Models\BatchMovement;
use App\Models\Livestock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BatchMovement>
 */
class BatchMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'batch_id' => Batch::factory(),
            'livestock_id' => Livestock::factory(),
            'made_at' => $this->faker->date(),
            'attributes' => [],
        ];
    }
}
