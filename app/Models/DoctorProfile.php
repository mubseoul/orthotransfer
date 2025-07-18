<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'phone_number',
        'website',
        'bio',
        'minimum_monthly_payment',
    ];

    protected $casts = [
        'minimum_monthly_payment' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-many relationships
    public function transferTypes()
    {
        return $this->belongsToMany(TransferType::class, 'doctor_transfer_types');
    }

    public function insuranceProviders()
    {
        return $this->belongsToMany(InsuranceProvider::class, 'doctor_insurance_providers');
    }


} 