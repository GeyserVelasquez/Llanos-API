<?php

namespace Database\Factories;

use App\Models\EntryCause;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EntryCause>
 */
class EntryCauseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word();
        $code = $this->faker->unique()->bothify('###-###');

        return [
            'code' => $code,
            'name' => $name,
        ];
    }
}
