<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        DB::table('teams')->insert([
            [
                'title' => 'President',
                'name' => 'Andrew Smithurst',
                'network' => 'Uconnect Worldwide Network (UCN)',
                'position' => 9,
            ],
            [
                'title' => 'Vice President',
                'name' => 'Remon Sarofeem',
                'network' => 'World Shipping Alliance (WSA)',
                'position' => 8,
            ],
            [
                'title' => 'Treasurer',
                'name' => 'Dummy Name',
                'network' => 'Dummy Network Name',
                'position' => 7,

            ],
            [
                'title' => 'Secretary-General',
                'name' => 'Dummy Name',
                'network' => 'Dummy Network Name',
                'position' => 6,

            ],
            [
                'title' => 'Chair Members',
                'name' => 'Murat Ergenc',
                'network' => 'Cargo Power Network (CPN)',
                'position' => 5,

            ],
            [
                'title' => 'Chair Members',
                'name' => 'Damian McCluskey',
                'network' => 'Air Cargo Group (ACG)',
                'position' => 4,

            ],

            [
                'title' => 'Chair Members',
                'name' => 'Peter Sequeira',
                'network' => 'JGC Line Network',
                'position' => 3,

            ],
            [
                'title' => 'Chair Members',
                'name' => 'Rene Lankes',
                'network' => 'WorldRing',
                'position' => 2,

            ],
            [
                'title' => 'Chair Members',
                'name' => 'Ben EL Hasnaoui',
                'network' => 'African Freight Bridge Network (AFBN Network)',
                'position' => 1,

            ],
        ]);
    }
}
