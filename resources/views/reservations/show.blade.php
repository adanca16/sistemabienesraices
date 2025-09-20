@extends('layouts.admin')

@section('title','Detalle de Reserva · '.config('app.name'))

@section('content')
<div class="col p-0">
    <div class="card p-4">
        <h1 class="mb-3">Detalle de la reserva #{{ $reservation->id }}</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <ul class="list-unstyled mb-4">
            <li><strong>Propiedad:</strong> {{ $reservation->property->title }}</li>
            <li><strong>Interesado:</strong> {{ $reservation->interested_name }}</li>
            <li><strong>Email:</strong> {{ $reservation->interested_email ?? '—' }}</li>
            <li><strong>Teléfono:</strong> {{ $reservation->interested_phone ?? '—' }}</li>
            <li><strong>Fecha y hora:</strong> {{ $reservation->reserved_at->format('d/m/Y H:i') }}</li>
            <li><strong>Duración:</strong> {{ $reservation->duration_minutes }} minutos</li>
            <li><strong>Tipo:</strong> {{ ucfirst($reservation->type) }}</li>
            <li><strong>Estado actual:</strong> 
                @switch($reservation->status)
                    @case('pending') Pendiente @break
                    @case('confirmed') Confirmada @break
                    @case('cancelled') Cancelada @break
                @endswitch
            </li>
            @if($reservation->notes)
                <li><strong>Notas:</strong> {{ $reservation->notes }}</li>
            @endif
        </ul>

        <form action="{{ route('reservations.update',$reservation) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="status" class="form-label">Cambiar estado:</label>
                <select name="status" id="status" class="form-select">
                    <option value="pending"   @selected($reservation->status==='pending')>Pendiente</option>
                    <option value="confirmed" @selected($reservation->status==='confirmed')>Confirmada</option>
                    <option value="cancelled" @selected($reservation->status==='cancelled')>Cancelada</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</div>
@endsection
