<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;

class ContactPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        $faker = Faker::create();
        $rows = 300;
        $data = [];
        for ($i = 0; $i < $rows; $i++) {
            $data[] = [
                'title' => $faker->randomElement(['mr', 'mrs', 'ms']),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'job_title' => $faker->jobTitle(),
                'phone_number' => $faker->phoneNumber(),
                'cell_number' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'user_id' => $faker->numberBetween(1, 100),
            ];
        }
        DB::table('contact_people')->insert($data);
    }
}
