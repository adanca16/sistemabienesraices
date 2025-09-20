@extends('layouts.admin')

@section('title','Usuarios · '.config('app.name'))

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Usuarios</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo</a>
  </div>

  {{-- Buscador --}}
  <form class="row g-2 mb-3" method="get" action="{{ route('users.index') }}">
    <div class="col-sm-8 col-md-6">
      <input type="text" name="search" value="{{ request('search') }}"
             class="form-control"
             placeholder="Buscar por nombre o correo...">
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-secondary" type="submit">Buscar</button>
    </div>
    @if(request('search'))
      <div class="col-auto">
        <a href="{{ route('users.index') }}" class="btn btn-outline-light border">Limpiar</a>
      </div>
    @endif
  </form>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

  <div class="table-responsive">
    <table class="table table-hover align-middle bg-white">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Creado</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $key=>$u)
          <tr>
            <td>{{ $key+1 }}</td>
            <td class="fw-semibold">{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td class="text-nowrap">{{ $u->created_at?->format('Y-m-d H:i') }}</td>
            <td class="text-end">
              <a href="{{ route('users.show',$u) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
              <a href="{{ route('users.edit',$u) }}" class="btn btn-sm btn-outline-primary">Editar</a>
              <form action="{{ route('users.destroy',$u) }}" method="post" class="d-inline"
                    onsubmit="return confirm('¿Eliminar usuario?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-4">Sin resultados</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $users->links() }}
  </div>
@endsection
