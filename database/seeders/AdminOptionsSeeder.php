<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment;
use App\Models\FunctionalAppliance;
use App\Models\Tad;
use App\Models\DoctorType;
use App\Models\TransferType;
use App\Models\InsuranceProvider;

class AdminOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Treatments
        $treatments = [
            ['name' => 'Braces (Traditional Metal)', 'description' => 'Traditional metal braces with brackets and wires'],
            ['name' => 'Ceramic Braces', 'description' => 'Clear or tooth-colored ceramic brackets'],
            ['name' => 'Lingual Braces', 'description' => 'Braces placed on the inside of teeth'],
            ['name' => 'Clear Aligners (Invisalign)', 'description' => 'Clear, removable aligners'],
            ['name' => 'Self-Ligating Braces', 'description' => 'Braces without elastic bands'],
            ['name' => 'Retainers', 'description' => 'Devices to maintain tooth position after treatment'],
        ];

        foreach ($treatments as $treatment) {
            Treatment::create($treatment);
        }

        // Functional Appliances
        $appliances = [
            ['name' => 'Herbst Appliance', 'description' => 'Fixed appliance to correct overbite'],
            ['name' => 'Twin Block', 'description' => 'Removable appliance for jaw positioning'],
            ['name' => 'Forsus Springs', 'description' => 'Fixed appliance attached to braces'],
            ['name' => 'Headgear', 'description' => 'External appliance worn outside the mouth'],
            ['name' => 'Facemask', 'description' => 'Appliance to correct underbite'],
            ['name' => 'Palatal Expander', 'description' => 'Device to widen the upper jaw'],
            ['name' => 'MARA (Mandibular Anterior Repositioning Appliance)', 'description' => 'Fixed appliance for Class II correction'],
        ];

        foreach ($appliances as $appliance) {
            FunctionalAppliance::create($appliance);
        }

        // TADs (Temporary Anchorage Devices)
        $tads = [
            ['name' => 'Mini-implants', 'description' => 'Small titanium screws for anchorage'],
            ['name' => 'Mini-plates', 'description' => 'Flat titanium plates for complex movements'],
            ['name' => 'Onplants', 'description' => 'Disk-shaped implants on bone surface'],
            ['name' => 'Orthodontic Mini-screws', 'description' => 'Self-drilling mini-screws'],
            ['name' => 'Palatal TADs', 'description' => 'TADs placed in the palate'],
        ];

        foreach ($tads as $tad) {
            Tad::create($tad);
        }

        // Doctor Types
        $doctorTypes = [
            ['name' => 'Orthodontist', 'description' => 'Specialist in teeth and jaw alignment'],
            ['name' => 'General Dentist with Orthodontic Training', 'description' => 'General dentist with additional orthodontic certification'],
            ['name' => 'Oral and Maxillofacial Surgeon', 'description' => 'Specialist in facial and jaw surgery'],
            ['name' => 'Pediatric Dentist', 'description' => 'Specialist in children\'s dental care'],
        ];

        foreach ($doctorTypes as $doctorType) {
            DoctorType::create($doctorType);
        }

        // Transfer Types
        $transferTypes = [
            ['name' => 'Complete Case Transfer', 'description' => 'Full transfer of orthodontic treatment'],
            ['name' => 'Finishing Only', 'description' => 'Only final stages of treatment'],
            ['name' => 'Retention Only', 'description' => 'Post-treatment retention phase'],
            ['name' => 'Emergency Care', 'description' => 'Temporary emergency orthodontic care'],
            ['name' => 'Consultation Only', 'description' => 'Second opinion or consultation'],
            ['name' => 'Refinement Cases', 'description' => 'Additional refinement after initial treatment'],
        ];

        foreach ($transferTypes as $transferType) {
            TransferType::firstOrCreate(['name' => $transferType['name']], $transferType);
        }

        // Insurance Providers
        $insuranceProviders = [
            ['name' => 'Aetna', 'description' => 'Aetna dental insurance plans'],
            ['name' => 'Cigna', 'description' => 'Cigna dental insurance plans'],
            ['name' => 'Delta Dental', 'description' => 'Delta Dental insurance plans'],
            ['name' => 'MetLife', 'description' => 'MetLife dental insurance plans'],
            ['name' => 'Blue Cross Blue Shield', 'description' => 'BCBS dental insurance plans'],
            ['name' => 'Humana', 'description' => 'Humana dental insurance plans'],
            ['name' => 'Guardian', 'description' => 'Guardian dental insurance plans'],
            ['name' => 'Principal', 'description' => 'Principal dental insurance plans'],
            ['name' => 'United Healthcare', 'description' => 'United Healthcare dental insurance plans'],
            ['name' => 'Ameritas', 'description' => 'Ameritas dental insurance plans'],
            ['name' => 'No Insurance', 'description' => 'Cash payment only'],
        ];

        foreach ($insuranceProviders as $provider) {
            InsuranceProvider::firstOrCreate(['name' => $provider['name']], $provider);
        }
    }
} 