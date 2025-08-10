<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\UserAddress;
use App\Models\TransferType;
use App\Models\InsuranceProvider;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'user' => [
                    'first_name' => 'Sarah',
                    'last_name' => 'Johnson',
                    'email' => 'sarah.johnson@orthodentistry.com',
                    'role' => 'doctor',
                    'is_approved' => true,
                    'approved_at' => now(),
                ],
                'profile' => [
                    'title' => 'Dr.',
                    'phone_number' => '(555) 123-4567',
                    'website' => 'https://www.johnsonortho.com',
                    'bio' => 'Dr. Sarah Johnson is a board-certified orthodontist with over 15 years of experience specializing in adult orthodontics and clear aligner treatments. She graduated from Harvard School of Dental Medicine and completed her orthodontic residency at UCLA.',
                    'minimum_monthly_payment' => 150.00,
                ],
                'address' => [
                    'label' => 'Practice Office',
                    'address_line_1' => '123 Main Street',
                    'address_line_2' => 'Suite 200',
                    'city' => 'Beverly Hills',
                    'state' => 'CA',
                    'postal_code' => '90210',
                    'country' => 'United States',
                    'latitude' => 34.0736,
                    'longitude' => -118.4004,
                    'is_current' => true,
                ],
                'transfer_types' => ['Complete Case Transfer', 'Finishing Only', 'Refinement Cases'],
                'insurance_providers' => ['Aetna', 'Cigna', 'Delta Dental', 'Blue Cross Blue Shield', 'MetLife'],
            ],
            [
                'user' => [
                    'first_name' => 'Michael',
                    'last_name' => 'Chen',
                    'email' => 'michael.chen@pediatricortho.com',
                    'role' => 'doctor',
                    'is_approved' => true,
                    'approved_at' => now(),
                ],
                'profile' => [
                    'title' => 'Dr.',
                    'phone_number' => '(555) 234-5678',
                    'website' => 'https://www.chenorthodontics.com',
                    'bio' => 'Dr. Michael Chen is a pediatric orthodontist with expertise in early intervention and interceptive orthodontics. He has been practicing for 12 years and is passionate about creating positive experiences for young patients.',
                    'minimum_monthly_payment' => 125.00,
                ],
                'address' => [
                    'label' => 'Children\'s Orthodontic Center',
                    'address_line_1' => '456 Oak Avenue',
                    'address_line_2' => '',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'postal_code' => '94102',
                    'country' => 'United States',
                    'latitude' => 37.7749,
                    'longitude' => -122.4194,
                    'is_current' => true,
                ],
                'transfer_types' => ['Complete Case Transfer', 'Emergency Care', 'Consultation Only'],
                'insurance_providers' => ['Delta Dental', 'Humana', 'Guardian', 'United Healthcare'],
            ],
            [
                'user' => [
                    'first_name' => 'Jennifer',
                    'last_name' => 'Williams',
                    'email' => 'jennifer.williams@modernortho.com',
                    'role' => 'doctor',
                    'is_approved' => true,
                    'approved_at' => now(),
                ],
                'profile' => [
                    'title' => 'Dr.',
                    'phone_number' => '(555) 345-6789',
                    'website' => 'https://www.modernorthodontics.com',
                    'bio' => 'Dr. Jennifer Williams combines cutting-edge technology with personalized care. She specializes in Invisalign treatments and digital orthodontics, serving patients of all ages with the latest innovations in orthodontic care.',
                    'minimum_monthly_payment' => 175.00,
                ],
                'address' => [
                    'label' => 'Modern Orthodontics',
                    'address_line_1' => '789 Tech Boulevard',
                    'address_line_2' => 'Floor 3',
                    'city' => 'Palo Alto',
                    'state' => 'CA',
                    'postal_code' => '94301',
                    'country' => 'United States',
                    'latitude' => 37.4419,
                    'longitude' => -122.1430,
                    'is_current' => true,
                ],
                'transfer_types' => ['Complete Case Transfer', 'Finishing Only', 'Refinement Cases', 'Consultation Only'],
                'insurance_providers' => ['Aetna', 'Cigna', 'Blue Cross Blue Shield', 'MetLife', 'Principal'],
            ],
            [
                'user' => [
                    'first_name' => 'Robert',
                    'last_name' => 'Davis',
                    'email' => 'robert.davis@familyortho.com',
                    'role' => 'doctor',
                    'is_approved' => true,
                    'approved_at' => now(),
                ],
                'profile' => [
                    'title' => 'Dr.',
                    'phone_number' => '(555) 456-7890',
                    'website' => 'https://www.familyorthodontics.com',
                    'bio' => 'Dr. Robert Davis is a family orthodontist who treats patients from age 7 to 70. With 20 years of experience, he offers comprehensive orthodontic care including traditional braces, clear aligners, and surgical orthodontics.',
                    'minimum_monthly_payment' => 100.00,
                ],
                'address' => [
                    'label' => 'Family Orthodontics Center',
                    'address_line_1' => '321 Family Way',
                    'address_line_2' => '',
                    'city' => 'Sacramento',
                    'state' => 'CA',
                    'postal_code' => '95814',
                    'country' => 'United States',
                    'latitude' => 38.5816,
                    'longitude' => -121.4944,
                    'is_current' => true,
                ],
                'transfer_types' => ['Complete Case Transfer', 'Finishing Only', 'Retention Only', 'Emergency Care'],
                'insurance_providers' => ['Delta Dental', 'Cigna', 'Humana', 'Guardian', 'Ameritas'],
            ],
            [
                'user' => [
                    'first_name' => 'Lisa',
                    'last_name' => 'Martinez',
                    'email' => 'lisa.martinez@eliteortho.com',
                    'role' => 'doctor',
                    'is_approved' => true,
                    'approved_at' => now(),
                ],
                'profile' => [
                    'title' => 'Dr.',
                    'phone_number' => '(555) 567-8901',
                    'website' => 'https://www.eliteorthodontics.com',
                    'bio' => 'Dr. Lisa Martinez is known for her expertise in complex orthodontic cases and surgical orthodontics. She works closely with oral surgeons to provide comprehensive treatment for patients requiring combined orthodontic and surgical intervention.',
                    'minimum_monthly_payment' => 200.00,
                ],
                'address' => [
                    'label' => 'Elite Orthodontics',
                    'address_line_1' => '567 Medical Plaza',
                    'address_line_2' => 'Building A, Suite 150',
                    'city' => 'Los Angeles',
                    'state' => 'CA',
                    'postal_code' => '90028',
                    'country' => 'United States',
                    'latitude' => 34.0522,
                    'longitude' => -118.2437,
                    'is_current' => true,
                ],
                'transfer_types' => ['Complete Case Transfer', 'Consultation Only', 'Refinement Cases'],
                'insurance_providers' => ['Aetna', 'Blue Cross Blue Shield', 'MetLife', 'United Healthcare', 'Principal'],
            ],
            [
                'user' => [
                    'first_name' => 'David',
                    'last_name' => 'Thompson',
                    'email' => 'david.thompson@coastalortho.com',
                    'role' => 'doctor',
                    'is_approved' => false, // This doctor is pending approval
                    'approved_at' => null,
                ],
                'profile' => [
                    'title' => 'Dr.',
                    'phone_number' => '(555) 678-9012',
                    'website' => 'https://www.coastalorthodontics.com',
                    'bio' => 'Dr. David Thompson recently relocated from the East Coast and is establishing his practice in California. He brings 8 years of experience in general orthodontics and is particularly skilled in lingual braces and accelerated orthodontics.',
                    'minimum_monthly_payment' => 140.00,
                ],
                'address' => [
                    'label' => 'Coastal Orthodontics',
                    'address_line_1' => '890 Oceanview Drive',
                    'address_line_2' => '',
                    'city' => 'Santa Monica',
                    'state' => 'CA',
                    'postal_code' => '90401',
                    'country' => 'United States',
                    'latitude' => 34.0195,
                    'longitude' => -118.4912,
                    'is_current' => true,
                ],
                'transfer_types' => ['Complete Case Transfer', 'Finishing Only'],
                'insurance_providers' => ['Aetna', 'Cigna', 'Delta Dental'],
            ],
        ];

        foreach ($doctors as $doctorData) {
            // Create user
            $user = User::create([
                'first_name' => $doctorData['user']['first_name'],
                'last_name' => $doctorData['user']['last_name'],
                'email' => $doctorData['user']['email'],
                'password' => Hash::make('password123'),
                'role' => $doctorData['user']['role'],
                'is_approved' => $doctorData['user']['is_approved'],
                'approved_at' => $doctorData['user']['approved_at'],
                'email_verified_at' => now(),
            ]);

            // Create doctor profile
            $profile = DoctorProfile::create([
                'user_id' => $user->id,
                'title' => $doctorData['profile']['title'],
                'phone_number' => $doctorData['profile']['phone_number'],
                'website' => $doctorData['profile']['website'],
                'bio' => $doctorData['profile']['bio'],
                'minimum_monthly_payment' => $doctorData['profile']['minimum_monthly_payment'],
            ]);

            // Create address
            UserAddress::create([
                'user_id' => $user->id,
                'label' => $doctorData['address']['label'],
                'address_line_1' => $doctorData['address']['address_line_1'],
                'address_line_2' => $doctorData['address']['address_line_2'],
                'city' => $doctorData['address']['city'],
                'state' => $doctorData['address']['state'],
                'postal_code' => $doctorData['address']['postal_code'],
                'country' => $doctorData['address']['country'],
                'latitude' => $doctorData['address']['latitude'],
                'longitude' => $doctorData['address']['longitude'],
                'is_current' => $doctorData['address']['is_current'],
            ]);

            // Associate transfer types
            $transferTypes = TransferType::whereIn('name', $doctorData['transfer_types'])->get()->unique('id');
            $profile->transferTypes()->syncWithoutDetaching($transferTypes->pluck('id'));

            // Associate insurance providers
            $insuranceProviders = InsuranceProvider::whereIn('name', $doctorData['insurance_providers'])->get()->unique('id');
            $profile->insuranceProviders()->syncWithoutDetaching($insuranceProviders->pluck('id'));
        }

        $this->command->info('Doctor seeder completed! Created ' . count($doctors) . ' doctors.');
        $this->command->info('Note: Dr. David Thompson is pending approval and will need admin approval to be active.');
    }
} 