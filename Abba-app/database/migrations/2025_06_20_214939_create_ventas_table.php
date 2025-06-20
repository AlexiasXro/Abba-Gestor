<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 5. Migración para la tabla ventas (database/migrations/xxxx_create_ventas_table.php)
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained()->onDelete('set null');
            $table->dateTime('fecha_venta');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('metodo_pago');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};