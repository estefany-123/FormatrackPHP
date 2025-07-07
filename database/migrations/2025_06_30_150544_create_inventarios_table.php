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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id('id_inventario');
            $table->integer('stock')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->foreignId('fk_elemento')->constrained('elementos', 'id_elemento')->onDelete('cascade');
            $table->foreignId('fk_sitio')->constrained('sitios', 'id_sitio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
