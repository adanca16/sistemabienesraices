@php
  /** @var \App\Models\User|null $user */
  $u = $user ?? null; // tolera null (create/edit)
@endphp

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="row g-3">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        {{-- Nombre --}}
        <div class="mb-3">
          <label class="form-label">Nombre completo</label>
          <input type="text" name="name" class="form-control"
                 value="{{ old('name', $u->name ?? '') }}"
                 placeholder="Ej: María Fernández" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label class="form-label">Correo electrónico</label>
          <input type="email" name="email" class="form-control"
                 value="{{ old('email', $u->email ?? '') }}"
                 placeholder="Ej: maria@dominio.com" required>
        </div>

        {{-- Password --}}
        <div class="mb-3">
          <label class="form-label">
            {{ ($u && $u->exists) ? 'Contraseña (dejar en blanco para no cambiar)' : 'Contraseña' }}
          </label>
          <input type="password" name="password" class="form-control"
                 placeholder="{{ ($u && $u->exists) ? 'Solo si desea actualizar' : 'Mínimo 8 caracteres' }}"
                 {{ ($u && $u->exists) ? '' : 'required' }}>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="d-grid gap-2">
      <button class="btn btn-primary btn-lg" type="submit">
        {{ ($u && $u->exists) ? 'Guardar cambios' : 'Crear usuario' }}
      </button>
      <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
  </div>
</div>
