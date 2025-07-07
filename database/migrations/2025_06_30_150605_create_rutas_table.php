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
        Schema::create('rutas', function (Blueprint $table) {
            $table->id('id_ruta');
            $table->string('nombre', 205)->nullable();
            $table->string('descripcion', 205)->nullable();
            $table->string('href', 205);
            $table->string('icono', 205);
            $table->boolean('listed');
            $table->boolean('estado')->nullable();
            $table->timestamps();
            $table->foreignId('fk_modulo')->constrained('modulos', 'id_modulo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutas');
    }
};
