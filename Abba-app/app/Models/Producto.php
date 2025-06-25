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
        'codigo', 'nombre', 'descripcion', 'precio', 'stock_minimo', 'activo', 'tipo'// ✅ Nuevo campo
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

    
}