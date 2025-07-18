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
        // Doctor Transfer Types (many-to-many)
        Schema::create('doctor_transfer_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('transfer_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['doctor_profile_id', 'transfer_type_id']);
        });

        // Doctor Insurance Providers (many-to-many)
        Schema::create('doctor_insurance_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('insurance_provider_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['doctor_profile_id', 'insurance_provider_id'], 'doctor_insurance_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_insurance_providers');
        Schema::dropIfExists('doctor_transfer_types');
    }
}; 