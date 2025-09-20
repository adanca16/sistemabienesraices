<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Reservar visita a propiedad {{$product->title}}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Estilos mínimos --}}
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
 <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    crossorigin="anonymous" />
    
  <style>
    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      margin: 0;
      background: #f7fafc;
      color: #111827
    }

    .container {
      max-width: 900px;
      margin: 24px auto;
      padding: 16px
    }

    .card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 24px
    }

    .grid {
      display: grid;
      gap: 16px
    }

    .grid-2 {
      grid-template-columns: 1fr 1fr
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 4px
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #fff
    }

    .actions {
      display: flex;
      gap: 12px;
      margin-top: 8px
    }

    .btn {
      padding: 10px 16px;
      border-radius: 10px;
      border: none;
      cursor: pointer;
      font-weight: 600
    }

    .btn-primary {
      background: #2563eb;
      color: white
    }

    .help {
      font-size: 12px;
      color: #6b7280
    }

    .error {
      color: #b91c1c;
      font-size: 14px;
      margin-top: 4px
    }

    .title {
      font-size: 22px;
      font-weight: 700;
      margin: 0 0 12px
    }

    .muted {
      font-size: 14px;
      color: #6b7280;
      margin-bottom: 18px
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">
      <h1 class="title">Reservar cita para visitar un inmueble</h1>
      @if ($errors->any())
      <div style="background:#fef2f2; border:1px solid #fecaca; padding:12px; border-radius:8px; margin-bottom:16px">
        <strong>Corrige los siguientes campos:</strong>
        <ul style="margin:8px 0 0 18px">
          @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('reservations.store') }}">
        @csrf
        <div class="container p-2 mt-0">
          <div class="row">
            <div class="col p-1">
          {{-- Propiedad --}}
          <div class="col-12">

            <div class="col-12">
              @if($product->coverPhoto)
              <img class="img-fluid d-block mx-auto" id="mainImage" src="{{ $product->coverPhoto->publicUrl() }}" alt="{{ $product->title }}">
              @elseif($product->photos->count())
              <img class="img-fluid d-block mx-auto" id="mainImage" src="{{ $product->photos->first()->publicUrl() }}" alt="{{ $product->title }}">
              @endif
            </div>
            <label for="property_id">{{$product->title}}</label>
             <p>{{$product->summary}}</p>
               <p>{{$product->description}}</p>
               
            <input id="property_id" name="property_id" value="{{$propertyId}}" style="display: none;">

          </div>

          {{-- Tipo --}}
          <div class="col-12">
            <label for="type">Tipo de reservación</label>
            <select id="type" name="type" required class="form-control">
              @php $types = ['visit' => 'Visita presencial', 'virtual' => 'Visita virtual', 'call' => 'Llamada']; @endphp
              <option value="">Seleccione…</option>
              @foreach($types as $val => $label)
              <option value="{{ $val }}" @selected(old('type')===$val)>{{ $label }}</option>
              @endforeach
            </select>
            @error('type') <div class="error">{{ $message }}</div> @enderror
          </div>

          {{-- Nombre --}}
          <div class="col-12">
            <label for="interested_name">Nombre completo</label>
            <input id="interested_name" name="interested_name" type="text" value="{{ old('interested_name') }}" required>
            @error('interested_name') <div class="error">{{ $message }}</div> @enderror
          </div>

          {{-- Email --}}
          <div class="col-12">
            <label for="interested_email">Correo electrónico</label>
            <input id="interested_email" name="interested_email" type="email" value="{{ old('interested_email') }}">
            @error('interested_email') <div class="error">{{ $message }}</div> @enderror
          </div>

          {{-- Teléfono --}}
          <div class="col-12">
            <label for="interested_phone">Teléfono</label>
            <input id="interested_phone" name="interested_phone" type="text" value="{{ old('interested_phone') }}">
            @error('interested_phone') <div class="error">{{ $message }}</div> @enderror
          </div>

          {{-- Calendario (fecha y hora) --}}
          <div class="col-12">
            <label for="reserved_at">Fecha y hora</label>
            <input id="reserved_at" name="reserved_at" type="text" placeholder="Selecciona fecha y hora" value="{{ old('reserved_at') }}" required>
            <div class="help">Usa el calendario para elegir la fecha y hora de la visita.</div>
            @error('reserved_at') <div class="error">{{ $message }}</div> @enderror
          </div>

          {{-- Duración --}}
          <div>
            <label for="duration_minutes">Duración (minutos)</label>
            <input id="duration_minutes" name="duration_minutes" type="number" min="15" max="240" step="15" value="{{ old('duration_minutes', 30) }}">
            @error('duration_minutes') <div class="error">{{ $message }}</div> @enderror
          </div>

          {{-- Notas --}}
          <div class="grid-2" style="grid-column: 1 / -1">
            <div class="col-12">
              <label for="notes">Notas</label>
              <textarea id="notes" name="notes" rows="4" placeholder="Comentarios adicionales…">{{ old('notes') }}</textarea>
            </div>
          </div>
        </div>

          </div>
        </div>
        <div class="actions">
          <button class="btn btn-primary" type="submit">Reservar cita</button>
          <a class="btn" href="{{ url()->previous() }}">Cancelar</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#reserved_at", {
      enableTime: true,
      time_24hr: true,
      minuteIncrement: 15,
      dateFormat: "Y-m-d H:i:S", // Laravel parsea bien este formato
      minDate: "today",
      defaultHour: 9,
      disableMobile: true
    });
  </script>
</body>

</html>