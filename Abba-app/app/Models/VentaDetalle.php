<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    //Modelo VentaDetalle (app/Models/VentaDetalle.php)
   protected $table = 'ventas_detalle'; //CORRECCIÓN
    use HasFactory;

    protected $fillable = [
        'venta_id', 'producto_id', 'talle_id', 'cantidad', 'precio_unitario', 'descuento', 'subtotal'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class)->withTrashed();
    }

    public function talle()
    {
        return $this->belongsTo(Talle::class);
    }
}