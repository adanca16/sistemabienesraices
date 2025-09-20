@include('landing.header')

{{-- OTRAS PROPIEDADES --}}
<section id="new-arrivals" class="section-padding">
  <div class="container">
    <h2 class="section-heading">Proyectos Top Selection</h2>
    <div class="row g-4">
      @forelse($otherRegister as $p)
      @include('landing.card_product', ['p' => $p])
      @empty
      <div class="col-12">
        <div class="alert alert-light border">No hay más propiedades para mostrar.</div>
      </div>
      @endforelse
    </div>

    {{-- Paginación, conserva filtros gracias a ->withQueryString() en el controlador --}}
    <div class="mt-4">
      {{ $otherRegister->links() }}
    </div>
  </div>
</section>

{{-- NUEVAS PROPIEDADES --}}
<section id="products" class="section-padding">
  <div class="container">
    <h2 class="section-heading">Agregadas recientemente</h2>
    <div class="row g-4">
      @forelse($newRegister as $p)
      @include('landing.card_product')
      @empty
      <div class="col-12">
        <div class="alert alert-light border">No hay propiedades nuevas por el momento.</div>
      </div>
      @endforelse
    </div>
  </div>
</section>

{{-- CATEGORÍAS INMOBILIARIAS --}}
<section id="categories" class="section-padding">
  <div class="container">
    <h2 class="section-heading">Explorar por categoría</h2>
    <div class="row g-3">
      <div class="col-lg-2 col-md-4 col-6 d-flex">
        <a class="category-card w-100" href="{{ route('homePage', ['search'=>'Casa']) }}">
          <i class="fa-solid fa-house"></i>
          <h5>Casas</h5>
        </a>
      </div>
      <div class="col-lg-2 col-md-4 col-6 d-flex">
        <a class="category-card w-100" href="{{ route('homePage', ['search'=>'Apartamento']) }}">
          <i class="fa-solid fa-building"></i>
          <h5>Apartamentos</h5>
        </a>
      </div>
      <div class="col-lg-2 col-md-4 col-6 d-flex">
        <a class="category-card w-100" href="{{ route('homePage', ['search'=>'Lote']) }}">
          <i class="fa-solid fa-tree"></i>
          <h5>Lotes</h5>
        </a>
      </div>
      <div class="col-lg-2 col-md-4 col-6 d-flex">
        <a class="category-card w-100" href="{{ route('homePage', ['search'=>'Bodega']) }}">
          <i class="fa-solid fa-warehouse"></i>
          <h5>Bodegas</h5>
        </a>
      </div>
      <div class="col-lg-2 col-md-4 col-6 d-flex">
        <a class="category-card w-100" href="{{ route('homePage', ['search'=>'Local']) }}">
          <i class="fa-solid fa-store"></i>
          <h5>Locales</h5>
        </a>
      </div>
      <div class="col-lg-2 col-md-4 col-6 d-flex">
        <a class="category-card w-100" href="{{ route('homePage', ['search'=>'Oficina']) }}">
          <i class="fa-solid fa-briefcase"></i>
          <h5>Oficinas</h5>
        </a>
      </div>
    </div>
  </div>
</section>

{{-- NOSOTROS --}}
<section id="about" class="section-padding">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <img
          src="{{asset('uploads/banner_info.avif')}}"
          alt="Equipo inmobiliario atendiendo a clientes" />
      </div>
      <div class="col-lg-6">
        <h2 class="section-heading text-start">Sobre {{ config('app.site', config('app.name')) }}</h2>
        <style>
          #about .section-heading::after {
            left: 0;
            transform: translateX(0);
          }
        </style>
        <p>
          Somos una agencia inmobiliaria enfocada en <strong>venta y alquiler</strong> de propiedades en Costa Rica.
          Te acompañamos desde la búsqueda hasta el cierre, con asesoría legal, catastral y bancaria.
        </p>
        <p>
          Publicamos inmuebles verificados, con información completa de ubicación, medidas, uso de suelo y estado legal
          para que tomés decisiones con confianza.
        </p>
        <a href="#contactForm" class="btn btn-primary mt-3"><i class="fa-solid fa-handshake-angle me-2"></i>Asesoría gratuita</a>
      </div>
    </div>
  </div>
