@component('mail::message')
# ¡Gracias por contactarnos, {{ $cm->name }}!

Hemos recibido su solicitud con el asunto **“{{ $cm->subject }}”**.  
Un asesor se comunicará con usted a la brevedad.

**Resumen enviado:**
- Zona de interés: {{ $cm->preferred_zone ?: '—' }}
- Presupuesto: {{ $cm->budget ?: '—' }}
- Tipo de anuncio: {{ $cm->listing_type ?: '—' }}
- Tipo de propiedad: {{ $cm->property_type ?: '—' }}
- Habitaciones: {{ $cm->bedrooms !== null ? $cm->bedrooms : '—' }}

**Mensaje:**
> {{ $cm->message }}

Si necesita actualizar sus datos, simplemente responda a este correo.

Saludos,  
**{{ config('app.name') }}**
@endcomponent
