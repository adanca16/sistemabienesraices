<!doctype html>
<html lang="es" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.site').' · Panel')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  
  <link rel="shortcut icon" href="{{asset('icono.png')}}" type="image/x-icon">
  @stack('head')
  <style>
    body{background:#f8f9fa}
    .app-shell{min-height:100vh; display:flex; flex-direction:column;}
    .app-main{flex:1 1 auto}
    .sidebar{
      background:#fff; border-right:1px solid rgba(0,0,0,.05);
      position:sticky; top:0; height:100dvh; padding-top:1rem;
    }
    .sidebar .nav-link{color:#374151}
    .sidebar .nav-link.active{
      background:#e7f1ff; color:#0d6efd; font-weight:600;
    }
    .brand{font-weight:700}
    @media (max-width: 991.98px){
      .sidebar{height:auto; position:static; border-right:0; border-bottom:1px solid rgba(0,0,0,.05)}
    }
  </style>
</head>
<body>
<div class="app-shell">
  {{-- Navbar superior (opcional) --}}
  <nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container-fluid">
      <a class="navbar-brand brand" href="{{ route('products.index') }}">{{ config('app.site') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="topNav">
        <ul class="navbar-nav ms-auto">
          @yield('top-actions')
        </ul>
      </div>
    </div>
  </nav>

  {{-- Contenedor con sidebar izquierda + contenido --}}
  <div class="container-fluid app-main">
    <div class="row">
      <aside class="col-12 col-lg-3 col-xl-2 sidebar">
        @include('partials.sidebar') {{-- <= Parcial reutilizable --}}
      </aside>

      <main class="col-12 col-lg-9 col-xl-10 py-4">
        <div class="container-fluid">
          @yield('content') {{-- <= Contenido de cada vista --}}
        </div>
      </main>
    </div>
  </div>

  <footer class="bg-white border-top py-3 text-center small text-muted">
    © {{ date('Y') }} {{ config('app.site') }} — Panel Administrativo
    <br>
    Desarrollado por <a href="https://wa.me/50685666738">Adan Carranza Alfaro</a>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