</section>

{{-- TESTIMONIOS --}}
<section id="testimonials" class="section-padding">
  <div class="container">
    <h2 class="section-heading">Lo que dicen nuestros clientes</h2>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="testimonial-card">
          <p class="mb-2">“Encontramos la casa ideal en Santa Ana. Gestión clara y rápida.”</p>
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-user-circle fa-lg text-secondary"></i>
            <div><strong>María & Carlos</strong>
              <div class="text-muted small">Compra — Santa Ana</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="testimonial-card">
          <p class="mb-2">“Excelente apoyo con el uso de suelo y el plano catastrado. ¡Todo en regla!”</p>
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-user-circle fa-lg text-secondary"></i>
            <div><strong>Javier R.</strong>
              <div class="text-muted small">Lote — Grecia</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="testimonial-card">
          <p class="mb-2">“Alquilar fue sencillo y seguro. Recomendados.”</p>
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-user-circle fa-lg text-secondary"></i>
            <div><strong>Laura M.</strong>
              <div class="text-muted small">Alquiler — Heredia</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- FORMULARIO DE CONTACTO ENFOCADO A INMUEBLES --}}
<section id="contactForm" class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow">
        <div class="card-body p-4">
          <h2 class="text-center mb-4 text-primary">Contáctenos</h2>
          <form action="{{ route('contact.send') }}" method="post">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ej: Juan Pérez" required>
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ej: correo@dominio.com" required>
              </div>
              <div class="col-md-4">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Ej: 8888-8888">
              </div>
              <div class="col-md-4">
                <label for="preferred_zone" class="form-label">Zona de interés</label>
                <input type="text" class="form-control" id="preferred_zone" name="preferred_zone" placeholder="Ej: Escazú, Santa Ana, Heredia">
              </div>
              <div class="col-md-4">
                <label for="budget" class="form-label">Presupuesto aprox.</label>
                <input type="text" class="form-control" id="budget" name="budget" placeholder="Ej: ₡150.000.000 / $250.000">
              </div>
              <div class="col-md-4">
                <label for="listing_type_f" class="form-label">Tipo de anuncio</label>
                <select class="form-select" id="listing_type_f" name="listing_type">
                  <option value="">Seleccionar…</option>
                  <option value="sale">Compra / Venta</option>
                  <option value="rent">Alquiler</option>
                  <option value="presale">Preventa</option>
                  <option value="project">Proyecto</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="property_type_f" class="form-label">Tipo de propiedad</label>
                <select class="form-select" id="property_type_f" name="property_type">
                  <option value="">Seleccionar…</option>
                  <option>Casa</option>
                  <option>Apartamento</option>
                  <option>Lote</option>
                  <option>Bodega</option>
                  <option>Local</option>
                  <option>Oficina</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="bedrooms_f" class="form-label">Habitaciones (opcional)</label>
                <input type="number" min="0" class="form-control" id="bedrooms_f" name="bedrooms" placeholder="Ej: 3">
              </div>
              <div class="col-12">
                <label for="subject" class="form-label">Asunto</label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Ej: Quiero agendar una visita en Escazú" required>
              </div>
              <div class="col-12">
                <label for="message" class="form-label">Mensaje</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Describa qué busca: ubicación, rango de precio, m², amenidades, etc." required></textarea>
              </div>
            </div>
            <div class="d-grid mt-3">
              <button type="submit" class="btn btn-primary btn-lg"><i class="fa-solid fa-paper-plane me-2"></i>Enviar</button>
            </div>
            <p class="text-center text-muted small mt-2 mb-0">
              Al enviar este formulario, acepta ser contactado por nuestro equipo para brindarle asesoría.
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@include('landing.footer')