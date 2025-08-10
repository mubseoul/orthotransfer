<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'is_approved',
        'approved_at',
        'approved_by',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    // Role checking methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    // Relationships
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function currentAddress()
    {
        return $this->hasOne(UserAddress::class)->where('is_current', true);
    }

    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class);
    }

    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class);
    }

    // Admin who approved this user (for doctors)
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Users approved by this admin
    public function approvedUsers()
    {
        return $this->hasMany(User::class, 'approved_by');
    }

    // Doctor ↔ Patients many-to-many
    public function patients()
    {
        return $this->belongsToMany(User::class, 'doctor_patient', 'doctor_user_id', 'patient_user_id')
                    ->withTimestamps()
                    ->where('users.role', 'patient');
    }

    public function doctors()
    {
        return $this->belongsToMany(User::class, 'doctor_patient', 'patient_user_id', 'doctor_user_id')
                    ->withTimestamps()
                    ->where('users.role', 'doctor');
    }

    // Full name accessor
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the profile picture URL
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Return a default avatar if no profile picture
        return asset('images/default-avatar.svg');
    }
}
