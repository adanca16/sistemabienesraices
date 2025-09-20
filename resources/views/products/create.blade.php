@extends('layouts.admin')

@section('title', 'Nueva Propiedad · '.config('app.site'))

{{-- Acciones en la barra superior (opcional) --}}
@section('top-actions')
  <li class="nav-item">
    <a class="nav-link" href="{{ route('products.index') }}">
      <i class="bi bi-card-list me-1"></i> Listado
    </a>
  </li>
@endsection

@section('content')
  {{-- Migas de pan (opcional) --}}
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Propiedades</a></li>
      <li class="breadcrumb-item active" aria-current="page">Nueva</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Nueva Propiedad</h1>
  </div>

  {{-- Mensajes de estado --}}
  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  {{-- Formulario de alta --}}
  <div class="card">
    <div class="card-body">
      <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        {{-- Incluye el formulario reutilizable con labels y placeholders de ejemplo --}}
        @include('products._form')

        {{-- Botones finales (opcional si ya los tenés en _form) --}}
        {{-- 
        <div class="d-flex justify-content-end gap-2 mt-3">
          <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button class="btn btn-primary">Guardar</button>
        </div>
        --}}
      </form>
    </div>
  </div>
@endsection

@push('head')
  {{-- CSS adicional específico si es necesario --}}
@endpush

@push('scripts')
  {{-- JS adicional específico si es necesario --}}
@endpush
