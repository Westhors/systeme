<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'Super Admin',
            'Admin',
            'Manager',
            'Accountant',
            'Sales',
            'Purchasing',
            'Warehouse',
            'HR',
            'Cashier',
            'Customer Support',
            'Viewer'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
