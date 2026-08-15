<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRegistrationTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $tokenCode;

    public function __construct($participant, $tokenCode)
    {
        $this->participant = $participant;
        $this->tokenCode = $tokenCode;
    }

    public function build()
    {
        return $this->subject('Kode Booking / Token Pendaftaran Anda')
                    ->view('emails.registration_token'); // Buat view blade di resources/views/emails/registration_token.blade.php
    }
}
