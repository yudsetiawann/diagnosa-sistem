<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'age' => fake()->numberBetween(1, 90),
            'gender' => fake()->randomElement(['Male', 'Female', 'Other']),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
