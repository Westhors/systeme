<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $events = [];

        for ($i = 0; $i < 7; $i++) {
            $events[] = [
                'title' => 'Past Event ' . ($i + 1),
                'des' => 'Description for past event ' . ($i + 1),
                'slug' => Str::slug('Past Event ' . ($i + 1)),
                'short_des' => 'Short description for past event ' . ($i + 1),
                'url_text' => 'URL Text ' . ($i + 1),
                'url_path' => 'url/path/' . ($i + 1),
                'start_date' => Carbon::now()->subDays(rand(1, 365)),
                'end_date' => Carbon::now()->subDays(rand(1, 365)),
                'delegates' => rand(50, 200),
                'sessions' => rand(1, 10),
                'companies' => rand(5, 50),
                'countries' => rand(1, 20),
                'featured' => rand(0, 1),
                'position' => $i + 1,
                'active' => 1,
                'city' => 'City ' . ($i + 1),
                'duration' => rand(1, 5),
                'venue' => 'Venue ' . ($i + 1),
                'country_id' => rand(1, 10),
                'user_id' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        for ($i = 0; $i < 3; $i++) {
            $events[] = [
                'title' => 'Future Event ' . ($i + 1),
                'des' => 'Description for future event ' . ($i + 1),
                'slug' => str::slug('Future Event ' . ($i + 1)),
                'short_des' => 'Short description for future event ' . ($i + 1),
                'url_text' => 'URL Text ' . ($i + 1),
                'url_path' => 'url/path/' . ($i + 1),
                'start_date' => Carbon::now()->addDays(rand(1, 365)),
                'end_date' => Carbon::now()->addDays(rand(1, 365)),
                'delegates' => rand(50, 200),
                'sessions' => rand(1, 10),
                'companies' => rand(5, 50),
                'countries' => rand(1, 20),
                'featured' => rand(0, 1),
                'position' => $i + 8,
                'active' => 1,
                'city' => 'City ' . ($i + 8),
                'duration' => rand(1, 5),
                'venue' => 'Venue ' . ($i + 8),
                'country_id' => rand(1, 10),
                'user_id' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('events')->insert($events);
    }
}
