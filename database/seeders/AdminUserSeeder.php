<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();
        
        try {
            // Create roles if they don't exist
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

            // Create admin user
            $admin = User::updateOrCreate(
                ['email' => 'admin@drunkies.com'],
                [
                    'username' => 'admin',
                    'first_name' => 'Admin',
                    'last_name' => 'User',
                    'password' => Hash::make('admin123'),
                    'birthdate' => '1990-01-01',
                    'name' => 'Admin User',
                    'email_verified_at' => now()
                ]
            );

            // Attach admin role if not already attached
            $adminRole = Role::where('role_name', 'admin')->first();
            if (!$admin->roles()->where('roles.role_id', $adminRole->role_id)->exists()) {
                $admin->roles()->attach($adminRole->role_id);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
} 