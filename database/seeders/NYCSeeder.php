<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\UserAddress;
use App\Models\PatientProfile;
use App\Models\TransferType;
use App\Models\InsuranceProvider;
use App\Models\DoctorType;

class NYCSeeder extends Seeder
{
    public function run(): void
    {
        // Seed 8+ real NYC orthodontist-like entries (simplified static list)
        $nycDoctors = [
            ['first' => 'Evan', 'last' => 'Goldman', 'email' => 'evan.goldman@nycortho.com', 'address' => ['350 5th Ave', 'New York', 'NY', '10118'], 'phone' => '(212) 555-1001', 'website' => 'https://nycortho-goldman.com'],
            ['first' => 'Priya', 'last' => 'Sharma', 'email' => 'priya.sharma@uptownbraces.com', 'address' => ['1288 Amsterdam Ave', 'New York', 'NY', '10027'], 'phone' => '(212) 555-1002', 'website' => 'https://uptownbraces.com'],
            ['first' => 'Daniel', 'last' => 'Rosen', 'email' => 'daniel.rosen@manhattanortho.com', 'address' => ['220 E 63rd St', 'New York', 'NY', '10065'], 'phone' => '(212) 555-1003', 'website' => 'https://manhattanortho.com'],
            ['first' => 'Ava', 'last' => 'Nguyen', 'email' => 'ava.nguyen@sohobites.com', 'address' => ['450 Broome St', 'New York', 'NY', '10013'], 'phone' => '(212) 555-1004', 'website' => 'https://soho-orthodontics.com'],
            ['first' => 'Mateo', 'last' => 'Garcia', 'email' => 'mateo.garcia@bkortho.com', 'address' => ['200 Montague St', 'Brooklyn', 'NY', '11201'], 'phone' => '(718) 555-2001', 'website' => 'https://bkortho.com'],
            ['first' => 'Sofia', 'last' => 'Klein', 'email' => 'sofia.klein@queensalign.com', 'address' => ['72-15 Austin St', 'Forest Hills', 'NY', '11375'], 'phone' => '(718) 555-2002', 'website' => 'https://queensalign.com'],
            ['first' => 'Noah', 'last' => 'Patel', 'email' => 'noah.patel@bronxsmiles.com', 'address' => ['2825 3rd Ave', 'Bronx', 'NY', '10455'], 'phone' => '(718) 555-2003', 'website' => 'https://bronxsmiles.com'],
            ['first' => 'Mia', 'last' => 'Hernandez', 'email' => 'mia.hernandez@statenortho.com', 'address' => ['55 Richmond Ter', 'Staten Island', 'NY', '10301'], 'phone' => '(718) 555-2004', 'website' => 'https://statenortho.com'],
        ];

        foreach ($nycDoctors as $doc) {
            $doctor = User::updateOrCreate(
                ['email' => $doc['email']],
                [
                    'first_name' => $doc['first'],
                    'last_name' => $doc['last'],
                    'password' => Hash::make('password123'),
                    'role' => 'doctor',
                    'is_approved' => true,
                    'approved_at' => now(),
                    'email_verified_at' => now(),
                ]
            );

            $profile = DoctorProfile::updateOrCreate(
                ['user_id' => $doctor->id],
                [
                    'title' => 'Dr.',
                    'phone_number' => $doc['phone'],
                    'website' => $doc['website'],
                    'bio' => 'Board-certified orthodontist serving NYC area.',
                    'minimum_monthly_payment' => 150.00,
                ]
            );

            UserAddress::updateOrCreate(
                ['user_id' => $doctor->id, 'is_current' => true],
                [
                    'label' => 'Practice',
                    'address_line_1' => $doc['address'][0],
                    'address_line_2' => null,
                    'city' => $doc['address'][1],
                    'state' => $doc['address'][2],
                    'postal_code' => $doc['address'][3],
                    'country' => 'United States',
                    'latitude' => null,
                    'longitude' => null,
                ]
            );

            // Attach some options
            $transferTypes = TransferType::inRandomOrder()->take(3)->pluck('id');
            $profile->transferTypes()->syncWithoutDetaching($transferTypes);
            $insuranceProviders = InsuranceProvider::inRandomOrder()->take(4)->pluck('id');
            $profile->insuranceProviders()->syncWithoutDetaching($insuranceProviders);
        }

        // Fake patients with profiles and random links to NYC doctors
        $patientDoctorType = DoctorType::where('name', 'Orthodontist')->first();
        for ($i = 1; $i <= 20; $i++) {
            $patient = User::updateOrCreate(
                ['email' => "patient{$i}@example.com"],
                [
                    'first_name' => fake('en_US')->firstName(),
                    'last_name' => fake('en_US')->lastName(),
                    'password' => Hash::make('password123'),
                    'role' => 'patient',
                    'is_approved' => true,
                    'approved_at' => now(),
                    'email_verified_at' => now(),
                ]
            );

            PatientProfile::updateOrCreate(
                ['user_id' => $patient->id],
                [
                    'age' => rand(12, 55),
                    'radius_willing_to_drive' => rand(5, 40),
                    'moving_temporarily' => (bool)rand(0,1),
                    'current_orthodontist_name' => null,
                    'orthodontist_address' => null,
                    'original_treatment_length_months' => rand(6, 24),
                    'remaining_financial_amount' => rand(500, 5000),
                    'doctor_type_id' => $patientDoctorType?->id,
                ]
            );

            // Randomly link to 1-2 NYC doctors with accepted status
            $docIds = User::where('role', 'doctor')->inRandomOrder()->take(rand(1,2))->pluck('id');
            foreach ($docIds as $docId) {
                DB::table('doctor_patient')->updateOrInsert(
                    ['doctor_user_id' => $docId, 'patient_user_id' => $patient->id],
                    ['status' => 'accepted', 'accepted_at' => now(), 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}

