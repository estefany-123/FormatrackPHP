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
        Schema::create('centros', function (Blueprint $table) {
            $table->id('id_centro');
            $table->string('nombre', 70)->nullable();
            $table->boolean('estado')->nullable();
            $table->timestamps();
            $table->foreignId('fk_municipio')->constrained('municipios', 'id_municipio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centros');
    }
};
