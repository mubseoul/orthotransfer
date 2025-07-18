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
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Basic patient info
            $table->integer('age');
            $table->integer('radius_willing_to_drive')->comment('In miles');
            $table->boolean('moving_temporarily')->default(false);
            
            // Current Orthodontist Information
            $table->string('current_orthodontist_name');
            $table->text('orthodontist_address');
            
            // Treatment Information
            $table->integer('original_treatment_length_months');
            $table->decimal('remaining_financial_amount', 10, 2)->comment('USD');
            
            // Doctor Type (single select)
            $table->foreignId('doctor_type_id')->nullable()->constrained()->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
}; 