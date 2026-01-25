<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 30) as $index) {
            DB::table('articles')->insert([
                'name' => $faker->sentence,
                'slug' => Str::slug($faker->sentence),
                'short_des' => $faker->text(50),
                'des' => $faker->text,
                'position' => $index,
                'active' => $faker->boolean,
                'featured' => $faker->boolean,
                'publish_date' => Carbon::now()->subDays(rand(1, 365))->format('Y-m-d'),
            ]);
        }

        foreach (range(1, 20) as $index) {
            DB::table('articles')->insert([
                'name' => $faker->sentence,
                'slug' => Str::slug($faker->sentence),
                'short_des' => $faker->text(50),
                'des' => $faker->text,
                'position' => $index + 30,
                'active' => $faker->boolean,
                'featured' => $faker->boolean,
                'publish_date' => Carbon::now()->addDays(rand(1, 365))->format('Y-m-d'),
            ]);
        }
    }
}
