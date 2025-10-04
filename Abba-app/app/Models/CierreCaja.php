<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CierreCaja extends Model
{
    protected $table = 'cierres_caja';

    protected $fillable = [
        'fecha',
        'ingreso_efectivo',
        'ingreso_tarjeta',
        'ingreso_cuotas',
        'otros_ingresos',
        'egresos',
        'saldo_dia',
        'observaciones',
    ];
}


