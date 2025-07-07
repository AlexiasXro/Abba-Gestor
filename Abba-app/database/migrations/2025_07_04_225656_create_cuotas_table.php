<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuotasTable extends Migration
{
    public function up()
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained()->onDelete('cascade');
            $table->integer('numero'); // número de cuota (1, 2, 3...)
            $table->decimal('monto', 10, 2);
            $table->date('fecha_vencimiento');
            $table->boolean('pagada')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuotas');
    }
}
