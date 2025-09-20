<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $cm) {}

    public function build()
    {
        return $this->subject('Hemos recibido su solicitud')
            ->markdown('mail.contact.autoreply');
    }
}
