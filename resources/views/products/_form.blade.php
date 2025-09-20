@php
    $p = $product ?? null;
@endphp

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="row g-3">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">

        {{-- ================== DATOS BÁSICOS ================== --}}
        <div class="mb-3">
          <label for="title" class="form-label">Título *</label>
          <input id="title" type="text" name="title" class="form-control"
                 value="{{ old('title',$p->title ?? '') }}"
                 placeholder="Ej: Lote residencial con vista a las montañas" required>
        </div>

        <div class="mb-3">
          <label for="summary" class="form-label">Resumen</label>
          <textarea id="summary" name="summary" class="form-control" rows="2"
                    placeholder="Ej: Terreno de 1.200 m² en zona fresca y tranquila">{{ old('summary',$p->summary ?? '') }}</textarea>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Descripción</label>
          <textarea id="description" name="description" class="form-control" rows="5"
                    placeholder="Ej: Lote plano con acceso asfaltado, cerca de escuelas y supermercados. Servicios disponibles.">{{ old('description',$p->description ?? '') }}</textarea>
        </div>

        <div class="row g-3">
          <div class="col-md-4">
            <label for="listing_type" class="form-label">Tipo de anuncio *</label>
            <select id="listing_type" name="listing_type" class="form-select" required>
              @foreach(['sale'=>'Venta','rent'=>'Alquiler','presale'=>'Preventa','project'=>'Proyecto'] as $k=>$v)
                <option value="{{ $k }}" @selected(old('listing_type',$p->listing_type ?? '')===$k)>{{ $v }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="property_type" class="form-label">Tipo de propiedad *</label>
            <input id="property_type" type="text" name="property_type" class="form-control"
                   value="{{ old('property_type',$p->property_type ?? '') }}"
                   placeholder="Ej: Casa, Lote, Apartamento" required>
          </div>
          <div class="col-md-4">
            <label for="status" class="form-label">Estado *</label>
            <select id="status" name="status" class="form-select" required>
              @foreach(['active'=>'Activa','reserved'=>'Reservada','sold'=>'Vendida','archived'=>'Archivada'] as $k=>$v)
                <option value="{{ $k }}" @selected(old('status',$p->status ?? '')===$k)>{{ $v }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <hr>

        {{-- ================== UBICACIÓN (CR) ================== --}}
        <h6 class="mb-2">Ubicación (Costa Rica)</h6>
        <div class="row g-3">
          <div class="col-md-4">
            <label for="province" class="form-label">Provincia *</label>
            <input id="province" name="province" class="form-control"
                   value="{{ old('province',$p->province ?? '') }}"
                   placeholder="Ej: San José" required>
          </div>
          <div class="col-md-4">
            <label for="canton" class="form-label">Cantón *</label>
            <input id="canton" name="canton" class="form-control"
                   value="{{ old('canton',$p->canton ?? '') }}"
                   placeholder="Ej: Escazú" required>
          </div>
          <div class="col-md-4">
            <label for="district" class="form-label">Distrito *</label>
            <input id="district" name="district" class="form-control"
                   value="{{ old('district',$p->district ?? '') }}"
                   placeholder="Ej: San Rafael" required>
          </div>
          <div class="col-md-6">
            <label for="neighborhood" class="form-label">Barrio / Residencial</label>
            <input id="neighborhood" name="neighborhood" class="form-control"
                   value="{{ old('neighborhood',$p->neighborhood ?? '') }}"
                   placeholder="Ej: Residencial Los Laureles">
          </div>
          <div class="col-md-6">
            <label for="address_line" class="form-label">Dirección exacta</label>
            <input id="address_line" name="address_line" class="form-control"
                   value="{{ old('address_line',$p->address_line ?? '') }}"
                   placeholder="Ej: 200 m norte de la Iglesia Católica">
          </div>
          <div class="col-md-4">
            <label for="postal_code" class="form-label">Código postal</label>
            <input id="postal_code" name="postal_code" class="form-control"
                   value="{{ old('postal_code',$p->postal_code ?? '') }}"
                   placeholder="Ej: 10201">
          </div>
          <div class="col-md-4">
            <label for="lat" class="form-label">Latitud</label>
            <input id="lat" name="lat" class="form-control"
                   value="{{ old('lat',$p->lat ?? '') }}"
                   placeholder="Ej: 9.932849">
          </div>
          <div class="col-md-4">
            <label for="lng" class="form-label">Longitud</label>
            <input id="lng" name="lng" class="form-control"
                   value="{{ old('lng',$p->lng ?? '') }}"
                   placeholder="Ej: -84.085014">
          </div>
        </div>

        <hr>

        {{-- ================== LEGAL ================== --}}
        <h6 class="mb-2">Información legal</h6>
        <div class="row g-3">
          <div class="col-md-4">
            <label for="folio_real" class="form-label">Folio real</label>
            <input id="folio_real" name="folio_real" class="form-control"
                   value="{{ old('folio_real',$p->folio_real ?? '') }}"
                   placeholder="Ej: 3-123456-000">
          </div>
          <div class="col-md-4">
            <label for="plano_catastrado" class="form-label">Plano catastrado</label>
            <input id="plano_catastrado" name="plano_catastrado" class="form-control"
                   value="{{ old('plano_catastrado',$p->plano_catastrado ?? '') }}"
                   placeholder="Ej: G-23456-2025">
          </div>
          <div class="col-md-4">
            <label for="land_use_zoning" class="form-label">Uso de suelo</label>
            <input id="land_use_zoning" name="land_use_zoning" class="form-control"
                   value="{{ old('land_use_zoning',$p->land_use_zoning ?? '') }}"
                   placeholder="Ej: Residencial de baja densidad">
          </div>
          <div class="col-md-6">
            <label for="has_easements" class="form-label">Servidumbres</label>
            <select id="has_easements" name="has_easements" class="form-select">
              <option value="">No especificar</option>
              <option value="1" @selected(old('has_easements',$p->has_easements ?? null)==1)>Sí</option>
              <option value="0" @selected(old('has_easements',$p->has_easements ?? null)==0)>No</option>
            </select>
            <label for="easements_notes" class="form-label mt-2">Detalle servidumbres</label>
            <textarea id="easements_notes" name="easements_notes" class="form-control"
                      placeholder="Ej: Paso de aguas pluviales al oeste">{{ old('easements_notes',$p->easements_notes ?? '') }}</textarea>
          </div>
          <div class="col-md-6">
            <label for="has_mortgage" class="form-label">Hipoteca</label>
            <select id="has_mortgage" name="has_mortgage" class="form-select">
              <option value="">No especificar</option>
              <option value="1" @selected(old('has_mortgage',$p->has_mortgage ?? null)==1)>Sí</option>
              <option value="0" @selected(old('has_mortgage',$p->has_mortgage ?? null)==0)>No</option>
            </select>
            <label for="legal_notes" class="form-label mt-2">Notas legales</label>
            <textarea id="legal_notes" name="legal_notes" class="form-control"
                      placeholder="Ej: Libre de gravámenes y anotaciones">{{ old('legal_notes',$p->legal_notes ?? '') }}</textarea>
          </div>
        </div>

        <hr>

        {{-- ================== MEDIDAS Y CARACTERÍSTICAS ================== --}}
        <h6 class="mb-2">Medidas y características</h6>
        <div class="row g-3">
          <div class="col-md-3">
            <label for="land_area_m2" class="form-label">Terreno (m²)</label>
            <input id="land_area_m2" name="land_area_m2" class="form-control"
                   value="{{ old('land_area_m2',$p->land_area_m2 ?? '') }}"
                   placeholder="Ej: 1200">
          </div>
          <div class="col-md-3">
            <label for="construction_area_m2" class="form-label">Construcción (m²)</label>
            <input id="construction_area_m2" name="construction_area_m2" class="form-control"
                   value="{{ old('construction_area_m2',$p->construction_area_m2 ?? '') }}"
                   placeholder="Ej: 180">
          </div>
          <div class="col-md-3">
            <label for="frontage_m" class="form-label">Frente (m)</label>
            <input id="frontage_m" name="frontage_m" class="form-control"
                   value="{{ old('frontage_m',$p->frontage_m ?? '') }}"
                   placeholder="Ej: 20">
          </div>
          <div class="col-md-3">
            <label for="depth_m" class="form-label">Fondo (m)</label>
            <input id="depth_m" name="depth_m" class="form-control"
                   value="{{ old('depth_m',$p->depth_m ?? '') }}"
                   placeholder="Ej: 60">
          </div>
          <div class="col-md-4">
            <label for="topography" class="form-label">Topografía</label>
            <input id="topography" name="topography" class="form-control"
                   value="{{ old('topography',$p->topography ?? '') }}"
                   placeholder="Ej: Plana / Semiondulada">
          </div>
          <div class="col-md-4">
            <label for="view_type" class="form-label">Vista</label>
            <input id="view_type" name="view_type" class="form-control"
                   value="{{ old('view_type',$p->view_type ?? '') }}"
                   placeholder="Ej: Montaña / Ciudad / Mar">
          </div>
          <div class="col-md-4">
            <label for="road_front" class="form-label">Frente a</label>
            <input id="road_front" name="road_front" class="form-control"
                   value="{{ old('road_front',$p->road_front ?? '') }}"
                   placeholder="Ej: Calle pública asfaltada">
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-md-3">
            <label for="gated_community" class="form-label">Residencial cerrado</label>
            <select id="gated_community" name="gated_community" class="form-select">
              <option value="">—</option>
              <option value="1" @selected(old('gated_community',$p->gated_community ?? null)==1)>Sí</option>
              <option value="0" @selected(old('gated_community',$p->gated_community ?? null)==0)>No</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="is_condominium" class="form-label">Condominio</label>
            <select id="is_condominium" name="is_condominium" class="form-select">
              <option value="">—</option>
              <option value="1" @selected(old('is_condominium',$p->is_condominium ?? null)==1)>Sí</option>
              <option value="0" @selected(old('is_condominium',$p->is_condominium ?? null)==0)>No</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="hoa_fee_month_crc" class="form-label">Cuota condominio (CRC/mes)</label>
            <input id="hoa_fee_month_crc" name="hoa_fee_month_crc" class="form-control"
                   value="{{ old('hoa_fee_month_crc',$p->hoa_fee_month_crc ?? '') }}"
                   placeholder="Ej: 95000">
          </div>
        </div>

        <hr>

        {{-- ================== SERVICIOS ================== --}}
        <h6 class="mb-2">Servicios</h6>
        <div class="row g-3">
          <div class="col-md-2">
            <label for="water" class="form-label">Agua</label>
            <select id="water" name="water" class="form-select">
              <option value="">—</option>
              <option value="1" @selected(old('water',$p->water ?? null)==1)>Sí</option>
              <option value="0" @selected(old('water',$p->water ?? null)==0)>No</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="water_provider" class="form-label">Proveedor de agua</label>
            <input id="water_provider" name="water_provider" class="form-control"
                   value="{{ old('water_provider',$p->water_provider ?? '') }}"
                   placeholder="Ej: AyA / ASADA / Pozo">
          </div>
          <div class="col-md-2">
            <label for="electricity" class="form-label">Electricidad</label>
            <select id="electricity" name="electricity" class="form-select">
              <option value="">—</option>
              <option value="1" @selected(old('electricity',$p->electricity ?? null)==1)>Sí</option>
              <option value="0" @selected(old('electricity',$p->electricity ?? null)==0)>No</option>
            </select>
          </div>
          <div class="col-md-2">
            <label for="internet" class="form-label">Internet</label>
            <select id="internet" name="internet" class="form-select">
              <option value="">—</option>
              <option value="1" @selected(old('internet',$p->internet ?? null)==1)>Sí</option>
              <option value="0" @selected(old('internet',$p->internet ?? null)==0)>No</option>
            </select>
          </div>
          <div class="col-md-2">
            <label for="sewage" class="form-label">Alcantarillado</label>
            <select id="sewage" name="sewage" class="form-select">
              <option value="">—</option>
              <option value="1" @selected(old('sewage',$p->sewage ?? null)==1)>Sí</option>
              <option value="0" @selected(old('sewage',$p->sewage ?? null)==0)>No</option>
            </select>
          </div>
        </div>

        <hr>

        {{-- ================== VIVIENDA ================== --}}
        <h6 class="mb-2">Vivienda (si aplica)</h6>
        <div class="row g-3">
          <div class="col-md-3">
            <label for="bedrooms" class="form-label">Habitaciones</label>
            <input id="bedrooms" name="bedrooms" class="form-control"
                   value="{{ old('bedrooms',$p->bedrooms ?? '') }}"
                   placeholder="Ej: 3">
          </div>
          <div class="col-md-3">
            <label for="bathrooms" class="form-label">Baños</label>
            <input id="bathrooms" name="bathrooms" class="form-control"
                   value="{{ old('bathrooms',$p->bathrooms ?? '') }}"
                   placeholder="Ej: 2.5">
          </div>
          <div class="col-md-3">
            <label for="parking" class="form-label">Parqueos</label>
            <input id="parking" name="parking" class="form-control"
                   value="{{ old('parking',$p->parking ?? '') }}"
                   placeholder="Ej: 2">
          </div>
          <div class="col-md-3">
            <label for="floors" class="form-label">Pisos</label>
            <input id="floors" name="floors" class="form-control"
                   value="{{ old('floors',$p->floors ?? '') }}"
                   placeholder="Ej: 2">
          </div>
          <div class="col-md-3">
            <label for="year_built" class="form-label">Año construcción</label>
            <input id="year_built" name="year_built" class="form-control"
                   value="{{ old('year_built',$p->year_built ?? '') }}"
                   placeholder="Ej: 2015">
          </div>
          <div class="col-md-3">
            <label for="year_renovated" class="form-label">Año renovación</label>
            <input id="year_renovated" name="year_renovated" class="form-control"
                   value="{{ old('year_renovated',$p->year_renovated ?? '') }}"
                   placeholder="Ej: 2021">
          </div>
          <div class="col-md-6">
            <label for="amenities" class="form-label">Amenidades (CSV o JSON)</label>
            <input id="amenities" name="amenities" class="form-control"
                   value="{{ old('amenities', isset($p->amenities)? implode(', ', $p->amenities):'') }}"
                   placeholder='Ej: Piscina, Rancho BBQ, Seguridad 24/7'>
          </div>
        </div>

        <hr>

        {{-- ================== PRECIO ================== --}}
        <h6 class="mb-2">Precio</h6>
        <div class="row g-3">
          <div class="col-md-3">
            <label for="currency" class="form-label">Moneda</label>
            <select id="currency" name="currency" class="form-select">
              <option value="CRC" @selected(old('currency',$p->currency ?? 'CRC')==='CRC')>CRC</option>
              <option value="USD" @selected(old('currency',$p->currency ?? 'CRC')==='USD')>USD</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="price_crc" class="form-label">Precio CRC</label>
            <input id="price_crc" name="price_crc" class="form-control"
                   value="{{ old('price_crc',$p->price_crc ?? '') }}"
                   placeholder="Ej: 150000000">
          </div>
          <div class="col-md-3">
            <label for="price_usd" class="form-label">Precio USD</label>
            <input id="price_usd" name="price_usd" class="form-control"
                   value="{{ old('price_usd',$p->price_usd ?? '') }}"
                   placeholder="Ej: 250000">
          </div>
          <div class="col-md-3">
            <label for="price_per_m2_crc" class="form-label">CRC / m²</label>
            <input id="price_per_m2_crc" name="price_per_m2_crc" class="form-control"
                   value="{{ old('price_per_m2_crc',$p->price_per_m2_crc ?? '') }}"
                   placeholder="Ej: 120000">
          </div>
          <div class="col-md-3">
            <label for="price_per_m2_usd" class="form-label">USD / m²</label>
            <input id="price_per_m2_usd" name="price_per_m2_usd" class="form-control"
                   value="{{ old('price_per_m2_usd',$p->price_per_m2_usd ?? '') }}"
                   placeholder="Ej: 180">
          </div>
          <div class="col-md-3">
            <label for="negotiable" class="form-label">Negociable</label>
            <select id="negotiable" name="negotiable" class="form-select">
              <option value="">—</option>
              <option value="1" @selected(old('negotiable',$p->negotiable ?? null)==1)>Sí</option>
              <option value="0" @selected(old('negotiable',$p->negotiable ?? null)==0)>No</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="owner_financing" class="form-label">Financiamiento propietario</label>
            <select id="owner_financing" name="owner_financing" class="form-select">
              <option value="">—</option>
              <option value="1" @selected(old('owner_financing',$p->owner_financing ?? null)==1)>Sí</option>
              <option value="0" @selected(old('owner_financing',$p->owner_financing ?? null)==0)>No</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="bank_options" class="form-label">Opciones bancarias</label>
            <input id="bank_options" name="bank_options" class="form-control"
                   value="{{ old('bank_options',$p->bank_options ?? '') }}"
                   placeholder="Ej: BAC, BCR, Scotiabank">
          </div>
          <div class="col-md-3">
            <label for="available_from" class="form-label">Disponible desde</label>
            <input id="available_from" type="date" name="available_from" class="form-control"
                   value="{{ old('available_from',$p->available_from ?? '') }}">
          </div>
        </div>

        <hr>

        {{-- ================== CONTACTO y SEO ================== --}}
        <h6 class="mb-2">Contacto y SEO</h6>
        <div class="row g-3">
          <div class="col-md-3">
            <label for="contact_name" class="form-label">Contacto</label>
            <input id="contact_name" name="contact_name" class="form-control"
                   value="{{ old('contact_name',$p->contact_name ?? '') }}"
                   placeholder="Ej: Juan Pérez">
          </div>
          <div class="col-md-3">
            <label for="contact_phone" class="form-label">Teléfono</label>
            <input id="contact_phone" name="contact_phone" class="form-control"
                   value="{{ old('contact_phone',$p->contact_phone ?? '') }}"
                   placeholder="Ej: 8888-8888">
          </div>
          <div class="col-md-3">
            <label for="contact_whatsapp" class="form-label">WhatsApp</label>
            <input id="contact_whatsapp" name="contact_whatsapp" class="form-control"
                   value="{{ old('contact_whatsapp',$p->contact_whatsapp ?? '') }}"
                   placeholder="Ej: 8888-8888">
          </div>
          <div class="col-md-3">
            <label for="contact_email" class="form-label">Email</label>
            <input id="contact_email" type="email" name="contact_email" class="form-control"
                   value="{{ old('contact_email',$p->contact_email ?? '') }}"
                   placeholder="Ej: correo@dominio.com">
          </div>
          <div class="col-md-6">
            <label for="seo_title" class="form-label">SEO Title</label>
            <input id="seo_title" name="seo_title" class="form-control"
                   value="{{ old('seo_title',$p->seo_title ?? '') }}"
                   placeholder="Ej: Lote en Escazú con vista - 1200 m²">
          </div>
          <div class="col-md-6">
            <label for="seo_description" class="form-label">SEO Description</label>
            <input id="seo_description" name="seo_description" class="form-control"
                   value="{{ old('seo_description',$p->seo_description ?? '') }}"
                   placeholder="Ej: Terreno amplio en zona premium con todos los servicios.">
          </div>
          <div class="col-md-12">
            <label for="tags" class="form-label">Tags (CSV o JSON)</label>
            <input id="tags" name="tags" class="form-control"
                   value="{{ old('tags', isset($p->tags)? implode(', ',$p->tags):'') }}"
                   placeholder="Ej: Escazú, Vista, Residencial, Inversión">
          </div>
        </div>

        <hr>

        {{-- ================== FOTOS ================== --}}
        <h6 class="mb-2">Fotos</h6>
        <div class="mb-2">
          <label for="photos" class="form-label">Subir imágenes</label>
          <input id="photos" type="file" name="photos[]" class="form-control" multiple accept="image/*">
          <small class="text-muted">Podés seleccionar múltiples imágenes (máx 5MB c/u). Formatos: JPG, PNG, WEBP.</small>
        </div>

        @if(isset($p) && $p->exists && $p->photos->count())
          <div class="row g-2">
            @foreach($p->photos as $ph)
              <div class="col-6 col-md-3">
                <div class="border p-2 rounded">
                  <img src="{{ $ph->publicUrl() }}" class="img-fluid" style="height:120px;object-fit:cover;width:100%" alt="Foto {{ $loop->iteration }}">
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" id="photo_cover_{{ $ph->id }}" name="photo_cover_id" value="{{ $ph->id }}" @checked($ph->is_cover)>
                    <label class="form-check-label small" for="photo_cover_{{ $ph->id }}">Portada</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="photo_delete_{{ $ph->id }}" value="{{ $ph->id }}" onchange="toggleDelete(this)">
                    <label class="form-check-label small text-danger" for="photo_delete_{{ $ph->id }}">Eliminar</label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <input type="hidden" name="photo_delete_ids" id="photo_delete_ids" value="">
          <script>
            function toggleDelete(el){
              const hidden = document.getElementById('photo_delete_ids');
              const set = new Set(hidden.value ? hidden.value.split(',').filter(Boolean).map(v=>parseInt(v)) : []);
              const id = parseInt(el.value);
              if(el.checked){ set.add(id); } else { set.delete(id); }
              hidden.value = Array.from(set).join(',');
            }
          </script>
        @endif

      </div>
    </div>
  </div>

  {{-- ================== ACCIONES ================== --}}
  <div class="col-md-12">
    <div class="d-grid gap-2">
      <button class="btn btn-primary btn-lg" type="submit">Guardar</button>
      <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
  </div>
</div>
