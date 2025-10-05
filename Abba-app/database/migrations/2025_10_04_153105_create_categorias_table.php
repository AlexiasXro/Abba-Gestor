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
        Schema::create('categorias', function (Blueprint $table) {
    $table->id();
    $table->string('nombre')->unique(); // Ej: Calzado, Ropa, Accesorios
    $table->boolean('usa_talle')->default(true); // Si la categoría usa talles
    $table->string('tipo_talle')->nullable(); // Ej: Calzado, Ropa
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
