<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure admin role exists (safety)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create or update admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@piphanrose.test'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'), // change later
            ]
        );

        // Assign role if not already assigned
        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
    }

