<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * BARU: Konfigurasikan factory untuk auto-create Patient.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            // 2. Setelah User dibuat, buat juga Patient
            //    dan hubungkan dengan user_id
            if ($user->email !== 'admin@example.com') { // Opsional: Jangan buat profil pasien untuk admin
                Patient::factory()->create(['user_id' => $user->id]);
            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
