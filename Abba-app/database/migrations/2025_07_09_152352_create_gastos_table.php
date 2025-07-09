<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastosTable extends Migration
{
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('descripcion');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago'); // efectivo, transferencia, tarjeta, etc.
            $table->string('proveedor')->nullable();
            $table->string('categoria')->nullable();
            $table->softDeletes(); // borrado lógico
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gastos');
    }
}
