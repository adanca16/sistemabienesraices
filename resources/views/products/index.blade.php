@extends('layouts.admin')

@section('title','Propiedades · '.config('app.site'))

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Propiedades</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Nuevo</a>
  </div>

  {{-- Buscador --}}
  <form class="row g-2 mb-3" method="get" action="{{ route('products.index') }}">
    <div class="col-sm-8 col-md-6">
      <input type="text"
             name="search"
             value="{{ request('search') }}"
             class="form-control"
             placeholder="Buscar por título, provincia, cantón, folio real...">
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-secondary" type="submit">Buscar</button>
    </div>
    @if(request()->has('search') && request('search')!=='')
      <div class="col-auto">
        <a href="{{ route('products.index') }}" class="btn btn-outline-light border">Limpiar</a>
      </div>
    @endif
  </form>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table table-hover align-middle bg-white">
      <thead class="table-light">
        <tr>
          <th>Foto</th>
          <th>Título</th>
          <th>Ubicación</th>
          <th>Tipo</th>
          <th>Estado</th>
          <th class="text-end">Precio (CRC/USD)</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $p)
          <tr>
            <td style="width:90px">
              @if($p->coverPhoto)
                <img src="{{ $p->coverPhoto->publicUrl() }}" class="img-thumbnail" style="width:80px;height:60px;object-fit:cover" alt="Foto portada">
              @else
                <div class="bg-secondary-subtle text-center" style="width:80px;height:60px;line-height:60px">—</div>
              @endif
            </td>
            <td>
              <a href="{{ route('products.show',$p) }}" class="fw-semibold text-decoration-none">{{ $p->title }}</a>
              <div class="text-muted small">{{ $p->listing_type }} · {{ $p->property_type }}</div>
            </td>
            <td class="text-nowrap">{{ $p->province }}, {{ $p->canton }}, {{ $p->district }}</td>
            <td>{{ $p->property_type }}</td>
            <td>
              @php
                $badge = match($p->status){
                  'active' => 'success', 'reserved' => 'warning', 'sold' => 'secondary', default => 'dark'
                };
              @endphp
              <span class="badge text-bg-{{ $badge }}">{{ $p->status }}</span>
            </td>
            <td class="text-end">
              @if($p->price_crc) ₡{{ number_format($p->price_crc,0) }} @endif
              @if($p->price_usd) <br>$ {{ number_format($p->price_usd,0) }} @endif
            </td>
            <td class="text-end">
              <a href="{{ route('products.edit',$p) }}" class="btn btn-sm btn-outline-primary">Editar</a>
              <form action="{{ route('products.destroy',$p) }}" method="post" class="d-inline"
                    onsubmit="return confirm('¿Eliminar producto?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted py-4">Sin resultados</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginación --}}
  <div class="mt-3">
    {{ $products->links() }}
  </div>
@endsection
