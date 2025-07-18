<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function patientProfiles()
    {
        return $this->belongsToMany(PatientProfile::class, 'patient_treatments');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
} 