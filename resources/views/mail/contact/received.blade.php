@component('mail::message')
# Nuevo contacto recibido

**Nombre:** {{ $cm->name }}  
**Email:** {{ $cm->email }}  
**Teléfono:** {{ $cm->phone ?: '—' }}

**Zona de interés:** {{ $cm->preferred_zone ?: '—' }}  
**Presupuesto:** {{ $cm->budget ?: '—' }}  
**Tipo de anuncio:** {{ $cm->listing_type ?: '—' }}  
**Tipo de propiedad:** {{ $cm->property_type ?: '—' }}  
**Habitaciones:** {{ $cm->bedrooms !== null ? $cm->bedrooms : '—' }}

**Asunto:** {{ $cm->subject }}

**Mensaje:**
> {{ $cm->message }}

---

_IP:_ {{ $cm->ip }}  
_Agente:_ {{ Str::limit($cm->user_agent, 200) }}

@component('mail::button', ['url' => config('app.url')])
Abrir sitio
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
