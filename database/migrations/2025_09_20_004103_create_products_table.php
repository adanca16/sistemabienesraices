<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Identificación básica
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();

            // Clasificación
            // listing_type: sale | rent | presale | project
            $table->string('listing_type', 20)->default('sale')->index();
            // property_type: lot | house | apartment | commercial | farm | warehouse | office | beach_lot | mountain_lot | other
            $table->string('property_type', 30)->index();

            // Ubicación (Costa Rica)
            $table->string('province', 50)->index();    // Ej: San José, Alajuela, Cartago ...
            $table->string('canton', 80)->index();      // Ej: Escazú, Santa Ana...
            $table->string('district', 100)->index();
            $table->string('neighborhood', 120)->nullable(); // Barrio / residencial
            $table->string('address_line')->nullable();       // Dirección descriptiva
            $table->string('postal_code', 10)->nullable();    // Código postal CR
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            // Códigos INEC opcionales
            $table->string('inec_province_code', 2)->nullable();
            $table->string('inec_canton_code', 2)->nullable();
            $table->string('inec_district_code', 2)->nullable();

            // Identificación catastral/legal (CR)
            $table->string('folio_real', 30)->nullable()->unique(); // Registro Nacional
            $table->string('plano_catastrado', 30)->nullable();     // Nº plano catastrado
            $table->string('land_use_zoning')->nullable();          // Uso de suelo (municipal)
            $table->boolean('has_easements')->default(false);       // Servidumbres
            $table->text('easements_notes')->nullable();            // Detalle servidumbres
            $table->boolean('has_mortgage')->default(false);        // Hipoteca
            $table->text('legal_notes')->nullable();                // Observaciones legales

            // Medidas y características
            $table->decimal('land_area_m2', 12, 2)->nullable();         // Terreno
            $table->decimal('construction_area_m2', 12, 2)->nullable(); // Construcción
            $table->decimal('frontage_m', 8, 2)->nullable();            // Frente
            $table->decimal('depth_m', 8, 2)->nullable();               // Fondo
            $table->string('topography', 40)->nullable();               // plano | semi-quebrado | quebrado
            $table->string('view_type', 60)->nullable();                // montaña, ciudad, mar, valle, bosque
            $table->string('road_front', 60)->nullable();               // lastre, asfalto, servidumbre, etc.
            $table->boolean('gated_community')->default(false);
            $table->boolean('is_condominium')->default(false);
            $table->decimal('hoa_fee_month_crc', 12, 2)->nullable();    // Cuota condominio (CRC)

            // Servicios disponibles
            $table->boolean('water')->default(false);        // AyA/ASADA
            $table->string('water_provider', 40)->nullable();// Aya | Asada | Pozo
            $table->boolean('electricity')->default(false);
            $table->boolean('internet')->default(false);
            $table->boolean('sewage')->default(false);       // Alcantarillado/Planta
            $table->boolean('paved_access')->default(false);

            // Métricas de vivienda (si aplica)
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->unsignedSmallInteger('bathrooms')->nullable();
            $table->unsignedSmallInteger('parking')->nullable();
            $table->unsignedSmallInteger('floors')->nullable();
            $table->year('year_built')->nullable();
            $table->year('year_renovated')->nullable();
            $table->json('amenities')->nullable(); // piscina, rancho BBQ, seguridad 24/7, gimnasio, etc.

            // Precios (CRC y USD)
            $table->enum('currency', ['CRC','USD'])->default('CRC');
            $table->decimal('price_crc', 15, 2)->nullable()->index();
            $table->decimal('price_usd', 15, 2)->nullable()->index();
            $table->decimal('price_per_m2_crc', 15, 2)->nullable();
            $table->decimal('price_per_m2_usd', 15, 2)->nullable();
            $table->boolean('negotiable')->default(true);
            $table->boolean('owner_financing')->default(false); // acepta financiamiento propietario
            $table->string('bank_options')->nullable();         // bancos sugeridos / avalúo

            // Comercial
            $table->string('status', 20)->default('active')->index(); // active | reserved | sold | archived
            $table->date('available_from')->nullable();
            $table->unsignedBigInteger('cover_photo_id')->nullable(); // FK opcional a product_photos

            // Contacto del anunciante (si no usás relación a usuarios)
            $table->unsignedBigInteger('user_id')->nullable()->index(); // dueño/anunciante (si usás users)
            $table->string('contact_name', 120)->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->string('contact_email', 120)->nullable();
            $table->string('contact_whatsapp', 30)->nullable();

            // SEO / publicación
            $table->string('seo_title', 180)->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->json('tags')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // índices compuestos útiles para búsqueda
            $table->index(['province','canton','district']);
            $table->index(['property_type','listing_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
