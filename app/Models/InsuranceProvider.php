<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceProvider extends Model
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

    public function doctorProfiles()
    {
        return $this->belongsToMany(DoctorProfile::class, 'doctor_insurance_providers');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
} 