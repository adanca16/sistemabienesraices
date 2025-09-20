@extends('layouts.admin')

@section('title','Editar Usuario · '.config('app.name'))

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
  </nav>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('users.update', $user) }}" method="post">
        @csrf @method('PUT')
        @include('users._form', ['user'=>$user])
      </form>
    </div>
  </div>
@endsection
