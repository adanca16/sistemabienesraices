@include('landing.header')
@section('headerMetadata')
{{-- ====== META SEO PARA DETALLE DE PROPIEDAD (sin @if en HTML) ====== --}}
@php
    use Illuminate\Support\Str;

    $siteName = config('app.site', config('app.name', 'Sitio'));
    $url      = url()->current();
    $image    = $product->coverPhoto?->publicUrl()
                ?? ($product->photos->first()?->publicUrl() ?? asset('img/fallback-property.jpg'));

    // Title (prioriza SEO title si existe)
    $title = $product->seo_title
        ? Str::limit($product->seo_title, 65, '…')
        : Str::limit("{$product->title} · {$product->province}, {$product->canton}", 65, '…');

    // Description (prioriza SEO description, luego summary, luego recorte de description)
    $rawDesc     = $product->seo_description ?: ($product->summary ?: Str::of($product->description ?? '')->stripTags());
    $description = Str::of($rawDesc)->squish()->limit(160, '…');

    // Precio
    $priceFloat = $product->currency === 'USD'
        ? ($product->price_usd ?: null)
        : ($product->price_crc ?: null);
    $currency   = $product->currency ?: 'USD';

    // Disponibilidad
    $availability = match($product->status) {
        'sold','archived' => 'https://schema.org/SoldOut',
        'reserved'        => 'https://schema.org/PreOrder',
        default           => 'https://schema.org/InStock',
    };

    // JSON-LD preparado en array para evitar lógica en el <script>
    $ld = [
        '@context' => 'https://schema.org',
        '@type'    => 'RealEstateListing',
        'url'      => $url,
        'name'     => $product->title,
        'description' => (string) $description,
        'image'    => [$image],
        'datePosted' => optional($product->created_at)->toIso8601String(),
        'category'   => $product->property_type,
        'offers'  => [
            '@type' => 'Offer',
            'price' => $priceFloat ? (float) number_format($priceFloat, 2, '.', '') : null,
            'priceCurrency' => $currency,
            'availability'  => $availability,
            'url' => $url,
        ],
        'itemOffered' => [
            '@type' => (in_array(strtolower($product->property_type), ['casa','house','residence','apartamento','apartment']) ? 'Residence' : 'Place'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress'   => $product->address_line ?? '',
                'addressLocality' => $product->canton ?? '',
                'addressRegion'   => $product->province ?? '',
                'postalCode'      => $product->postal_code ?? '',
                'addressCountry'  => 'CR',
            ],
        ],
    ];
    if ($product->lat && $product->lng) {
        $ld['itemOffered']['geo'] = [
            '@type' => 'GeoCoordinates',
            'latitude'  => (float) $product->lat,
            'longitude' => (float) $product->lng,
        ];
    }

    // Metas OG de precio (solo si hay precio)
    $ogPriceMeta = '';
    if ($priceFloat) {
        $ogPriceMeta = sprintf(
            '<meta property="product:price:amount" content="%s">'."\n".'<meta property="product:price:currency" content="%s">',
            e($priceFloat), e($currency)
        );
    }

    // Breadcrumbs JSON-LD
    $breadcrumbs = [
        '@context' => 'https://schema.org',
        '@type'    => 'BreadcrumbList',
        'itemListElement' => [
            ['@type'=>'ListItem','position'=>1,'name'=>'Inicio','item'=>url('/')],
            ['@type'=>'ListItem','position'=>2,'name'=>'Propiedades','item'=>route('products.index')],
            ['@type'=>'ListItem','position'=>3,'name'=>$product->title,'item'=>$url],
        ],
    ];
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}"/>
<meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1"/>

{{-- Open Graph --}}
<meta property="og:type" content="product"/>
<meta property="og:title" content="{{ $title }}"/>
<meta property="og:description" content="{{ $description }}"/>
<meta property="og:url" content="{{ $url }}"/>
<meta property="og:site_name" content="{{ $siteName }}"/>
<meta property="og:image" content="{{ $image }}"/>
<meta property="og:image:alt" content="{{ $product->title }}"/>
{!! $ogPriceMeta !!}

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="{{ $title }}"/>
<meta name="twitter:description" content="{{ $description }}"/>
<meta name="twitter:image" content="{{ $image }}"/>

{{-- JSON-LD principal --}}
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>

