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
        Schema::create('sitios', function (Blueprint $table) {
            $table->id('id_sitio');
            $table->string('nombre', 70)->nullable();
            $table->string('persona_encargada', 70)->nullable();
            $table->string('ubicacion', 205)->nullable();
            $table->boolean('estado')->nullable();
            $table->timestamps();
            $table->foreignId('fk_area')->constrained('areas', 'id_area');
            $table->foreignId('fk_tipo_sitio')->constrained('tipo_sitios', 'id_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitios');
    }
};
