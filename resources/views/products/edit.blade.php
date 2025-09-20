@extends('layouts.admin')

@section('title', 'Editar Propiedad · '.config('app.site'))

{{-- Acciones en la barra superior (opcional) --}}
@section('top-actions')
<li class="nav-item">
  <a class="nav-link" href="{{ route('products.index') }}">
    <i class="bi bi-card-list me-1"></i> Listado
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('products.show', $product) }}">
    <i class="bi bi-eye me-1"></i> Ver
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
{{-- Migas de pan (opcional) --}}
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Propiedades</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
  </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 mb-0">Editar Propiedad</h1>
</div>

{{-- Mensajes de estado --}}
@if(session('ok'))
<div class="alert alert-success">{{ session('ok') }}</div>
@endif

{{-- Formulario --}}
<div class="card">
  <div class="card-body">
    <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      {{-- Incluye el formulario reutilizable con labels y placeholders de ejemplo --}}
      @include('products._form', ['product' => $product])

      {{-- Botones de acción persistentes en layouts nuevos (ya están en el _form al final).
             Si prefieres redundancia aquí, puedes añadirlos de nuevo: --}}
      {{--
        <div class="d-flex justify-content-end gap-2 mt-3">
          <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
      <button class="btn btn-primary">Guardar cambios</button>
  </div>
  --}}
  </form>
</div>
</div>
@endsection

@push('head')
{{-- CSS adicional para esta vista (si lo necesitás) --}}
@endpush

@push('scripts')
{{-- JS adicional para esta vista (si lo necesitás) --}}
@endpush