{{-- JSON-LD Breadcrumbs --}}
<script type="application/ld+json">
{!! json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>
{{-- ====== /META SEO ====== --}}
@endsection


<link rel="stylesheet" href="{{ asset('css/product_detail.css') }}" />
{{-- Carrusel (imagen principal + miniaturas scrollables en móvil) --}}
<div class="carousel-container">
  <div class="hero">
    @if($product->coverPhoto)
    <img id="mainImage" src="{{ $product->coverPhoto->publicUrl() }}" alt="{{ $product->title }}">
    @elseif($product->photos->count())
    <img id="mainImage" src="{{ $product->photos->first()->publicUrl() }}" alt="{{ $product->title }}">
    @else
    <img id="mainImage" src="https://picsum.photos/1200/675?grayscale" alt="Sin imagen">
    @endif
  </div>

  @if($product->photos->count())
  <div class="thumbs" aria-label="Galería de miniaturas (deslice en móvil)">
    @foreach($product->photos as $ph)
    <img src="{{ $ph->publicUrl() }}" alt="Foto {{ $loop->iteration }}"
      onclick="document.getElementById('mainImage').src=this.src">
    @endforeach
  </div>
  @endif
</div>

<div class="container mb-3">

  {{-- Columna izquierda --}}
  <section class="card">
    <h1>{{ $product->title }}</h1>
    <div class="muted">
      {{ $product->province }}, {{ $product->canton }}, {{ $product->district }}
      @if($product->neighborhood) — {{ $product->neighborhood }} @endif
    </div>

    @php
    $map = [
    'active' => 'badge-success',
    'reserved' => 'badge-warning',
    'sold' => 'badge-secondary',
    'archived' => 'badge-dark',
    ];
    @endphp
    <div style="margin:.75rem 0 1rem">
      <span class="badge {{ $map[$product->status] ?? 'badge-secondary' }}">{{ ucfirst($product->status) }}</span>
      <span class="chip">{{ strtoupper($product->listing_type) }}</span>
      <span class="chip">{{ $product->property_type }}</span>
      @if($product->available_from)
      <span class="chip">Disponible: {{ $product->available_from->format('d/m/Y') }}</span>
      @endif
    </div>

    @if($product->summary)
    <p class="muted">{{ $product->summary }}</p>
    @endif
    @if($product->description)
    <div>{!! nl2br(e($product->description)) !!}</div>
    @endif

    @if(is_array($product->amenities) && count($product->amenities))
    <h2 style="margin-top:1.25rem">Amenidades</h2>
    <div class="chips">
      @foreach($product->amenities as $a)
      <span class="chip">{{ $a }}</span>
      @endforeach
    </div>
    @endif

    @if(is_array($product->tags) && count($product->tags))
    <h2 style="margin-top:1.25rem">Etiquetas</h2>
    <div class="chips">
      @foreach($product->tags as $t)
      <span class="chip">#{{ $t }}</span>
      @endforeach
    </div>
    @endif

    <h2 style="margin-top:1.5rem">Información legal y catastral</h2>
    <div class="kv">
      @if($product->folio_real)<div><b>Folio real</b>{{ $product->folio_real }}</div>@endif
      @if($product->plano_catastrado)<div><b>Plano catastrado</b>{{ $product->plano_catastrado }}</div>@endif
      @if($product->land_use_zoning)<div><b>Uso de suelo</b>{{ $product->land_use_zoning }}</div>@endif
      <div><b>Servidumbres</b>{{ $product->has_easements ? 'Sí' : 'No' }}</div>
      @if($product->easements_notes)<div><b>Detalle servidumbres</b>{{ $product->easements_notes }}</div>@endif
      <div><b>Hipoteca</b>{{ $product->has_mortgage ? 'Sí' : 'No' }}</div>
      @if($product->legal_notes)<div><b>Notas legales</b>{{ $product->legal_notes }}</div>@endif
    </div>

    <h2 style="margin-top:1.5rem">Servicios</h2>
    <div class="kv">
      <div><b>Agua</b>{{ $product->water ? 'Sí' : 'No' }} @if($product->water_provider) ({{ $product->water_provider }}) @endif</div>
      <div><b>Electricidad</b>{{ $product->electricity ? 'Sí' : 'No' }}</div>
      <div><b>Internet</b>{{ $product->internet ? 'Sí' : 'No' }}</div>
      <div><b>Alcantarillado</b>{{ $product->sewage ? 'Sí' : 'No' }}</div>
      <div><b>Acceso pavimentado</b>{{ $product->paved_access ? 'Sí' : 'No' }}</div>
      <div><b>Frente a</b>{{ $product->road_front ?? '—' }}</div>
    </div>

    <h2 style="margin-top:1.5rem">Medidas y características</h2>
    <div class="grid-3">
      <div class="card">
        <div class="small"><b>Terreno</b></div>
        <div>{{ $product->land_area_m2 ? number_format($product->land_area_m2, 2) . ' m²' : '—' }}</div>
      </div>
      <div class="card">
        <div class="small"><b>Construcción</b></div>
        <div>{{ $product->construction_area_m2 ? number_format($product->construction_area_m2, 2) . ' m²' : '—' }}</div>
      </div>
      <div class="card">
        <div class="small"><b>Frente / Fondo</b></div>
        <div>
          {{ $product->frontage_m ? number_format($product->frontage_m,2). ' m' : '—' }} /
          {{ $product->depth_m ? number_format($product->depth_m,2). ' m' : '—' }}
        </div>
      </div>
      <div class="card">
        <div class="small"><b>Topografía</b></div>
        <div>{{ $product->topography ?? '—' }}</div>
      </div>
      <div class="card">
        <div class="small"><b>Vista</b></div>
        <div>{{ $product->view_type ?? '—' }}</div>
      </div>
      <div class="card">
        <div class="small"><b>Residencial / Condominio</b></div>
        <div>
          {{ $product->gated_community ? 'Residencial cerrado' : '—' }}
          @if($product->is_condominium)
          {{ $product->gated_community ? ' · ' : '' }}Condominio
          @endif
        </div>
      </div>
    </div>

    @if($product->bedrooms || $product->bathrooms || $product->parking || $product->floors)
    <h2 style="margin-top:1.5rem">Vivienda</h2>
    <div class="kv">
      @if($product->bedrooms)<div><b>Habitaciones</b>{{ $product->bedrooms }}</div>@endif
      @if($product->bathrooms)<div><b>Baños</b>{{ $product->bathrooms }}</div>@endif
      @if($product->parking)<div><b>Parqueos</b>{{ $product->parking }}</div>@endif
      @if($product->floors)<div><b>Pisos</b>{{ $product->floors }}</div>@endif
    </div>
    @endif
  </section>

  {{-- Columna derecha (se va debajo en móvil) --}}
  <aside class="card mt-2">
    <h2>Resumen comercial</h2>
    <div class="price">
      @if($product->currency === 'CRC' && $product->price_crc) ₡{{ number_format($product->price_crc,0) }} @endif
      @if($product->currency === 'USD' && $product->price_usd) $ {{ number_format($product->price_usd,0) }} @endif
    </div>

    @if($product->price_per_m2_crc || $product->price_per_m2_usd)
    <div class="muted small" style="margin:.25rem 0 1rem">
      @if($product->price_per_m2_crc) CRC/m²: {{ number_format($product->price_per_m2_crc,0) }} @endif
      @if($product->price_per_m2_usd) @if($product->price_per_m2_crc) · @endif USD/m²: {{ number_format($product->price_per_m2_usd,0) }} @endif
    </div>
    @endif

    <div class="kv" style="margin-top:.5rem">
      <div><b>Moneda</b>{{ $product->currency }}</div>
      <div><b>Negociable</b>{{ $product->negotiable ? 'Sí' : 'No' }}</div>
      <div><b>Financiamiento propietario</b>{{ $product->owner_financing ? 'Sí' : 'No' }}</div>
      @if($product->bank_options)<div><b>Opciones bancarias</b>{{ $product->bank_options }}</div>@endif
      @if($product->is_condominium && $product->hoa_fee_month_crc)
      <div><b>Cuota condominio</b>₡{{ number_format($product->hoa_fee_month_crc,0) }}/mes</div>
      @endif
    </div>

    <hr>

    <h3>Ubicación</h3>
    <div class="kv">
      <div><b>Provincia</b>{{ $product->province }}</div>
      <div><b>Cantón</b>{{ $product->canton }}</div>
      <div><b>Distrito</b>{{ $product->district }}</div>
      @if($product->address_line)<div><b>Dirección</b>{{ $product->address_line }}</div>@endif
      @if($product->postal_code)<div><b>Código postal</b>{{ $product->postal_code }}</div>@endif
      @if($product->lat && $product->lng)<div><b>Coordenadas</b>{{ $product->lat }}, {{ $product->lng }}</div>@endif
    </div>

    <hr>

    <h3>Contacto</h3>
    <div class="kv">
      @if($product->contact_name)<div><b>Nombre</b>{{ $product->contact_name }}</div>@endif
      @if($product->contact_phone)<div><b>Teléfono</b>{{ $product->contact_phone }}</div>@endif
      @if($product->contact_whatsapp)<div><b>WhatsApp</b>{{ $product->contact_whatsapp }}</div>@endif
      @if($product->contact_email)<div><b>Email</b>{{ $product->contact_email }}</div>@endif
    </div>

    <hr>

    <h3>Meta</h3>
    <div class="kv">
      <div><b>ID</b>{{ $product->id }}</div>
      <div><b>Publicación</b>{{ $product->created_at->format('d/m/Y') }}</div>
      <div><b>Actualización</b>{{ $product->updated_at->format('d/m/Y') }}</div>
      <div><b>Slug</b>{{ $product->slug }}</div>
    </div>

    <div class="chips" style="margin-top:1rem">
      @if($product->contact_whatsapp)
      <a class="chip" href="https://wa.me/{{ preg_replace('/\D/','',$product->contact_whatsapp) }}" target="_blank" rel="noopener">💬 WhatsApp</a>
      @endif
      @if($product->contact_phone)
      <a class="chip" href="tel:{{ preg_replace('/\D/','',$product->contact_phone) }}">📞 Llamar</a>
      @endif
      @if($product->contact_email)
      <a class="chip" href="mailto:{{ $product->contact_email }}">✉️ Correo</a>
      @endif
    </div>
  </aside>

</div>
@include('landing.footer')