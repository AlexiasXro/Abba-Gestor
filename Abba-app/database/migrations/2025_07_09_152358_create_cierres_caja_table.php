<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCierresCajaTable extends Migration
{
    public function up()
    {
        Schema::create('cierres_caja', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique();
            $table->decimal('ingresos_efectivo', 10, 2)->default(0);
            $table->decimal('ingresos_tarjeta', 10, 2)->default(0);
            $table->decimal('egresos', 10, 2)->default(0);
            $table->decimal('monto_contado', 10, 2)->nullable();
            $table->decimal('diferencia', 10, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cierres_caja');
    }
}
