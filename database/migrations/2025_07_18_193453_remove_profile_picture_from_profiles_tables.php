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
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
        });

        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('doctor_type_id');
        });

        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('minimum_monthly_payment');
        });
    }
};
