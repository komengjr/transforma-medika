<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParticipantTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct($registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->subject('Kode Booking & QR Token Peserta')
            ->view('app-event.menu-event.data-event.email.emailparticipant_ticket'); // Menuju file resources/views/emails/participant_ticket.blade.php
    }
}
