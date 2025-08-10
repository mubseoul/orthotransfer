<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDocumentsUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $doctor;

    public function __construct(User $doctor)
    {
        $this->doctor = $doctor;
    }

    public function build()
    {
        return $this->subject('New reports uploaded by your doctor')
            ->view('emails.new-documents-uploaded');
    }
}

