<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Importar SoftDeletes

class Producto extends Model
{
    //Abba-app/app/Models/Producto.php
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo', 
        'nombre', 
        'descripcion', 
        'precio', 
        'precio_base', 
        'precio_venta', 
        'precio_reventa', 
        'stock_minimo', 
        'activo', 
        'tipo'
        // ✅ Nuevos campos 'precio_base', 'precio_venta', 'precio_reventa'
    ];

    // Relación muchos a muchos con talles a través de la tabla pivote
    public function talles()
    {
        return $this->belongsToMany(Talle::class, 'producto_talle')
                    ->using(ProductoTalle::class)
                    ->withPivot('stock')
                    ->withTimestamps();
                    
    }

    // Relación directa con la tabla pivote
    public function productoTalles()
    {
        return $this->hasMany(ProductoTalle::class);
    }

    public function ventasDetalle()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    // Método para verificar stock por talle
    public function stockPorTalle($talleId)
    {
        return $this->talles()
            ->where('talle_id', $talleId)
            ->first()
            ?->pivot
            ?->stock ?? 0;
    }

    // Método para aplicar recargo
    public function aplicarRecargo(Request $request, Producto $producto)
{
    $request->validate([
        'porcentaje' => 'required|numeric|min:1|max:100',
    ]);

    $porcentaje = $request->porcentaje;

    // Si trabajás con precio_base como referencia
    if ($producto->precio_base) {
        $nuevoPrecio = $producto->precio_base * (1 + $porcentaje / 200);
        $producto->precio_venta = round($nuevoPrecio, 2);
        $producto->save();

        return back()->with('success', "Se aplicó un recargo del $porcentaje% al producto.");
    }

    return back()->with('error', 'Este producto no tiene precio base definido.');
}


}