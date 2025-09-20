<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajusta el tipo ENUM para incluir 'deleted'
        DB::statement("ALTER TABLE reservations 
            MODIFY COLUMN status ENUM('pending','confirmed','cancelled','deleted') 
            DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revertir: eliminar 'deleted' (vuelve al estado original)
        DB::statement("ALTER TABLE reservations 
            MODIFY COLUMN status ENUM('pending','confirmed','cancelled') 
            DEFAULT 'pending'");
    }
};
