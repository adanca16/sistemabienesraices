<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $cm) {}

    public function build()
    {
        return $this->subject('Nuevo contacto: '.$this->cm->subject)
            ->markdown('mail.contact.received');
    }
}
