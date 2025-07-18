<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Patient Treatments (many-to-many)
        Schema::create('patient_treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('treatment_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['patient_profile_id', 'treatment_id']);
        });

        // Patient Functional Appliances (many-to-many)
        Schema::create('patient_functional_appliances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('functional_appliance_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['patient_profile_id', 'functional_appliance_id'], 'patient_appliance_unique');
        });

        // Patient TADs (many-to-many)
        Schema::create('patient_tads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('tad_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['patient_profile_id', 'tad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_tads');
        Schema::dropIfExists('patient_functional_appliances');
        Schema::dropIfExists('patient_treatments');
    }
}; 