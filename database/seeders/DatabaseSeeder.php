<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure single admin user in users table for app login as well
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_approved' => true,
                'approved_at' => now(),
                'email_verified_at' => now(),
            ]
        );

        // Seed admin options and admin users
        $this->call([
            AdminOptionsSeeder::class,
            AdminSeeder::class,
            DoctorSeeder::class,
            NYCSeeder::class,
        ]);
    }
}
