<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        Admin::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@orthotransfer.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create additional admin for testing (optional)
        Admin::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@orthotransfer.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
