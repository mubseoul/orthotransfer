<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPatientDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_user_id',
        'patient_user_id',
        'title',
        'comments',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_user_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_user_id');
    }
}

