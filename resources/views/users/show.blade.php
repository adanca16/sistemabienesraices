@extends('layouts.admin')

@section('title', $user->name.' · '.config('app.name'))

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
    </ol>
  </nav>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="card">
    <div class="card-body">
      <h1 class="h4">{{ $user->name }}</h1>
      <div class="text-muted mb-2">{{ $user->email }}</div>

      <dl class="row">
        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9">{{ $user->id }}</dd>

        <dt class="col-sm-3">Creado</dt>
        <dd class="col-sm-9">{{ $user->created_at?->format('Y-m-d H:i') }}</dd>

        <dt class="col-sm-3">Actualizado</dt>
        <dd class="col-sm-9">{{ $user->updated_at?->format('Y-m-d H:i') }}</dd>
      </dl>

      <div class="d-flex gap-2">
        <a href="{{ route('users.edit',$user) }}" class="btn btn-outline-primary">Editar</a>
        <form action="{{ route('users.destroy',$user) }}" method="post"
              onsubmit="return confirm('¿Eliminar usuario?')">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger">Eliminar</button>
        </form>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Volver</a>
      </div>
    </div>
  </div>
@endsection
