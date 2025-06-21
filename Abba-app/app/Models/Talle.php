<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talle extends Model
{
    //Abba-app\app\Models\Talle.php
    use HasFactory;

    protected $fillable = ['talle'];

    // Relación muchos a muchos con productos a través de la tabla pivote
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_talle')
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
}