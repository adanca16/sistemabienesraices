<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 160);
            $table->string('phone', 40)->nullable();
            $table->string('preferred_zone', 160)->nullable();
            $table->string('budget', 80)->nullable();
            $table->enum('listing_type', ['sale','rent','presale','project'])->nullable();
            $table->string('property_type', 60)->nullable();
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->string('subject', 180);
            $table->text('message');
            $table->string('ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('contact_messages');
    }
};
