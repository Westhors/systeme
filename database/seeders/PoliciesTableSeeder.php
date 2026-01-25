<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PoliciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $policies = [
         
            [
                'title' => 'Policy Overview',
                'slug' => Str::slug('Policy Overview'),
                'description' => '
                <p>LNF has adopted this policy to offer general guidance to its members in conducting LNF activities. This policy is not intended to be an exhaustive statement of principles but rather a general overview of applicable guidelines, designed to be amended or updated as necessary.</p>',
                'position' => 1,
            ],
            [
                'title' => 'Use of LNF Brand',
                'slug' => Str::slug('Use of LNF Brand'),
                'description' => '
                <p>The LNF logo is a registered trademark of LNF and is protected by trademark laws. Its use is strictly regulated to maintain the integrity and reputation of the brand. Here are the guidelines for the use of the LNF logo:</p>',
                'position' => 2,
            ],
            [
                'title' => 'Authorization and Usage',
                'slug' => Str::slug('Authorization and Usage'),
                'description' => '
                <ul>
                    <li><strong>Permission Required:</strong> The LNF logo must not be used in any medium without written permission from LNF.</li>
                    <li><strong>Approved Format:</strong> The logo must always be used in its approved format and cannot be altered or manipulated in any way.</li>
                    <li><strong>Membership Restriction:</strong> Only current LNF members are authorized to use the LNF logo.</li>
                </ul>',
                'position' => 3,
            ],
            [
                'title' => 'Prohibited Uses',
                'slug' => Str::slug('Prohibited Uses'),
                'description' => '
                <ul>
                    <li><strong>Non-Members:</strong> Non-members are not permitted to use the LNF logo under any circumstances.</li>
                    <li><strong>Endorsements:</strong> It is forbidden to use the LNF name and logo in a way that suggests LNF endorses or promotes services, events, or any other initiatives not explicitly authorized by LNF in writing.</li>
                </ul>',
                'position' => 4,
            ],
            [
                'title' => 'Sanctions for Irregular Use',
                'slug' => Str::slug('Sanctions for Irregular Use'),
                'description' => '
                <ul>
                    <li><strong>Infringement:</strong> Irregular use of the LNF logo may result in sanctions.</li>
                    <li><strong>Publication of Infringements:</strong> Instances of unauthorized use may be published to inform third parties of the irregularity.</li>
                </ul>',
                'position' => 5,
            ],
        ];

        DB::table('policies')->insert($policies);
    }

}
