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
        Schema::create('elementos', function (Blueprint $table) {
            $table->id('id_elemento');
            $table->string('nombre', 70)->nullable();
            $table->string('descripcion', 205)->nullable();
            $table->boolean('perecedero')->nullable();
            $table->boolean('no_perecedero')->nullable();
            $table->boolean('estado')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_uso')->nullable();
            $table->boolean('baja')->default(false);
            $table->string('imagen_elemento', 255)->nullable();
            $table->timestamps();
            $table->foreignId('fk_categoria')->constrained('categorias', 'id_categoria');
            $table->foreignId('fk_unidad_medida')->constrained('unidades_medida', 'id_unidad');
            $table->foreignId('fk_caracteristica')->nullable()->constrained('caracteristicas', 'id_caracteristica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos');
    }
};
