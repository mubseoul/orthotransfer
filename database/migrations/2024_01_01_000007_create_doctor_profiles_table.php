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
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Professional Information
            $table->string('title')->nullable()->comment('Dr., MD, etc.');
            $table->string('phone_number');
            $table->string('website')->nullable();
            $table->text('bio')->nullable();
            
            // Financial Information
            $table->decimal('minimum_monthly_payment', 10, 2)->comment('Minimum monthly payment accepted in USD');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
}; 