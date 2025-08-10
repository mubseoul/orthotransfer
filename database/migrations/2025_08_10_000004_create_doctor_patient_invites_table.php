<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_patient_invites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_user_id')->constrained('users')->onDelete('cascade');
            $table->string('invite_email');
            $table->string('status')->default('sent'); // sent|converted|cancelled
            $table->timestamps();

            $table->unique(['doctor_user_id', 'invite_email']);
            $table->index('invite_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_patient_invites');
    }
};

