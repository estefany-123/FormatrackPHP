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
        Schema::create('codigo_inventarios', function (Blueprint $table) {
            $table->id('id_codigo_inventario');
            $table->text('codigo');
            $table->boolean('uso')->default(false);
            $table->boolean('baja')->default(false);
            $table->timestamps();

            $table->foreignId('fk_inventario')->constrained('inventarios', 'id_inventario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigo_inventarios');
    }
};
