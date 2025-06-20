<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //Modelo Producto (app/Models/Producto.php)
    use HasFactory;

    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'precio', 'stock_minimo', 'activo'
    ];

    public function talles()
    {
        return $this->belongsToMany(Talle::class, 'producto_talle')
                    ->withPivot('stock')
                    ->withTimestamps();
    }

    public function ventasDetalle()
    {
        return $this->hasMany(VentaDetalle::class);
    }
}