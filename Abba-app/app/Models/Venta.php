<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //Modelo Venta (app/Models/Venta.php)
    use HasFactory;

    protected $fillable = [
    'cliente_id',
    'fecha_venta',
    'subtotal',
    'descuento',
    'total',
    'metodo_pago',
    'monto_pagado',   // <--- Agregar este campo
    'notas',
];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    public function cuotas()
{
    return $this->hasMany(Cuota::class);
}

}