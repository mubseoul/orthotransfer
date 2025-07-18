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
        // Create admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@orthotransfer.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_approved' => true,
            'approved_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Seed admin options and admin users
        $this->call([
            AdminOptionsSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
