
{{-- FOOTER INMOBILIARIO --}}
<footer id="footer">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6">
        <h5><i class="fa-solid fa-house-chimney me-2"></i>{{ config('app.site', config('app.name')) }}</h5>
        <p>Venta y alquiler de bienes raíces en Costa Rica. Asesoría integral legal, bancaria y catastral.</p>
        <p><i class="fa-solid fa-location-dot me-2"></i>Sarapiquí, Heredia, Costa Rica</p>
        <p><i class="fa-solid fa-phone me-2"></i>+506 8704 6288</p>
        <p><i class="fa-solid fa-envelope me-2"></i>info@micorreo.com</p>
      </div>

      <div class="col-lg-2 col-md-6">
        <h5>Enlaces</h5>
        <ul class="list-unstyled">
          <li><a href="#hero">Inicio</a></li>
          <li><a href="#products">Nuevas</a></li>
          <li><a href="#new-arrivals">Otras</a></li>
          <li><a href="#categories">Categorías</a></li>
          <li><a href="#about">Nosotros</a></li>
          <li><a href="#contactForm">Contáctenos</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <h5>Categorías</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('homePage', ['search'=>'Casa']) }}">Casas</a></li>
          <li><a href="{{ route('homePage', ['search'=>'Apartamento']) }}">Apartamentos</a></li>
          <li><a href="{{ route('homePage', ['search'=>'Lote']) }}">Lotes</a></li>
          <li><a href="{{ route('homePage', ['search'=>'Local']) }}">Locales</a></li>
          <li><a href="{{ route('homePage', ['search'=>'Oficina']) }}">Oficinas</a></li>
          <li><a href="{{ route('homePage', ['search'=>'Bodega']) }}">Bodegas</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <h5>Síganos</h5>
        <div class="d-flex gap-3 fs-5">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
          <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      © <span id="currentYear"></span> {{ config('app.site', config('app.name')) }}. Todos los derechos reservados.
    </div>
  </div>
</footer>

<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>