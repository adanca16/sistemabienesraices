@extends('layouts.admin')

@section('title','Contactos · '.config('app.name'))

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Mensajes de Contacto</h1>
  </div>

  {{-- Filtros --}}
  <form method="get" class="row g-2 mb-3">
    <div class="col-md-5">
      <input type="text" name="search" class="form-control"
             value="{{ request('search') }}"
             placeholder="Buscar: nombre, email, teléfono, zona, asunto, mensaje...">
    </div>
    <div class="col-md-3">
      <select name="listing_type" class="form-select">
        <option value="">Tipo anuncio (todos)</option>
        <option value="sale"     @selected(request('listing_type')==='sale')>Venta</option>
        <option value="rent"     @selected(request('listing_type')==='rent')>Alquiler</option>
        <option value="presale"  @selected(request('listing_type')==='presale')>Preventa</option>
        <option value="project"  @selected(request('listing_type')==='project')>Proyecto</option>
      </select>
    </div>
    <div class="col-md-3">
      <input type="text" name="property_type" class="form-control"
             value="{{ request('property_type') }}"
             placeholder="Tipo de propiedad (ej: Casa, Lote...)">
    </div>
    <div class="col-md-1 d-grid">
      <button class="btn btn-outline-secondary">Filtrar</button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-hover align-middle bg-white">
      <thead class="table-light">
        <tr>
          <th>Fecha</th>
          <th>Nombre</th>
          <th>Email / Teléfono</th>
          <th>Zona</th>
          <th>Presupuesto</th>
          <th>Anuncio / Propiedad</th>
          <th>Asunto</th>
          <th>Mensaje</th>
          <th>IP</th>
          <th>UA</th>
        </tr>
      </thead>
      <tbody>
        @forelse($messages as $m)
          <tr>
            <td class="text-nowrap">{{ $m->created_at?->format('Y-m-d H:i') }}</td>
            <td class="fw-semibold">{{ $m->name }}</td>
            <td>
              <div>{{ $m->email }}</div>
              @if($m->phone)<div class="text-muted small">{{ $m->phone }}</div>@endif
            </td>
            <td>{{ $m->preferred_zone ?: '—' }}</td>
            <td>{{ $m->budget ?: '—' }}</td>
            <td class="text-nowrap">
              {{ $m->listing_type ?: '—' }} /
              {{ $m->property_type ?: '—' }}
              @if(!is_null($m->bedrooms))<div class="small text-muted">{{ $m->bedrooms }} hab</div>@endif
            </td>
            <td class="text-nowrap">{{ \Illuminate\Support\Str::limit($m->subject, 40) }}</td>
            <td>{{ \Illuminate\Support\Str::limit($m->message, 80) }}</td>
            <td class="text-nowrap">{{ $m->ip ?: '—' }}</td>
            <td class="small text-truncate" style="max-width:220px" title="{{ $m->user_agent }}">
              {{ $m->user_agent ?: '—' }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="10" class="text-center text-muted py-4">No hay mensajes.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $messages->links() }}
  </div>
@endsection
