<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactAutoReply;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function send(ContactRequest $request)
    {
        // Guardar
        $cm = ContactMessage::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'preferred_zone' => $request->preferred_zone,
            'budget'         => $request->budget,
            'listing_type'   => $request->listing_type,
            'property_type'  => $request->property_type,
            'bedrooms'       => $request->bedrooms,
            'subject'        => $request->subject,
            'message'        => $request->message,
            'ip'             => $request->ip(),
            'user_agent'     => substr((string) request()->userAgent(), 0, 500),
        ]);

        // Email al admin
        $toAdmin = config('mail.contact_to') ?? config('mail.from.address');
        if ($toAdmin) {
            Mail::to($toAdmin)
            ->cc(['adanca16@gmail.com'])
            ->send(new ContactMessageReceived($cm));
        }

        // Autorespuesta al cliente
        Mail::to($cm->email)->send(new ContactAutoReply($cm));

        return back()->with('ok', '¡Gracias! Hemos recibido su mensaje y le contactaremos pronto.');
    }
}
