<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Relación con propiedad
            $table->foreignId('property_id')->constrained('products')->cascadeOnDelete();

            // Si el usuario está logueado, podemos guardar su id (opcional)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Datos del interesado
            $table->string('interested_name');
            $table->string('interested_email')->nullable();
            $table->string('interested_phone')->nullable();

            // Tipo de reservación (visita presencial, virtual, llamada, etc.)
            $table->enum('type', ['visit', 'virtual', 'call'])->default('visit');

            // Fecha/hora de inicio y duración
            $table->dateTimeTz('reserved_at');
            $table->unsignedSmallInteger('duration_minutes')->default(30);

            // Estado de la reserva
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            // Notas opcionales
            $table->text('notes')->nullable();

            $table->timestamps();

            // Índices útiles
            $table->index(['property_id', 'reserved_at']);
        });

        // Opcional: índice funcional para acelerar "fin de evento" (MySQL/MariaDB permiten RAW)
        // Si tu motor no soporta índices funcionales, omite esto.
        try {
            DB::statement('CREATE INDEX reservations_reserved_end_idx ON reservations ((DATE_ADD(reserved_at, INTERVAL duration_minutes MINUTE)))');
        } catch (\Throwable $e) {
            // Silenciar si no soporta
        }
    }

    public function down(): void {
        Schema::dropIfExists('reservations');
    }
};
