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
        $table->date('fecha')->unique(); // un cierre por día

        // ingresos
        $table->decimal('ingreso_efectivo', 12, 2)->default(0);
        $table->decimal('ingreso_tarjeta', 12, 2)->default(0);
        $table->decimal('ingreso_cuotas', 12, 2)->default(0);
        $table->decimal('otros_ingresos', 12, 2)->default(0);

        // egresos
        $table->decimal('egresos', 12, 2)->default(0);

        // saldo final (ingresos - egresos)
        $table->decimal('saldo_dia', 12, 2)->default(0);

        $table->text('observaciones')->nullable();
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('cierres_caja');
    }
}
