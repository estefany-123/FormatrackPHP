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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->string('descripcion', 205)->nullable();
            $table->integer('cantidad')->nullable();
            $table->time('hora_ingreso')->nullable();
            $table->time('hora_salida')->nullable();
            $table->boolean('aceptado')->nullable();
            $table->boolean('en_proceso')->nullable();
            $table->boolean('cancelado')->nullable();
            $table->boolean('devolutivo')->nullable();
            $table->boolean('no_devolutivo')->nullable();
            $table->date('fecha_devolucion')->nullable();
            $table->string('lugar_destino')->nullable();
            $table->timestamps();

            $table->foreignId('fk_inventario')->constrained('inventarios', 'id_inventario')->onDelete('cascade');
            $table->foreignId('fk_sitio')->constrained('sitios', 'id_sitio')->onDelete('cascade');
            $table->foreignId('fk_tipo_movimiento')->constrained('tipos_movimientos', 'id_tipo')->onDelete('cascade');
            $table->foreignId('fk_usuario')->constrained('users', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
