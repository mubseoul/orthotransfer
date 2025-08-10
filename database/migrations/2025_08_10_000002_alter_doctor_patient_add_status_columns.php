<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_patient', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('patient_user_id'); // pending|accepted|rejected
            $table->timestamp('accepted_at')->nullable()->after('status');
            $table->timestamp('rejected_at')->nullable()->after('accepted_at');
        });
    }

    public function down(): void
    {
        Schema::table('doctor_patient', function (Blueprint $table) {
            $table->dropColumn(['status', 'accepted_at', 'rejected_at']);
        });
    }
};

