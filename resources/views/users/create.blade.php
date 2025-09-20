@extends('layouts.admin')

@section('title','Nuevo Usuario · '.config('app.name'))

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
      <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
    </ol>
  </nav>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('users.store') }}" method="post">
        @csrf
        @include('users._form')
      </form>
    </div>
  </div>
@endsection
