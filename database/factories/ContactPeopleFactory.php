<?php

namespace Database\Factories;

use App\Models\ContactPeople;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactPeopleFactory extends Factory
{
    protected $model = ContactPeople::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(['mr', 'mrs', 'ms']),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'job_title' => $this->faker->jobTitle(),
            'phone_number' => $this->faker->phoneNumber(),
            'cell_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'user_id' => random_int(1, 100),
        ];
    }
}
