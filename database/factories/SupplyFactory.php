<?php

namespace Database\Factories;

use App\Models\Supply;
use App\Models\SupplyType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supply>
 */
class SupplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('SUP-####'),
            'name' => $this->faker->word(),
            'attributes' => [
                'unit' => $this->faker->randomElement(['ml', 'mg', 'kg']),
                'brand' => $this->faker->company(),
            ],
            'supply_type_id' => SupplyType::factory(),
        ];
    }
}
