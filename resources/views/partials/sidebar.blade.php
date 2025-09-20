@php
function isActive($names){
foreach ((array)$names as $n) {
if (request()->routeIs($n)) return 'active';
}
return '';
}
@endphp


<div class="px-3">
  <div class="d-flex align-items-center mb-3">
    <span class="fs-5">Menú</span>
  </div>

  <nav class="nav flex-column gap-1">
    <a class="nav-link {{ isActive(['dashboard']) }}" href="{{ route('homePage') }}">
      <i class="bi bi-speedometer2 me-1"></i> Ver P&aacute;gina
    </a>

    <div class="mt-2 text-uppercase small text-muted px-2">Bienes</div>
    <a class="nav-link {{ isActive(['products.index','products.create','products.edit','products.show']) }}"
      href="{{ route('products.index') }}">
      <i class="bi bi-houses me-1"></i> Propiedades
    </a>

    {{-- Agrega más secciones si ocupás --}}
 <div class="mt-2 text-uppercase small text-muted px-2">Sistema</div>
<a class="nav-link {{ isActive(['contact_messages.index']) }}" href="{{ route('contact_messages.index') }}">
    <i class="bi bi-chat-dots me-1"></i> Mensajes
</a>


<a class="nav-link {{ isActive(['users.index']) }}" href="{{ route('users.index') }}">
    <i class="bi bi-person me-1"></i> Usuarios
</a>



    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
      {{ Auth::user()->name }}
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
      <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
        Salir </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>


  </nav>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">