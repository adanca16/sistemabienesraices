<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            // Ruta/URL de almacenamiento (S3, local, etc.)
            $table->string('disk', 40)->default('public'); // opcional
            $table->string('path');                         // ej: properties/123/imagen.jpg
            $table->string('url')->nullable();              // si sirves por CDN
            $table->string('caption', 180)->nullable();     // pie de foto / alt
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_cover')->default(false);

            // Metadatos
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('mime', 60)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();

            $table->timestamps();

            $table->index(['product_id','sort_order']);
            $table->index(['product_id','is_cover']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_photos');
    }
};
