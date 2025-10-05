<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 1. Migración para la tabla productos (database/migrations/xxxx_create_productos_table.php)
     */

    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('tipo')->default('ropa');// ✅ Agregado
            $table->decimal('precio', 10, 2);
            $table->integer('stock_minimo')->default(3);
            $table->boolean('activo')->default(true);
            $table->foreignId('categoria_id')->constrained('categorias');
$table->foreignId('talle_id')->nullable()->constrained('talles');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
        
    }
};