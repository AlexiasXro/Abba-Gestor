<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CierreCaja extends Model
{
    protected $table = 'cierres_caja';

    protected $fillable = [
        'fecha',
        'monto_efectivo',
        'monto_cuotas',
        'monto_total',
        'observaciones',
    ];
}

