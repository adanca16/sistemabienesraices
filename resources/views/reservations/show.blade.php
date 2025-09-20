@extends('layouts.admin')

@section('title', 'Detalle de Reserva · '.config('app.name'))

@section('content')
<div class="col p-0">
  <div class="card p-4">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
      <h1 class="mb-3 mb-lg-0 h4">Detalle de la reserva #{{ $reservation->id }}</h1>
      {{-- Estado como badge --}}
      @php
        $badgeMap = [
          'pending'   => ['label' => 'Pendiente',  'class' => 'bg-warning text-dark'],
          'confirmed' => ['label' => 'Confirmada', 'class' => 'bg-success'],
          'cancelled' => ['label' => 'Cancelada',  'class' => 'bg-danger'],
        ];
        $b = $badgeMap[$reservation->status] ?? ['label'=>'N/D','class'=>'bg-secondary'];
      @endphp
      <span class="badge {{ $b['class'] }} align-self-center px-3 py-2">{{ $b['label'] }}</span>
    </div>

    @if (session('success'))
      <div class="alert alert-success mt-3" role="alert">
        {{ session('success') }}
      </div>
    @endif

    {{-- Datos de la reserva --}}
    <div class="row g-3 mt-2">
      <div class="col-12 col-lg-6">
        <ul class="list-unstyled mb-0">
          <li class="mb-1"><strong>Propiedad:</strong> {{ $reservation->property->title }}</li>
          <li class="mb-1"><strong>Interesado:</strong> {{ $reservation->interested_name }}</li>
          <li class="mb-1"><strong>Email:</strong> {{ $reservation->interested_email ?? '—' }}</li>
          <li class="mb-1"><strong>Teléfono:</strong> {{ $reservation->interested_phone ?? '—' }}</li>
        </ul>
      </div>
      <div class="col-12 col-lg-6">
        <ul class="list-unstyled mb-0">
          <li class="mb-1"><strong>Fecha y hora:</strong> {{ $reservation->reserved_at->format('d/m/Y H:i') }}</li>
          <li class="mb-1"><strong>Duración:</strong> {{ $reservation->duration_minutes }} minutos</li>
          <li class="mb-1"><strong>Tipo:</strong> {{ ucfirst($reservation->type) }}</li>
          <li class="mb-1">
            <strong>Estado actual:</strong> {{ $b['label'] }}
          </li>
        </ul>
      </div>
    </div>

    @if ($reservation->notes)
      <div class="mt-3">
        <strong>Notas:</strong>
        <p class="mb-0">{{ $reservation->notes }}</p>
      </div>
    @endif

    <hr class="my-4">

    {{-- Acciones: actualizar estado / volver / eliminar --}}
    <div class="d-flex flex-wrap align-items-end gap-2">

      {{-- Form: actualizar estado --}}
      <form action="{{ route('reservations.update', $reservation) }}" method="POST" class="d-flex flex-wrap align-items-end gap-2">
        @csrf
        @method('PATCH')

        <div class="mb-0 me-2">
          <label for="status" class="form-label mb-1">Cambiar estado</label>
          <select name="status" id="status" class="form-select form-select-sm" aria-label="Cambiar estado de la reserva">
            <option value="pending"   @selected($reservation->status==='pending')>Pendiente</option>
            <option value="confirmed" @selected($reservation->status==='confirmed')>Confirmada</option>
            <option value="cancelled" @selected($reservation->status==='cancelled')>Cancelada</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Guardar cambios</button>
      </form>

      <a href="{{ route('reservations.index') }}" class="btn btn-secondary btn-sm">Volver</a>

      {{-- Form: eliminar --}}
      <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST"
            class="d-inline"
            onsubmit="return confirm('¿Seguro que desea eliminar esta reserva?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="btn btn-danger btn-sm"
                @disabled($reservation->status === 'cancelled')  {{-- opcional: deshabilitar si ya está cancelada --}}
                aria-disabled="{{ $reservation->status === 'cancelled' ? 'true' : 'false' }}">
          Eliminar
        </button>
      </form>
    </div>

  </div>
</div>
@endsection
