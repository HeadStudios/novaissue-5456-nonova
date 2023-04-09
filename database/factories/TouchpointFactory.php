<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Touchpoint>
 */
class TouchpointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //'date' => fake()->date(),
            //'notes' => fake()->paragraph(),
            //'call_result' => fake()->randomElement(['Not Interested', 'Voicemail', 'Call Me Back']),
        ];
    }
}
