<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    protected $fillable = ['compra_id', 'producto_id', 'talle_id', 'cantidad', 'precio_unitario'];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function talle()
    {
        return $this->belongsTo(Talle::class);
    }
}
