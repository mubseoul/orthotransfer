<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'age',
        'radius_willing_to_drive',
        'moving_temporarily',
        'current_orthodontist_name',
        'orthodontist_address',
        'original_treatment_length_months',
        'remaining_financial_amount',
        'doctor_type_id',
    ];

    protected $casts = [
        'age' => 'integer',
        'radius_willing_to_drive' => 'integer',
        'moving_temporarily' => 'boolean',
        'original_treatment_length_months' => 'integer',
        'remaining_financial_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctorType()
    {
        return $this->belongsTo(DoctorType::class);
    }

    // Many-to-many relationships
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'patient_treatments');
    }

    public function functionalAppliances()
    {
        return $this->belongsToMany(FunctionalAppliance::class, 'patient_functional_appliances');
    }

    public function tads()
    {
        return $this->belongsToMany(Tad::class, 'patient_tads');
    }
} 