<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'admin', 'description' => 'Administrator'],
            ['role_name' => 'customer', 'description' => 'Customer'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['role_name' => $role['role_name']],
                ['description' => $role['description']]
            );
        }
    }
} 