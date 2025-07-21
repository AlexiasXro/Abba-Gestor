<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionesTable extends Migration
{
    public function up()
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            
            // Relación con venta
            $table->unsignedBigInteger('venta_id');

            // Datos del producto y talle (redundantes pero útiles para auditoría)
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('talle_id');

            // Cantidad devuelta
            $table->integer('cantidad');

            // Fecha de la devolución
            $table->date('fecha')->default(now());

            // Tipo: devolucion o garantia
            $table->enum('tipo', ['devolucion', 'garantia']);

            // Motivo textual obligatorio
            $table->string('motivo_texto');

            // Observaciones opcionales
            $table->text('observaciones')->nullable();

            // Estado: activa o anulada
            $table->enum('estado', ['activa', 'anulada'])->default('activa');

            // Si se anula, guardar por qué
            $table->string('motivo_anulacion')->nullable();

            // Quién registró la devolución
            $table->unsignedBigInteger('usuario_id');

            $table->timestamps();

            // Claves foráneas
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('talle_id')->references('id')->on('talles');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('devoluciones');
    }
}
