<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Reserva registrada</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; margin:0; background:#f7fafc; color:#111827}
    .container{max-width: 800px; margin: 24px auto; padding: 16px}
    .card{background:#fff; border:1px solid #e5e7eb; border-radius: 12px; padding: 24px; text-align:center}
    .title{font-size: 22px; font-weight: 800; margin: 0 0 12px}
    .muted{color:#6b7280}
    .btn{display:inline-block; margin-top:14px; padding:10px 16px; border-radius:10px; background:#2563eb; color:#fff; text-decoration:none; font-weight:600}
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h1 class="title">¡Gracias! Tu reserva fue registrada.</h1>
      @if($reservationId)
        <p class="muted">Código de reserva: <strong>#{{ $reservationId }}</strong></p>
      @endif
      <p class="muted">Pronto te contactaremos para confirmar los detalles.</p>
      <a class="btn" href="{{route('homePage')}}">Ir al inicio</a>
    </div>
  </div>
</body>
</html>
