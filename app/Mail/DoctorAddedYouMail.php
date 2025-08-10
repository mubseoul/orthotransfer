<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoctorAddedYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $doctor;

    public function __construct(User $doctor)
    {
        $this->doctor = $doctor;
    }

    public function build()
    {
        return $this->subject('A doctor added you on OrthoTransfer')
            ->view('emails.doctor-added-you');
    }
}

