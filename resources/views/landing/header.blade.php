<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="shortcut icon" href="{{asset('icono.png')}}" type="image/x-icon">

  <title>{{ config('app.site', config('app.name')) }} — Venta de Bienes Raíces en Costa Rica</title>

    @yield('headerMetadata')
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    crossorigin="anonymous" />

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    referrerpolicy="no-referrer" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />

  <style>
    #hero {
    padding: 7rem 0 4rem;
    background: url('{{asset("uploads/cover.png")}}') center/cover no-repeat;
    position: relative;
    color: #fff;
}
  </style>
  </head>

<body>
  {{-- NAVBAR --}}
  <nav id="navbar" class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('homePage') }}">
        <i class="fa-solid fa-house-chimney"></i> {{ config('app.site', config('app.name')) }}
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('homePage')}}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('homePage')}}#new-arrivals">Otras</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('homePage')}}#products">Nuevas</a></li>
   
          <li class="nav-item"><a class="nav-link" href="{{route('homePage')}}#categories">Categorías</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('homePage')}}#about">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('homePage')}}#contactForm">Contáctenos</a></li>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-primary" href="{{route('homePage')}}#products"><i class="fa-solid fa-magnifying-glass"></i> Buscar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- HERO + BUSCADOR --}}
  <section id="hero">
    <div class="container">
      <div class="row g-3 align-items-end">
        <div class="col-lg-7">
          <h1 class="display-5">Encuentre su próxima propiedad con nosotros</h1>
          <p class="lead mb-4">
            Lotes, casas, apartamentos y más. Publicaciones verificadas, ubicación precisa y asesoría durante todo el proceso.
          </p>
        </div>
        <div class="col-lg-5">
          <form action="{{ route('homePage') }}" method="get" class="search-card">
            <div class="search-grid">
              <input type="text" class="form-control" name="search" placeholder="Provincia, cantón, folio real, palabra clave…" value="{{ request('search') }}">
              <select name="listing_type" class="form-select">
                <option value="">Tipo de anuncio</option>
                <option value="sale" @selected(request('listing_type')==='sale' )>Venta</option>
                <option value="rent" @selected(request('listing_type')==='rent' )>Alquiler</option>
                <option value="presale" @selected(request('listing_type')==='presale' )>Preventa</option>
                <option value="project" @selected(request('listing_type')==='project' )>Proyecto</option>

              </select>
              <select name="property_type" class="form-select">
                <option value="">Tipo de propiedad</option>
                <option @selected(request('property_type')==='Casa' )>Casa</option>
                <option @selected(request('property_type')==='Lote' )>Lote</option>
                <option @selected(request('property_type')==='Apartamento' )>Apartamento</option>
                <option @selected(request('property_type')==='Bodega' )>Bodega</option>
                <option @selected(request('property_type')==='Oficina' )>Oficina</option>
                <option @selected(request('property_type')==='Local comercial' )>Local comercial</option>
              </select>
              <button class="btn btn-primary"><i class="fa-solid fa-search me-2"></i>Buscar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>