<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $roles = [
            [
                'id' => 1,
                'name' => 'Super Administrator',
            ],
            [
                'id' => 2,
                'name' => 'Administrator',
            ],
            [
                'id' => 3,
                'name' => 'Technical Support',
            ],
            [
                'id' => 4,
                'name' => 'Account Manager',
            ],
            [
                'id' => 5,
                'name' => 'Content Creator',
            ],
            [
                'id' => 6,
                'name' => 'Financial Officer',
            ],
        ];

        foreach ($roles as $role) {
            Role::create(array_merge($role, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
