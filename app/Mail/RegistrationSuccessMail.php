<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $participantName;
    public $eventName;
    public $registrations; // Berisi array detail registrasi (sub event, kelas, kode, token)

    public function __construct($participantName, $eventName, array $registrations)
    {
        $this->participantName = $participantName;
        $this->eventName = $eventName;
        $this->registrations = $registrations;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pendaftaran - ' . $this->eventName)
            ->view('emails.registration_success');
    }
}
