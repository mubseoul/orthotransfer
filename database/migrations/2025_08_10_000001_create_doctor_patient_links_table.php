<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_patient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['doctor_user_id', 'patient_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_patient');
    }
};

