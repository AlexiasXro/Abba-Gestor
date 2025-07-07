<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $fillable = [
        'venta_id',
        'numero',
        'monto',
        'fecha_vencimiento',
        'pagada',
    ];

    // Relación inversa: una cuota pertenece a una venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
