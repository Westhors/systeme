<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        // Construct the absolute path to cities.json using base_path()
        $citiesJsonPath = base_path('database/seeders/country-capitals.json');

        // Read the JSON data from the file
        $citiesJson = file_get_contents($citiesJsonPath);

        // Convert the JSON data to an array
        $citiesArray = json_decode($citiesJson, true);

        // Define the size of each batch (e.g., 1000 records per batch)
        $batchSize = 500;

        // Get the total number of cities
        $totalCities = count($citiesArray);

        // Create the progress bar
        $bar = $this->command->getOutput()->createProgressBar($totalCities);
        $bar->start();

        // Use chunking to insert the data in batches
        foreach (array_chunk($citiesArray, $batchSize) as $batch) {
            // Create a new array to store the formatted cities data for this batch
            $formattedCities = [];

            // Loop through each city in the current batch
            foreach ($batch as $cityData) {
                // Find the corresponding country based on the country.code
                $countryCode = $cityData['CountryCode'];
                $country = Country::where('code', $countryCode)->first();

                // If the country is found, create a new entry with 'name' and 'country_id'
                if ($country) {
                    $formattedCities[] = [
                        'name' => $cityData['CapitalName'],
                        'country_id' => $country->id,
                        'active' => true,
                        'lat' => $cityData['CapitalLatitude'],
                        'lng' => $cityData['CapitalLongitude'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Insert the formatted cities data into the 'cities' table
            DB::table('cities')->insert($formattedCities);

            // Update the progress bar for this batch
            $bar->advance(count($formattedCities));
        }

        // Finish the progress bar
        $bar->finish();
    }
}
