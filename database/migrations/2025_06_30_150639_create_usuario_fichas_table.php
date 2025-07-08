<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario_fichas', function (Blueprint $table) {
            $table->id('id_usuario_ficha');
            $table->timestamps();
            $table->foreignId('fk_ficha')->constrained('fichas', 'id_ficha');
            $table->foreignId('fk_usuario')->constrained('users', 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_fichas');
    }
};
