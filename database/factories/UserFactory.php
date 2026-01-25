<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $plainPassword = 'password';

        return [
            'name' => $this->faker->company,
            'address_line_one' => $this->faker->streetAddress,
            'address_line_two' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'website' => $this->faker->domainName,
            'phone' => $this->faker->phoneNumber,
            'members_count' => $this->faker->numberBetween(1, 1000),
            'country_id' => $this->faker->numberBetween(1, 240),
            'business_est' => $this->faker->year,
            'profile' => $this->faker->paragraph,
            'fpp' => $this->faker->randomElement(['yes', 'no']),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make($plainPassword),
            'unhashed_password' => $plainPassword,
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
