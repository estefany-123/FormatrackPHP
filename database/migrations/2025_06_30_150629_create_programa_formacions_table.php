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
        Schema::create('programa_formacion', function (Blueprint $table) {
            $table->id('id_programa');
            $table->string('nombre', 70);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->foreignId('fk_area')->constrained('areas', 'id_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa_formacions');
    }
};
