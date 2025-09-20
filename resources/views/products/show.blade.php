@extends('layouts.admin')

@section('title', $product->title.' · '.config('app.site'))

{{-- Acciones en la barra superior --}}
@section('top-actions')
  <li class="nav-item">
    <a class="nav-link" href="{{ route('products.index') }}">
      <i class="bi bi-card-list me-1"></i> Listado
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('products.edit', $product) }}">
      <i class="bi bi-pencil-square me-1"></i> Editar
    </a>
  </li>

  <li class="nav-item">
  <a class="nav-link">
    <form action="{{ route('products.destroy', $product) }}" method="post"
      onsubmit="return confirm('¿Eliminar esta propiedad? Esta acción no se puede deshacer.')">
      @csrf @method('DELETE')
      <button class="text-danger" style="border:0; background-color: transparent;">
        <i class="bi bi-trash me-1"></i> Eliminar
      </button>
    </form>
  </a>

</li>
@endsection

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Propiedades</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
    </ol>
  </nav>

  <div class="row g-4">
    {{-- ======== Galería e información principal ======== --}}
    <div class="col-lg-8">
      <div class="hero mb-2 rounded overflow-hidden" style="aspect-ratio:16/9; background:#f2f2f2;">
        @if($product->coverPhoto)
          <img src="{{ $product->coverPhoto->publicUrl() }}" id="mainImage" style="width:100%;height:100%;object-fit:cover;">
        @else
          <div class="d-flex align-items-center justify-content-center h-100 text-muted">Sin imagen</div>
        @endif
      </div>

      @if($product->photos->count())
        <div class="row g-2">
          @foreach($product->photos as $ph)
            <div class="col-3">
              <img src="{{ $ph->publicUrl() }}" class="img-fluid rounded thumb"
                   style="height:80px;object-fit:cover;cursor:pointer;"
                   onclick="document.getElementById('mainImage').src=this.src">
            </div>
          @endforeach
        </div>
      @endif

      <div class="card mt-3">
        <div class="card-body">
          <h1 class="h4">{{ $product->title }}</h1>
          <div class="text-muted">{{ $product->province }}, {{ $product->canton }}, {{ $product->district }}</div>
          <div class="mt-2">{!! nl2br(e($product->description)) !!}</div>
        </div>
      </div>
    </div>

    {{-- ======== Panel lateral de detalle ======== --}}
    <div class="col-lg-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="mb-3">Detalle</h5>
          <div>Tipo: {{ $product->listing_type }} / {{ $product->property_type }}</div>
          <div>Estado:
            @php
              $badge = match($product->status){
                'active' => 'success', 'reserved' => 'warning', 'sold' => 'secondary', default => 'dark'
              };
            @endphp
            <span class="badge text-bg-{{ $badge }}">{{ $product->status }}</span>
          </div>
          <hr>
          @if($product->price_crc)<div>₡ {{ number_format($product->price_crc,0) }}</div>@endif
          @if($product->price_usd)<div>$ {{ number_format($product->price_usd,0) }}</div>@endif
          @if($product->price_per_m2_crc)<div>CRC/m²: {{ number_format($product->price_per_m2_crc,0) }}</div>@endif
          @if($product->price_per_m2_usd)<div>USD/m²: {{ number_format($product->price_per_m2_usd,0) }}</div>@endif
          @if($product->available_from)
            <div class="text-muted small">Disponible: {{ $product->available_from->format('Y-m-d') }}</div>
          @endif
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-body">
          <h6 class="mb-3">Medidas</h6>
          <ul class="list-unstyled small mb-0">
            @if($product->land_area_m2)<li>Terreno: {{ $product->land_area_m2 }} m²</li>@endif
            @if($product->construction_area_m2)<li>Construcción: {{ $product->construction_area_m2 }} m²</li>@endif
            @if($product->frontage_m)<li>Frente: {{ $product->frontage_m }} m</li>@endif
            @if($product->depth_m)<li>Fondo: {{ $product->depth_m }} m</li>@endif
            @if($product->bedrooms)<li>Habitaciones: {{ $product->bedrooms }}</li>@endif
            @if($product->bathrooms)<li>Baños: {{ $product->bathrooms }}</li>@endif
            @if($product->parking)<li>Parqueos: {{ $product->parking }}</li>@endif
          </ul>
        </div>
      </div>

      <div class="d-grid gap-2">
        <a href="{{ route('products.edit',$product) }}" class="btn btn-outline-primary">
          <i class="bi bi-pencil-square me-1"></i> Editar
        </a>
        <form action="{{ route('products.destroy',$product) }}" method="post"
              onsubmit="return confirm('¿Eliminar esta propiedad?')">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger">
            <i class="bi bi-trash me-1"></i> Eliminar
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection
